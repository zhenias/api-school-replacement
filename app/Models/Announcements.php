<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Backtrace\Arguments\ReducedArgument\TruncatedReducedArgument;

use function PHPUnit\Framework\callback;

use App\Models\AccessRights;

use App\Models\AccessAccountCore;

class Announcements extends Model
{
    use HasFactory;

    private $error = [
        "not_provide_uid" => "user_id required",
        "not_provide_text_or_url" => "text or url required",
        "not_provide_id_announcements" => "id_announcements required",
        "not_added_data" => "Data has not been added",
        "not_update_data" => "Data has not been update",
        "announcements_not_found" => "id_announcements not found",
        "err_max_size" => "The length exceeds the maximum number of characters in the text",
        "not_have_permission_this_post" => "You do not have permission to edit this post",
        "data_not_delete" => "Data has not been delete",
        "data_delete" => "Annoucement is delete"
    ];

    private $maxSizeText = 500;

    private $add24H = 60*60*24;

    public function createAnnouncments( int $user_id = null, ?string $text = null, ?string $url = null, ?int $start_date, ?int $end_date ) {

        if ( !$user_id ) {
            return callbacks( false, $this->error['not_provide_uid'], 400 );
        }

        $checkAccessRightsUser = new AccessRights();
        $checkAccessRightsUser = $checkAccessRightsUser->checkAccessRightsUser($user_id);

        if ( !$checkAccessRightsUser->original['ok'] ) {
            return $checkAccessRightsUser;
        }

        if ( !$text && !$url ) {
            return callbacks( false, $this->error['not_provide_text_or_url'], 400 );
        }

        if ( strlen($text) >= $this->maxSizeText ) {
            return callbacks(false, $this->error['err_max_size'], 400);
        }

        if ( !$start_date ) {
            $start_date = time();
        }

        if ( !$end_date ) {
            $end_date = time() + $this->add24H;
        }
        
        $createBuildAddToTable = [
            "id_announcements" => NULL,
            "text" => $text,
            "url" => $url,
            "personal_start_date" => $start_date,
            "personal_end_date" => $end_date,
            "datetime_add" => time(),
            "user_id" => $user_id
        ];

        $addToDB = DB::table("announcements")->insert($createBuildAddToTable);

        unset($createBuildAddToTable['id_announcements']);
        unset($createBuildAddToTable['user_id']);


        if ( !$addToDB ) {
            return callbacks(false, $this->error["not_added_data"], 400);
        }

        return callbacks(true, $createBuildAddToTable);

    }
    public function deleteAnnouncements( int $user_id, ?int $id_announcements ) {

        if ( !$id_announcements ) {
            return callbacks(false, $this->error['not_provide_id_announcements'], 400);
        }

        $checkAnnouncements = DB::table("announcements")->select([ 'id_announcements', 'user_id' ])->where( "id_announcements", $id_announcements )->first();

        if ( !$checkAnnouncements ) {
            return callbacks(false, $this->error['announcements_not_found'], 400);
        }

        if ( $checkAnnouncements->user_id != $user_id ) {
            return callbacks(false, $this->error['not_have_permission_this_post'], 400);
        }

        $delete = DB::table("announcements")->where("id_announcements", $id_announcements)->delete();

        if ( !$delete ) {
            return callbacks(true, $this->error["data_not_delete"]);
        }

        return callbacks(true, $this->error["data_delete"]);
    }
    public function updateAnnouncements( int $user_id, ?int $id_announcements, ?string $text, ?string $url, ?int $start_date = 0, ?int $end_date = 0 ) {

        if ( !$id_announcements ) {
            return callbacks(false, $this->error['not_provide_id_announcements'], 400);
        }

        

        $checkAnnouncements = DB::table("announcements")->select([ 'id_announcements', 'user_id' ])->where( "id_announcements", $id_announcements )->first();

        if ( !$checkAnnouncements ) {
            return callbacks(false, $this->error['announcements_not_found'], 400);
        }

        if ( $checkAnnouncements->user_id != $user_id ) {
            return callbacks(false, $this->error['not_have_permission_this_post'], 400);
        }

        if ( !$text && !$url ) {
            return callbacks( false, $this->error['not_provide_text_or_url'], 400 );
        }

        if ( strlen($text) >= $this->maxSizeText ) {
            return callbacks(false, $this->error['err_max_size'], 400);
        }

        if ( !$start_date ) {
            $start_date = time();
        }

        if ( !$end_date ) {
            $end_date = time() + $this->add24H;
        }

        $updateToTable = [
            "text" => $text,
            "url" => $url,
            "personal_start_date" => $start_date,
            "personal_end_date" => $end_date,
        ];

        $dbUpdate = DB::table("announcements")->where("id_announcements", $id_announcements)->update($updateToTable);

        if ( !$dbUpdate ) {
            return callbacks(false, $this->error['not_update_data'], 400);
        }

        return callbacks(true, $updateToTable);
    }

