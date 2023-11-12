<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    use App\Models\AccessAccountCore as AccessAccount;

    class Account extends Controller {

        public function __constructor(string|null $access_token, string|null $refresh_token) {

        }

        public function AuthorizationProvide(string $login, string $password) {

            $AccessAccount = new AccessAccount();

            return $AccessAccount->assigningAccessToken($login, $password);
            
        }

        public function Authorization(Request $request) {

            
            $AccessAccount = new AccessAccount();

            return $AccessAccount->assigningAccessToken( $request->login, $request->password );
            
        }

        public function refreshTokenProvide(string $refresh_token) {

            $AccessAccount = new AccessAccount();

            return $AccessAccount->refreshTokenForUser($refresh_token);
            
        }

        public function refreshToken(Request $request) {

            $AccessAccount = new AccessAccount();

            return $AccessAccount->refreshTokenForUser($request->refresh_token);
            
        }

    }