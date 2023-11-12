<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Backtrace\Arguments\ReducedArgument\TruncatedReducedArgument;

use function PHPUnit\Framework\callback;

use App\Models\Settings;

class AccessAccountCore extends Model
{
    use HasFactory;

    private $error = [
        "User not found",
        "User is not active",
        "User does not have permissions",
        "user_id required",
        "Data has not been added",
        "login required",
        "password required",
        "login or password incorrect",
        "login and password required",
        "refresh_token not found",
        "Data has not been update",
        "refresh_token required",
        "User is blocked, and does not have permission to login",
        "Login failed",
        "Failed to log in after so many failed login attempts",
        "access_token required",
        "access_token has expired"
    ];

    private $plusTimeAdd = 60 * 45;

    private $lenght_refresh_token = 130;
    private $lenght_access_token = 80;

    private $maxLoginFailed = 3;

    public function refreshTokenForUser( ?string $refresh_token ) {

        if ( !$refresh_token ) {
            return callbacks( false, $this->error[11], 400);
        }

        $db = DB::table("access_token")->select([ 'user_id', 'expirens_time' ])->where("refresh_token", $refresh_token)->first();

        if ( !$db ) {
            return callbacks( false, $this->error[9], 404 );
        }

        $checkUser = $this->checkUser( $db->user_id );

        if ( !$checkUser->original['ok'] ) {
            return $checkUser;
        }

        $refresh_token_new = Str::random($this->lenght_refresh_token);
        $time = time() + $this->plusTimeAdd;

        $updateAccessToken = [
            'refresh_token' => $refresh_token_new,
            'expirens_time' => $time
        ];

        $update = DB::table("access_token")->where("refresh_token", $refresh_token)->update($updateAccessToken);

        if ( !$update ) {

            return callbacks( false, $this->error[10], 400 );

        }

        return callbacks( true, $updateAccessToken );

    }

    public function checkAccessToken( ?string $access_token ) {

        if ( !$access_token ) {
            return callbacks( false, $this->error[15], 400 );
        }

        $dbSelect = DB::table("access_token")->select([ 'user_id', 'expirens_time' ])->where("access_token", $access_token)->first();

        if ( !$dbSelect ) {
            return callbacks( false, $this->error[16], 401 );
        }

        if ( $dbSelect->expirens_time <= time() ) {
            return callbacks( false, $this->error[16], 401 );
        }

        return callbacks( true, $dbSelect );
    }

    private function addLogsForUser(int $user_id, int $is_success) {

        $paramsCreateAdd = [
            "id_logs" => NULL,
            "user_id" => $user_id,
            "datetime_add" => time(),
            "is_success" => $is_success
        ];

        $addDB = DB::table("logs")->insert($paramsCreateAdd);

        if ( !$addDB ) {
            return callbacks( false, $this->error[13], 400 );
        }

        unset($paramsCreateAdd['id_logs']);
        unset($paramsCreateAdd['user_id']);
        unset($paramsCreateAdd['datetime_add']);


        return callbacks(true, $paramsCreateAdd);

    }

    private function CheckFailedAccountLoginAttempts(int $user_id) { // Liczba nie udanych prób logowań.

        $count = DB::table("logs")->where("user_id", $user_id)->where("is_success", 0)->count();

        $Settings = new Settings;
        $Settings = $Settings->settings();
        
        
        if ( !$Settings ) {
            $howCountFailed = $this->maxLoginFailed;
        }else {
            $howCountFailed = $Settings->how_many_failed_login_attempts;
        }

        if ( $count >= $howCountFailed ) {
            return callbacks( false, $this->error[14], 400 );
        }
        
        return callbacks(true);
    }

    private function createTokenForUser(int $user_id) {

        $user = $this->checkUser($user_id);

        if ( !$user->original['ok'] ) {

            return $user;

        }else {

            $access_token = Str::random($this->lenght_access_token);
            $refresh_token = Str::random($this->lenght_refresh_token);

            $time = time() + $this->plusTimeAdd;

            $paramsAddDB = [
                "id_token" => NULL,
                "access_token" => $access_token,
                "refresh_token" => $refresh_token,
                "expirens_time" => $time,
                "user_id" => $user_id
            ];

            $addNewDB = DB::table("access_token")->insert($paramsAddDB);

            if ( !$addNewDB ) {
                return callbacks( false, $this->error[4], 400 );
            }

            $paramsAddDB['datetime_expirens'] = date("Y-m-d H:i:s", $paramsAddDB['expirens_time']);
            $paramsAddDB['actual_datetime'] = date("Y-m-d H:i:s");

            unset($paramsAddDB['id_token']);
            unset($paramsAddDB['user_id']);

            return callbacks(true, $paramsAddDB);

        }

    }


    public function checkUser(int $user_id) {

        if ( !$user_id ) {
            return callbacks(false, $this->error[3]);
        }

        $user = DB::table("users")->select([ 
            'user_id', 
            'is_active',
            'is_blocked', 
            'id_access',
            'user_name',
            'user_lastname',
            'login',
            'email'
        ])->where("user_id", $user_id)->first();

        if ( !$user ) {

            return callbacks( false, $this->error[0], 404 );

        }else if ( !$user->is_active ) {

            return callbacks( false, $this->error[1], 403 );

        }else if ( $user->is_blocked ) {

            return callbacks( false, $this->error[12], 403 );

        }else if ( !$user->id_access ) {

            return callbacks( false, $this->error[2], 403 );

        }

        return callbacks( true, $user );

    }

    private function checkPassword(int $user_id, string $password): bool {
        $checkPass = DB::table("users")
            ->select(['user_id', 'password'])
            ->where("user_id", $user_id)
            ->first(); // używamy first(), aby uzyskać pierwszy pasujący rekord
    
        if ( !$checkPass ) {
            return false;
        }
    
        if ( password_verify( $password, $checkPass->password ) ) {
            return true;
        }
    
        return false;
    }
    

    public function assigningAccessToken(string|null $login, string|null $password) {
        if ( !$login && !$password ) {
            return callbacks( false, $this->error[8], 400 );
        }else if ( !$login ) {
            return callbacks( false, $this->error[5], 400 );
        } elseif ( !$password ) {
            return callbacks( false, $this->error[6], 400 );
        }
    
        $user = DB::table("users")
            ->select(['user_id', 'password'])
            ->where("login", $login)
            ->first(); // używamy first(), aby uzyskać pierwszy pasujący rekord
    
        // Jeżeli nie ma użytkownika
        if (!$user) {
            return callbacks(false, $this->error[0], 404);
        }
        
        $CheckFailedAccountLoginAttempts = $this->CheckFailedAccountLoginAttempts($user->user_id);

        if ( !$CheckFailedAccountLoginAttempts->original['ok'] ) {
            return $CheckFailedAccountLoginAttempts;
        }

        // Sprawdzenie czy hasło jest poprawne
        $checkPass = $this->checkPassword( $user->user_id, $password );
    
        // Jeżeli nie, poprawne hasło.
        if (!$checkPass) {
            $this->addLogsForUser( $user->user_id, 0 );
            return callbacks( false, $this->error[0], 400 );
        }else {
            $this->addLogsForUser( $user->user_id, 1 );
        }
    
        return $this->createTokenForUser( $user->user_id );
    }
    

}
