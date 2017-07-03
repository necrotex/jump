<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    public function start()
    {
        return $this->hasOne(System::class, 'solarSystemID', 'fromSolarSystemID');
    }

    public function destination()
    {
        return $this->hasOne(System::class, 'solarSystemID', 'toSolarSystemID');
    }
}

