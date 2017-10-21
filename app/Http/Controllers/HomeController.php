<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        return view('map');
    }

    public function region($region)
    {
        $map_data = file_get_contents(resource_path() . '/assets/dotlan/' . $region . '.svg.json');
        $region = Region::where('regionName', $region)->with(['systems'])->first();

        $data = [];
        foreach($region->systems as $system) {

            $history = $system->killData()->orderBy('created_at', 'desc')->limit(2)->get();

            if($history->isEmpty()){
                $delta = 0;
                $kills = 0;
            } else {
                $delta = $history->first()->kills_last_hour - $history->last()->kills_last_hour;
                $kills = $history->first()->kills_last_hour;
            }

            $data[$system->solarSystemName] = [
                'id' => $system->solarSystemID,
                'delta' => $delta,
                'kills' => $kills
            ];
        }

        return response()->json(json_encode(['map' => $map_data, 'data' => $data]));
    }
}
