<?php

namespace App\Console\Commands;

use App\Models\KillData;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jump:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old database entries';

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
        $expired = Carbon::now()->subWeek(2);

        Log::info("Removing old history data");
        KillData::where('created_at', '>=', $expired)->delete();
        Log::info('Done');
    }
}
