<?php

use App\Events\Hello;
use App\Events\TestName;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/broadcast',function(){

    broadcast(new Hello());
    return "Event has been sent!";
});

Route::get('/broadcastPrivate/{id}',function($id){
    $user = App\Models\User::find($id);
    broadcast(new TestName($user));
    return "Event has been sent!";
});

Route::get('/', function () {
    return view('welcome');
});
