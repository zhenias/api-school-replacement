<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    use App\Models\AccessAccountCore as AccessAccount;
    use App\Models\AccessRights as AccessR;

    class AccessRights extends Controller {

        public function updateAccessRightsWithAccessToken(Request $request) {

            $newAccessRights = new AccessR;

            return $newAccessRights->updatePermissionWithAccessTokenUser( $request->access_token, $request->id_access, [
                "is_edit_access_rights" =>  $request['is_edit_access_rights'],
                "is_delete_access_rights" =>  $request['is_delete_access_rights'],
                "is_insert_access_rights" =>  $request['is_insert_access_rights'],
                "is_edit_announcements" =>  $request['is_edit_announcements'],
                "is_delete_announcements" =>  $request['is_delete_announcements'],
                "is_insert_announcements" =>  $request['is_insert_announcements'],
                "is_edit_users" =>  $request['is_edit_users'],
                "is_delete_users" =>  $request['is_delete_users'],
                "is_edit_logo" =>  $request['is_edit_logo'],
                "is_edit_name_website" => $request['is_edit_name_website']
            ] );

        }

        public function ViewDataAccessRights( ?int $id_access = null) {

            $newAccessRights = new AccessR;

            return $newAccessRights->ViewDataAccessRights($id_access);
            
        }

    }