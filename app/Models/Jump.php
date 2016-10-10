<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jump extends Model
{
    protected $connection = "eve";
    protected $table = "mapSolarSystemJumps";

    public function system() {
        return $this->belongsTo('App\Models\System', 'fromSolarSystemID', 'SolarSystemID');
    }
}
