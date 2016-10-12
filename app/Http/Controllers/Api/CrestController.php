<?php

namespace App\Http\Controllers\Api;

use App\Models\System;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CrestController extends Controller
{

    public function __construct()
    {
    }

    protected function getHttpClient()
    {
        return new Client([
            'base_uri' => 'https://crest-tq.eveonline.com/',
            'headers' => [
                'Authorization' => 'Bearer ' . Auth::user()->getAccessToken()
            ]
        ]);
    }

    public function getLocation(Request $requests)
    {
        $uri =  '/characters/' . Auth::user()->character_id . '/location/';
        $response = $this->getHttpClient()->get($uri);
        $data = json_decode($response->getBody()->getContents());

        $system = System::where('solarSystemID', $data->solarSystem->id)->first();

        return response()->json(['systemID' => $system->solarSystemID, 'systemName' => $system->solarSystemName]);
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

        $response = $this->getHttpClient()->post($uri, ['json' => $payload]);
    }
}
