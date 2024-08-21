<?php

use App\Events\Hello;
use App\Events\TestName;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::routes(['middleware' => ['auth:api']]);


Route::post('/register',[userController::class,'register']);
Route::post('/login',[userController::class,'login']);



Route::middleware('auth:api')->group(function () {

    Route::get('/logout',[userController::class,'logout']);

    //user
    Route::get('/get_user',[userController::class,'get_user']);
    Route::get('/get_all_user',[userController::class,'get_all_user']);
    Route::get('/all_user',[userController::class,'all_user']);
    Route::get('/get_recepteur/{id}',[userController::class,'get_recepteur']);
    Route::post('/send_ligne',[userController::class,'send_ligne']);

    //messages
    Route::get('/get_all_messages/{id}',[MessageController::class,'get_all_messages']);
    Route::post('/statut_messages',[MessageController::class,'statut_messages']);
    Route::post('/send_message',[MessageController::class,'send_message']);
    Route::post('/send_write',[MessageController::class,'send_write']);
    
    
});


Route::get('/test_public',function(){

    broadcast(new Hello());
    return "Event has been sent!";
});

Route::get('/test_priver/{id}',function($id){
    $user = App\Models\User::find($id);
    // broadcast(new TestName($user));
    return $user;
});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
