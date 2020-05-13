<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Actuator extends Model
{
    protected $table = 'actuators';

    protected $fillable = ['equipment_id'];

    public function equipment()
    {
        return $this->belongsTo('App\Model\Equipment', 'equipment_id');
    }

}
