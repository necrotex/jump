<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KillData extends Model
{
    protected $table = 'kill_data';

    protected $fillable = [
        'system_id', 'kills_last_hour'
    ];

    protected $hidden = ['id', 'updated_at'];

    public function system() {
        return $this->belongsTo('App\Models\System', 'system_id', 'solarSystemID');
    }
}