    public function updateAnnouncementsWithAccessToken( ?string $access_token, ?int $id_announcements, ?string $text, ?string $url, ?int $start_date, ?int $end_date ) {

        $AccessAccountCore_class = new AccessAccountCore();
        $AccessAccountCore = $AccessAccountCore_class->checkAccessToken($access_token);

        if ( !$AccessAccountCore->original['ok'] ) {
            return $AccessAccountCore;
        }

        $token_access = json_decode(json_encode($AccessAccountCore->original['message']), 1);

        $AccessRights = new AccessRights();
        $checkAccessU = $AccessRights->checkAccessRightsUser( $token_access['user_id'] );

        if ( !$checkAccessU->original['ok'] ) {
            return $checkAccessU;
        } 

        if ( !$AccessRights->is_edit_announcements() ) {
            return callbacks(false, "User does not have permissions", 400);
        }

        return $this->updateAnnouncements($token_access['user_id'], $id_announcements, $text, $url, $start_date, $end_date);

    }

    public function createAnnouncementsWithAccessToken( ?string $access_token, ?string $text, ?string $url, ?int $start_date = 0, ?int $end_date = 0) {

        $AccessAccountCore_class = new AccessAccountCore();
        $AccessAccountCore = $AccessAccountCore_class->checkAccessToken($access_token);

        if ( !$AccessAccountCore->original['ok'] ) {
            return $AccessAccountCore;
        }

        $token_access = json_decode(json_encode($AccessAccountCore->original['message']), 1);

        $AccessRights = new AccessRights();
        $checkAccessU = $AccessRights->checkAccessRightsUser( $token_access['user_id'] );

        if ( !$checkAccessU->original['ok'] ) {
            return $checkAccessU;
        } 

        if ( !$AccessRights->is_insert_announcements() ) {
            return callbacks(false, "User does not have permissions", 400);
        }

        return $this->createAnnouncments($token_access['user_id'], $text, $url, $start_date, $end_date);

    }

    public function deleteAnnouncementsWithAccessToken( ?string $access_token, ?int $id_announcements) {

        $AccessAccountCore_class = new AccessAccountCore();
        $AccessAccountCore = $AccessAccountCore_class->checkAccessToken($access_token);

        if ( !$AccessAccountCore->original['ok'] ) {
            return $AccessAccountCore;
        }

        $token_access = json_decode(json_encode($AccessAccountCore->original['message']), 1);

        $AccessRights = new AccessRights();
        $checkAccessU = $AccessRights->checkAccessRightsUser( $token_access['user_id'] );

        if ( !$checkAccessU->original['ok'] ) {
            return $checkAccessU;
        } 

        if ( !$AccessRights->is_delete_announcements() ) {
            return callbacks(false, "User does not have permissions", 400);
        }

        return $this->deleteAnnouncements($token_access['user_id'], $id_announcements);

    }

    public function ViewData(?int $id_annoncements) {
        $now = time();
        if ( !$id_annoncements ) { 
            $annoncements = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.user_id')->select( [ 'users.user_name', 'users.user_lastname', 'announcements.id_announcements', 'announcements.text', 'announcements.url', 'announcements.personal_start_date', 'announcements.personal_end_date', 'announcements.datetime_add' ] )
            ->where('personal_start_date', '<=', $now)
            ->where('personal_end_date', '>=', $now)
            ->where('personal_start_date', '<=', $now)
            ->where('personal_end_date', '>=', $now)
            ->get();
        }else {
            $annoncements = DB::table('announcements')->join('users', 'announcements.user_id', '=', 'users.user_id')->select( [ 'users.user_name', 'users.user_lastname', 'announcements.id_announcements', 'announcements.text', 'announcements.url', 'announcements.personal_start_date', 'announcements.personal_end_date', 'announcements.datetime_add' ] )->where("announcements.id_announcements", $id_annoncements)
            ->where('personal_start_date', '<=', $now)
            ->where('personal_end_date', '>=', $now)
            ->where('personal_start_date', '<=', $now)
            ->where('personal_end_date', '>=', $now)
            ->first();

        }
        return callbacks(true, $annoncements);
    }

}