<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController;
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

Route::get('/api/users/search', [AdminUserController::class, 'search']);

Route::put('/api/users/{user}',[AdminUserController::class, 'update']);

Route::patch('/api/users/{user}/change-role', [AdminUserController::class, 'changeRole']);

Route::delete('api/users/{user}', [AdminUserController::class, 'destory']); 

// Route::get('{view}', ApplicationController::class)->where('view','(.*)');

// Route::get('/admin/dashboard', function(){
//     return view('dashboard');
// });

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ProductController::class, 'index'])->name('product.create');

Route::get('/product/create',[ProductController::class, 'index'])->name('product.create');
Route::post('/product/store',[ProductController::class, 'store'])->name('product.store');
Route::post('uploads', [ProductController::class,'uploads'])->name('uploads');
Route::post('image/delete',[ProductController::class,'fileDestroy']);
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