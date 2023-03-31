<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    function login(Request $request)
    {
        $yourUsername = $request->yourUsername;
        $yourPassword = $request->yourPassword;
        $user = User::where('email', $yourUsername)->first();
        if ($user && Hash::check($yourPassword, $user->password)) {
            Auth::login($user);
            return "success";
        } else {
            return "Account not found.";
        }
    }
}
