<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->paginate(5);
        // $users = User::latest()->get();
        // $users = User::latest()->get()->map(function ($user){
        //     return [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         'created_at' => $user->created_at->toFormattedDate(),//serviceProvider
        //         // 'created_at' => $user->created_at->format(config('app.date_format')),//model
        //         // 'created_at' => $user->created_at->format('Y-m-d'),//config
        //     ];
        // });
        return $users;
    }

    public function store(){
        request()->validate([
            'email' => 'required|unique:users,email',
        ]);
       return User::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'password'=>bcrypt(request('password'))
       ]);
    }

    public function update(User $user) {
        request()->validate([
            'email' => 'required|unique:users,email,'.$user->id,
        ]);
         $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')): $user->password
        ]);
        return $user;
    }

    public function changeRole(User $user) {
        $user->update([
            'role'=>request('role')
        ]);
        return response()->json(['success'=>true]);
    }

    public function destory(User $user){
        $user->delete();
        return response()->noContent();
    }

    public function search(){
        $searchQuery = request('query');
        // $users = User::where('name','like',"%{$searchQuery}%")->get();
        $users = User::where('name','like',"%{$searchQuery}%")->paginate(5);
        return response()->json($users);
    }
}
