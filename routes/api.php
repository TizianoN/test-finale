<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/test', function () {
    return 'testapi succed' ;
});

Route::match(['post','put'], '/server/create' , [ ApiController::class , 'addServer'] );

Route::get( '/server/{sid}/get' , [ ApiController::class , 'getServerById' ] );

Route::get( '/server/all' , [ ApiController::class , 'getAllServers' ] );

Route::get( '/vps/{sid}/all' , [ ApiController::class , 'getVPSOfServer' ] );

Route::get( '/server/search/{name}' , [ ApiController::class , 'getServerByName'] );

Route::match( ['post','put'], '/server/{sid}/add/vps' , [ ApiController::class , 'createVPS'] );

Route::get( '/vps/{sid}/delete' , [ ApiController::class , 'deleteVPS'] );

Route::get( '/server/{sid}/delete' , [ ApiController::class , 'deleteServer'] );

Route::get( '/server/{sid}/ram/available' , [ ApiController::class , 'getAvailableRam'] );

Route::fallback(function () {
    return 'Not allowed.';
});
