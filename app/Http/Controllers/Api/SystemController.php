<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\RouteController;
use App\Models\System;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    public function autocomplete(Request $request)
    {
        $systems = System::where('solarSystemName', 'LIKE', "{$request->input('q')}%")
            ->where('security', '<', 5)
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
            $output[$index]['id'] = $system['system']->solarSystemID;
            $output[$index]['name'] = $system['system']->solarSystemName;
            $output[$index]['region'] = $system['system']->region->regionName;
            $output[$index]['distance'] = $system['distance'];
            $output[$index]['delta'] = 0;
            $output[$index]['kills'] = 0;
        }

        return response()->json($output);

    }
}
