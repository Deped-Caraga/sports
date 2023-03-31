<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;

use function Livewire\str;

class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $user_email = $user->email;

            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/dashboard');
            } else {

                //return Socialite::driver('facebook')->user()->getAvatar();

                $fb_details = [];
                $fb_details['email'] = $user->email;
                $fb_details['name'] = $user->name;
                $fb_details['id'] = $user->id;
                $fb_details['avatar'] = $user->avatar;
                $fb_details['nickname'] = $user->nickname;

                // return dd($fb_details);
                //check first if there is a user with the same email but no google ID

                $finduser2 = User::where('email', $user_email)->first();
                if ($finduser2) {
                    $finduser2->facebook_id = $user->id;
                    $finduser2->save();
                    Auth::login($finduser2);
                    return redirect()->intended('/');
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'facebook_id' => $user->id,
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
