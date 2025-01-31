<?php

namespace App\Http\Controllers\User;

use App\Models\Notification;
use App\Models\SocialProvider;
use App\Models\Socialsetting;
use App\Models\User;
use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Auth;
use Socialite;

class SocialRegisterController extends Controller
{

    public function __construct()
    {
        $link = Socialsetting::findOrFail(1);
        Config::set('services.google.client_id', $link->gclient_id);
        Config::set('services.google.client_secret', $link->gclient_secret);
        Config::set('services.google.redirect', url('/auth/google/callback'));
        Config::set('services.facebook.client_id', $link->fclient_id);
        Config::set('services.facebook.client_secret', $link->fclient_secret);
        $url = url('/auth/facebook/callback');
        $url = preg_replace("/^http:/i", "https:", $url);
        Config::set('services.facebook.redirect', $url);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();
        if (!$socialProvider) {

            //create a new user and provider
            $user = new User;
            $user->email = $socialUser->email;
            $user->name = $socialUser->name;
            $user->photo = $socialUser->avatar_original;
            $user->email_verified = 'Yes';
            $user->is_provider = 1;
            $user->affilate_code = $socialUser->name . $socialUser->email;
            $user->affilate_code = md5($user->affilate_code);
            $user->save();

            $user_id = $user->id;
            $socialProvider = new SocialProvider();
            $socialProvider->provider_id = $socialUser->getId();
            $socialProvider->provider = $provider;
            $socialProvider->user_id = $user_id;
            $socialProvider->save();

            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->save();
        } else {
            $user = $socialProvider->user;
        }

        Auth::login($user);

        return redirect()->route('buyer.dashboard');
    }
}
