<?php

namespace App\Console\Commands;

use App\Models\KillData;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateKillDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jump:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull new npc kill data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        Log::info('Updating NPC KIll Data');

        $url = "https://api.eveonline.com/map/kills.xml.aspx";
        $data = simplexml_load_file($url);

//        try {
//            $lastEntry = KillData::orderBy('created_at', 'desc')->firstOrFail();
//
//            if(Carbon::now()->diffInHours($lastEntry->created_at) == 0) {
//                Log::info('NPC Kill data was updated less then an hour ago. Exiting...');
//
//                return;
//            }
//        } catch (ModelNotFoundException $e) {
//
//            Log::info('No old killdata found, Running for the first time');
//        }

        foreach($data->result[0]->rowset[0] as $row) {
            KillData::create([
                'system_id' => $row['solarSystemID'],
                'kills_last_hour' => $row['factionKills']
            ]);
        }

        Log::info('Update done. Exiting...');
    }
}
