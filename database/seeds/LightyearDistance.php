<?php

use Illuminate\Database\Seeder;

class LightyearDistance extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systems = \App\Models\System::where('security', '<', 5)->where('solarSystemID', '<', 31000001)->get();

        $done = [];

        foreach ($systems as $system) {

            $done[] = $system->solarSystemID;

            foreach ($systems as $ksystem) {
                if ($system->solarSystemID == $ksystem->solarSystemID || in_array($ksystem->solarSystemID, $done))
                    continue;

                $range = (((sqrt(
                            (($system->x - $ksystem->x) * ($system->x - $ksystem->x)) +
                            (($system->y - $ksystem->y) * ($system->y - $ksystem->y)) +
                            (($system->z - $ksystem->z) * ($system->z - $ksystem->z))))
                        / 149597870691) / 63239.6717);


                DB::table('distances')->insert([
                    'fromSolarSystemID' => $system->solarSystemID,
                    'toSolarSystemID' => $ksystem->solarSystemID,
                    'range' => $range
                ]);
            }
        }
    }
}
