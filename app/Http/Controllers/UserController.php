<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\BirthdayWish;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request) {
        $user=User::find(1);
        $message['title']="Hey, Happy Birthday {$user->name}";
        $message['wish']="On behalf of the entire company I wish you a very happy birthday and you. My best wishes for much happiness in your life.";
        $user->notify(new BirthdayWish($message));
        dd("Send");
    }
}
