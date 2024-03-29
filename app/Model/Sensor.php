<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table = 'sensors';

    protected $fillable = ['equipment_id', 'metric'];

    public function equipment()
    {
        return $this->belongsTo('App\Model\Equipment', 'equipment_id');
    }
}
