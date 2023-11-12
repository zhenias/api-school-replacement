<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    use App\Models\AccessAccountCore as AccessAccount;

    use function PHPUnit\Framework\callback;
    use App\Models\Announcements as Announcement;

    class Announcements extends Controller {

        public function updateAnnouncementsWithAccessTokenRequest(Request $request) {
            $Announcements = new Announcement();
            return $Announcements->updateAnnouncementsWithAccessToken(
                $request->access_token, 
                $request->id_announcements, 
                $request->text, 
                $request->url, 
                $request->start_date, 
                $request->end_date
            );
        }

        public function createAnnouncementsWithAccessTokenRequest(Request $request) {
            $Announcements = new Announcement();
            return $Announcements->createAnnouncementsWithAccessToken(
                $request->access_token, 
                $request->text, 
                $request->url, 
                $request->start_date, 
                $request->end_date
            );
        
        }

        public function deleteAnnouncementsWithAccessTokenRequest(Request $request) {
            $Announcements = new Announcement();
            return $Announcements->deleteAnnouncementsWithAccessToken(
                $request->access_token, 
                $request->id_announcements
            );
        
        }

        public function ViewData(?int $id_annoncements = null) {
            $Announcements = new Announcement();
            return $Announcements->ViewData($id_annoncements);
        }

    }