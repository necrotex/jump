<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login()
    {
        try {
            return Socialite::driver('eveonline')
                ->scopes(['characterLocationRead', 'characterNavigationWrite'])
                ->redirect();
        } catch (Exception $e) {
            return redirect('/login');
        }
    }

    public function callback()
    {
        try {
            $ssoUser = Socialite::driver('eveonline')->user();
        } catch (InvalidStateException $e) {
            return redirect('/login');
        }

        // Get more detailed character data from CREST
        $httpClient = new Client();
        $url = "https://crest-tq.eveonline.com/characters/$ssoUser->id/";

        try {
            $response = $httpClient->get($url);
        } catch (Exception $exception) {
            return redirect('/error')->with(['message' => 'CREST not reachable. Try again later']);
        }

        $character = json_decode($response->getBody()->getContents());

        // Check if user exists
        $user = User::firstOrNew(['character_id' => $character->id]);

        // And then update the data in case something changed
        $user->corporation_id = $character->corporation->id;
        $user->corporation_name = $character->corporation->name;
        $user->name = $character->name;
        $user->owner_hash = $ssoUser->owner_hash;
        $user->refresh_token = $ssoUser->refreshToken;
        $user->save();

        // and then log in
        Auth::login($user, true);
        return redirect()->intended('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
