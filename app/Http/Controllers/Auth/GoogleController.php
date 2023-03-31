<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $user_email = $user->email;

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/dashboard');
            } else {
                //return $user->email. "TEST";
                //check first if there is a user with the same email but no google ID

                $finduser2 = User::where('email', $user_email)->first();
                if ($finduser2) {
                    $finduser2->google_id = $user->id;
                    $finduser2->save();
                    Auth::login($finduser2);
                    return redirect()->intended('/');
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'password' => encrypt(Str::random(20)),
                    ]);

                    Auth::login($newUser);
                    return redirect()->intended('/');
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
