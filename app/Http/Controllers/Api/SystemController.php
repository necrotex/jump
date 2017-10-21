<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\RouteController;
use App\Models\System;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    public function info($id)
    {
        $system = System::find($id);
        $history = $npc_kills = $system->killData()->orderBy('created_at', 'desc')->limit(2)->get();

        if($history->isEmpty()){
            $delta = 0;
            $kills = 0;
        } else {
            $delta = $history->first()->kills_last_hour - $history->last()->kills_last_hour;
            $kills = $history->first()->kills_last_hour;
        }

        $output = [];
        $output['id'] = $system->solarSystemID;
        $output['name'] = $system->solarSystemName;
        $output['sec'] = round($system->security, 2);
        $output['region'] = $system->region->regionName;
        $output['delta'] = $delta;
        $output['kills'] = $kills;

        return response()->json($output);
    }

    public function autocomplete(Request $request)
    {
        $systems = System::where('solarSystemName', 'LIKE', "{$request->input('q')}%")
            ->where('security', '<', 0.5)
            ->where('solarSystemID', '<', 31000001)
            ->get();

        return response()->json($systems);
    }

    public function systemsInRange(Request $request){
        $route = new RouteController();

        if($request->input('type') == 'gate'){
            $systems = $route->range($request->input('system'), $request->input('range'));
        } else if($request->input('type') == 'jump') {
            $systems = $route->lightyearRange($request->input('system'), $request->input('range'));
        } else {
            return response()->json([]);
        }

        $output = [];
        foreach($systems as $index => $system) {

            $history = $npc_kills = $system['system']->killData()->orderBy('created_at', 'desc')->limit(2)->get();

            if($history->isEmpty()){
                $delta = 0;
                $kills = 0;
            } else {
                $delta = $history->first()->kills_last_hour - $history->last()->kills_last_hour;
                $kills = $history->first()->kills_last_hour;
            }

            $output[$index]['id'] = $system['system']->solarSystemID;
            $output[$index]['name'] = $system['system']->solarSystemName;
            $output[$index]['sec'] = round($system['system']->security, 2);
            $output[$index]['region'] = $system['system']->region->regionName;
            $output[$index]['distance'] = $system['distance'];
            $output[$index]['delta'] = $delta;
            $output[$index]['kills'] = $kills;
        }

        return response()->json($output);

    }
}
