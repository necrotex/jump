<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $connection = "eve";
    protected $table = "mapSolarSystems";
    protected $primaryKey = "solarSystemID";

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'regionID', 'regionID');
    }

    public function jumps(){
        return $this->hasMany('App\Models\Jump', 'fromSolarSystemID', 'solarSystemID');
    }
}
