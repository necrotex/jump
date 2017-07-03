<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LightyearDistance extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::SELECT("
              Insert into jump.distances (fromSolarSystemID, toSolarSystemID, distance)  
              ( 
                  SELECT a.solarSystemID as source, b.solarSystemID as destination,  
                  ((SQRT((POW((a.x - b.x),2)) + (POW((a.y - b.y),2)) + (POW((a.z - b.z),2)))/149597870691)/63239.6717) as distance
                  
                  FROM eve_sde.mapSolarSystems as a 
                  CROSS JOIN eve_sde.mapSolarSystems as b 
                  where (a.solarSystemID < 31000001 and b.solarSystemID < 31000001 and a.solarSystemID != b.solarSystemID) 
                  AND (a.security < 0.5 and b.security < 0.5) 
              );
       ");

        DB::SELECT("ALTER TABLE `distances` ADD INDEX `start_distance` (`fromSolarSystemID`, `distance`)");
    }
}
