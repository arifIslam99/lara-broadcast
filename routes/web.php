<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ApplicationController;
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
Route::get('/api/users', [AdminUserController::class, 'index']);

Route::post('/api/users',[AdminUserController::class, 'store']);

Route::put('/api/users/{user}',[AdminUserController::class, 'update']);

Route::get('{view}', ApplicationController::class)->where('view','(.*)');

// Route::get('/admin/dashboard', function(){
//     return view('dashboard');
// });

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

// Route::get('birthday-wish',[UserController:: class,'index']);