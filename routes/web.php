<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Events\PUsherBroadcast;

Route::get('/chat',function(){
    return view('chat');
});

Route::post('send-message', function(Request $request){
    event(new PUsherBroadcast($request->username, $request->message));
    return ['success'=>true];
});

use App\Http\Controllers\UserController;

Route::get('birthday-wish',[UserController:: class,'index']);