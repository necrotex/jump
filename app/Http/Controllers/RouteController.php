<?php

namespace App\Http\Controllers;

use App\Models\Distance;
use App\Models\Jump;
use App\Models\System;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\ShortestPath\BreadthFirst;
use Graphp\Algorithms\ShortestPath\Dijkstra;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    protected $nodes = [];

    public function __construct()
    {
        $this->nodes = Cache::rememberForever('systems_graph', function() {
            $graph = new Graph();
            $systems = System::all();
            $nodes = [];

            // create a node for each system
            foreach ($systems as $system) {
                $nodes[$system->solarSystemID] = $graph->createVertex($system->solarSystemID);
            }

            //connect the systems
            foreach ($systems as $system)  {
                foreach($system->jumps as $jump) {
                    $nodes[$system->solarSystemID]->createEdgeTo($nodes[$jump->toSolarSystemID]);
                }
            }

            return $nodes;
        });
    }

    public function range($start, $range)
    {
        return Cache::rememberForever('range_' . $start . '_' . $range, function() use ($start, $range){
                $start = System::where('solarSystemID', $start)->first();
                $alg = new BreadthFirst($this->nodes[$start->solarSystemID]);

                $reachable = [];
                foreach($alg->getDistanceMap() as $id => $distance) {
                    if($distance > $range) continue;

                    $reachable[] = ['system' => System::find($id), 'distance' => $distance];
                }

                return $reachable;
            });
    }

    public function lightyearRange($start, $range){

        return Cache::rememberForever('lightyearRange_' . $start . '_' . $range, function() use ($start, $range){
            $start = System::where('solarSystemID', $start)->first();
            $results = Distance::where('fromSolarSystemID', $start->solarSystemID)->where('distance', '<=', $range)->get();

            $systems = [];
            foreach($results as $system){
                $dist = round($system->distance, 2) . ' ly';
                $systems[] = ['system' => $system->destination, 'distance' => $dist];
            }

            return $systems;
        });
    }

}
