<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Account;
use App\Http\Controllers\AccessRights;
use App\Http\Controllers\Announcements;

use function PHPUnit\Framework\callback;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
*     return $request->user();
* });
*/

function callbacks(bool $ok = true, $message = [], $status = 200) 
{

    $messages = [
        "ok" => $ok,
        "status" => $status,
        "message" => $message
    ];
    
    return response($messages, $status);

}

Route::get( '' , function() {
    return callbacks(false, "Bad request", 400);
});

Route::prefix('Account')->group(function () {

    Route::post( '/Authorize', [ Account::class , 'Authorization' ] );
    Route::post( '/RefreshToken', [ Account::class , 'refreshToken' ] );
    
});

Route::prefix('AccessRights')->group(function () {

    Route::post( '/Edit', [ AccessRights::class , 'updateAccessRightsWithAccessToken' ] );
    Route::get( '/View', [ AccessRights::class , 'ViewDataAccessRights' ] );
    Route::get( '/View/{id_access}', [ AccessRights::class , 'ViewDataAccessRights' ] );
});

Route::prefix('Announcements')->group(function () {

    Route::get( '/View', [ Announcements::class , 'ViewData' ] );
    Route::get( '/View/{id_annoncements}', [ Announcements::class , 'ViewData' ] );

    Route::post( '/Edit', [ Announcements::class , 'updateAnnouncementsWithAccessTokenRequest' ] );
    Route::post( '/Create', [ Announcements::class , 'createAnnouncementsWithAccessTokenRequest' ] );
    Route::post( '/Delete', [ Announcements::class , 'deleteAnnouncementsWithAccessTokenRequest' ] );
    
});