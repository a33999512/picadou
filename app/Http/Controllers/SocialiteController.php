<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Session;
use Log;
use App\Services\FacebookAccountService;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(FacebookAccountService $service)
    {
        // $auth_user = Socialite::driver('facebook')->user();
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        // dd($user);

        // $user = User::updateOrCreate(
        //     [
        //         'email' => $auth_user->email
        //     ],
        //     [
        //         'token' => $auth_user->token,
        //         'name'  =>  $auth_user->name
        //     ]
        // );

        Auth::login($user, true);
        $previous = Session::pull('oldUrl');
        if($previous) {
            Log::info('Login-oldUrl: ' . Session::get('oldUrl'));
            return redirect()->to($previous);
        }

        return redirect()->to('home'); // Redirect to a secure page
    }
}
