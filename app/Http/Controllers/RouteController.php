<?php

namespace App\Http\Controllers;

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
    protected $graph;
    protected $nodes = [];

    public function __construct()
    {
        $this->graph = new Graph();
        $this->nodes = Cache::rememberForever('systems_graph', function() {
            $systems = System::all();
            $nodes = [];

            // create a node for each system
            foreach ($systems as $system) {
                $nodes[$system->solarSystemID] = $this->graph->createVertex($system->solarSystemID);
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

    public function range($start = "GE-8JV", $range = 5)
    {
        $start = System::where('solarSystemName', $start)->first();
        $alg = new BreadthFirst($this->nodes[$start->solarSystemID]);

        $reachable = [];
        foreach($alg->getDistanceMap() as $id => $distance) {
            if($distance > $range) continue;

            $reachable[][$id] = ['system' => System::find($id), 'distance' => $distance];
        }

        return $reachable;
    }

    public function lightyearRange($start = "GE-8JV", $range = 8){
        $start = System::where('solarSystemName', $start)->first();

        $systems = DB::connection('eve')->select(
            DB::raw('
                SELECT  a.solarSystemID as source, 
                        b.solarSystemID as destination, 
                        ((SQRT((POW((a.x - b.x),2)) + (POW((a.y - b.y),2)) + (POW((a.z - b.z),2)))/149597870691)/63239.6717) as distance
                        
                FROM test1.mapSolarSystems a 
                CROSS JOIN test1.mapSolarSystems b
                where (a.solarSystemID < 31000001 and b.solarSystemID < 31000001)
                AND (a.security < 5 and b.security < 5)
                AND a.solarSystemID = :source #source system
                HAVING distance <= :range; #ly distance
            '),
            [
                'source' => $start->solarSystemID,
                'range' => $range
            ]
        );

        return $systems;
    }

}
