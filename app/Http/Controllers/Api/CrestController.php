<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CrestController extends Controller
{
    protected $httpClient;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->httpClient = new Client([
                'base_uri' => 'https://crest-tq.eveonline.com/',
                'headers' => [
                    'Authorization' => 'Bearer ' . Auth::user()->getAccessToken()
                ]
            ]);

            return $next($request);
        });
    }

    public function getLocation(Request $requests)
    {

        $uri =  '/characters/' . Auth::user()->character_id . '/location/';
        $response = $this->httpClient->get($uri);
        dd($response->getBody()->getContents());
    }

    public function setWaypoint(Request $request)
    {
        $uri =  '/characters/' . Auth::user()->character_id . '/ui/autopilot/waypoints/';
        $payload = [
            'clearOtherWaypoints' => false,
            'first' => false,
            'solarSystem' => [
                'href' => "https://crest-tq.eveonline.com/solarsystems/{$request->input('systemID')}/",
                'id' => $request->input('systemID')
            ]
        ];

        $response = $this->httpClient->post($uri, ['json' => $payload]);
        dd($response->getBody()->getContents());
    }
}
