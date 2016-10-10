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

    public function lightyearRange($start = "GE-8JV", $range = 5){
        $start = System::where('solarSystemName', $start)->first();
    }

}
