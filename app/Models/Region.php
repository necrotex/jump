<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $connection = "eve";
    protected $table = "mapRegions";
    protected $primaryKey = "regionID";

    public function systems(){
        return $this->hasMany('App\Models\System', 'regionID', 'regionID');
    }

}
