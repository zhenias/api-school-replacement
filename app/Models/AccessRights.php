<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Backtrace\Arguments\ReducedArgument\TruncatedReducedArgument;

use function PHPUnit\Framework\callback;
use App\Models\AccessAccountCore;



class AccessRights extends Model
{
    use HasFactory;

    private $error = [
        "id_access not found",
        "id_access required",
        "Data has not been update",
        "You do not have permissions to edit the data"
    ];

    private $access_rights;

    public function checkAccessRightsUser( int $user_id ) {

        $AccessAccountCore = new AccessAccountCore;
        $AccessAccountCore = $AccessAccountCore->checkUser($user_id);

        if ( !$AccessAccountCore->original['ok'] ) {
            return $AccessAccountCore;
        }

        $AccessAccountCore = json_decode(json_encode($AccessAccountCore->original['message']), 1);

        return $this->accessRights($AccessAccountCore['id_access']);

    }

    public function accessRights( int $id_access ) {

        if ( !$id_access ) {
            return callbacks( false, $this->error[1] );
        }

        $access_table = DB::table("access_rights")->where("id_access", $id_access)->first();

        if ( !$access_table ) {
            return callbacks( false, $this->error[0] );
        }
        
        $this->access_rights = $access_table;
        
        return callbacks( true, $access_table );

    }

    public function getName():string {

        return $this->access_rights->name_access;

    }

    public function is_edit_access_rights():bool {

        if ( !$this->access_rights->is_edit_access_rights )
        {
            return false;
        }

        return true;
    }

    public function is_delete_access_rights():bool {

        if ( !$this->access_rights->is_delete_access_rights )
        {
            return false;
        }

        return true;
    }

    public function is_insert_access_rights():bool {

        if ( !$this->access_rights->is_insert_access_rights )
        {
            return false;
        }

        return true;
    }

    public function is_edit_announcements():bool {

        if ( !$this->access_rights->is_edit_announcements )
        {
            return false;
        }

        return true;
    }

    public function is_delete_announcements():bool {

        if ( !$this->access_rights->is_delete_announcements )
        {
            return false;
        }

        return true;
    }

    public function is_insert_announcements():bool {

        if ( !$this->access_rights->is_insert_announcements )
        {
            return false;
        }

        return true;
    }

    public function is_edit_users():bool {

        if ( !$this->access_rights->is_insert_announcements )
        {
            return false;
        }

        return true;
    }

    public function is_delete_users():bool {

        if ( !$this->access_rights->is_insert_announcements )
        {
            return false;
        }

        return true;
    }

    public function is_insert_users():bool {

        if ( !$this->access_rights->is_insert_users )
        {
            return false;
        }

        return true;
    }

    public function is_edit_logo():bool {

        if ( !$this->access_rights->is_edit_logo )
        {
            return false;
        }

        return true;
    }

    public function is_edit_name_website():bool {

        if ( !$this->access_rights->is_edit_name_website )
        {
            return false;
        }

        return true;
    }

    public function is_edit_this_id_access():bool {

        if ( !$this->access_rights->is_edit_this_id_access )
        {
            return false;
        }

        return true;
    }

    public function checkHasProvide(int|string|null $input, int|string|null $default = 0) {
        // Jezeli wartosc isnieje i nie jest pusta, to wtedy zwraca $input
        if ( isset($input) && !empty($input) ) {
            return $input;
        }
        // A jezeli jest pusta, to wtedy $default
        return $default;

    }

    protected function updateAccessRights(int $id_access, array $permission) {

        $accessRightss = $this->accessRights( $id_access );

        if ( !$accessRightss->original['ok'] ) {
            return $accessRightss;
        }

        /*
        if ( !$this->is_edit_this_id_access() || !$this->is_edit_access_rights() ) {
            return callbacks(false, $this->error[3], 400);
        }*/


        $updatePermissionBuild = [
            "is_edit_access_rights" => $this->checkHasProvide( $permission['is_edit_access_rights'], $this->is_edit_access_rights() ),
            "is_delete_access_rights" => $this->checkHasProvide( $permission['is_delete_access_rights'], $this->is_delete_access_rights() ),
            "is_insert_access_rights" => $this->checkHasProvide( $permission['is_insert_access_rights'], $this->is_insert_access_rights() ),
            "is_edit_announcements" => $this->checkHasProvide( $permission['is_edit_announcements'], $this->is_edit_announcements() ),
            "is_delete_announcements" => $this->checkHasProvide( $permission['is_delete_announcements'], $this->is_delete_announcements() ),
            "is_insert_announcements" => $this->checkHasProvide( $permission['is_insert_announcements'], $this->is_insert_announcements() ),
            "is_edit_users" => $this->checkHasProvide( $permission['is_edit_users'], $this->is_edit_users() ),
            "is_delete_users" => $this->checkHasProvide( $permission['is_delete_users'], $this->is_delete_users() ),
            "is_edit_logo" => $this->checkHasProvide( $permission['is_edit_logo'], $this->is_edit_logo() ),
            "is_edit_name_website" => $this->checkHasProvide( $permission['is_edit_name_website'], $this->is_edit_name_website() )
        ];

        $dbUpdate = DB::table("access_rights")
                        ->where("id_access", $id_access)
                        ->update($updatePermissionBuild);

        if ( !$dbUpdate ) {
            return callbacks(false, $this->error[2], 400);
        }

        return callbacks(true, $updatePermissionBuild, 200);
    }

    public function updateAccessRights_Final(int|null $user_id, int $id_access, array $permission) {

        $AccessAccountCore_class = new AccessAccountCore;
        $AccessAccountCore = $AccessAccountCore_class->checkUser($user_id);

        if ( !$AccessAccountCore->original['ok'] ) {
            return $AccessAccountCore;
        }

        $AccessAccountCore = json_decode(json_encode($AccessAccountCore->original), 1);

        $this->accessRights( $AccessAccountCore['message']['id_access'] );

        if ( !$this->is_edit_this_id_access() && !$this->is_edit_access_rights() || !$this->is_edit_access_rights() ) {
            return callbacks(false, $this->error[3], 400);
        }

        return $this->updateAccessRights( $id_access, $permission );

    }

    public function updatePermissionWithAccessTokenUser(string|null $access_token, int|null $id_access, array $permission) {

        $AccessAccountCore_class = new AccessAccountCore();
        $AccessAccountCore = $AccessAccountCore_class->checkAccessToken($access_token);

        if ( !$AccessAccountCore->original['ok'] ) {
            return $AccessAccountCore;
        }

        $user_id = $AccessAccountCore;

        $uid = json_decode(json_encode($user_id->original['message']), 1);

        return $this->updateAccessRights_Final($uid['user_id'], $id_access, $permission);

    }

    public function ViewDataAccessRights(?int $id_access) {
        
        if ( !$id_access ) { 
            $annoncements = DB::table('access_rights')->get();
        }else {
            $annoncements = DB::table('access_rights')->where("id_access", $id_access)->first();

        }
        return callbacks(true, $annoncements);
    }

}