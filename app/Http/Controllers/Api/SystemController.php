<?php

namespace App\Http\Controllers\Api;

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
}
