<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    protected $fillable = ['character_id', 'name', 'owner_hash', 'refresh_token', 'corporation_id'];
    protected $hidden = ['refresh_token', 'remember_token'];

    public function getAccessToken() {

        $token = session('access_token');

        if(is_null($token) || $token['expire']->lt(Carbon::now())) {
            $httpClient = new Client();
            $response = $httpClient->post('https://login.eveonline.com/oauth/token', [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(env('EVEONLINE_CLIENT_ID') . ':' . env('EVEONLINE_CLIENT_SECRET'))
                ],
                'json' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => Auth::user()->refresh_token
                ]
            ]);

            $data = json_decode($response->getBody()->getContents());

            $token = [
                'expire' => Carbon::now()->addMinute($data->expires_in),
                'token' => $data->access_token
            ];

            $token = session('access_token', $token);
        }

        return $token['token'];
    }
}
