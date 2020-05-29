<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = ['image', 'value', 'name', 'type'];

    public function sensor()
    {
        return $this->hasOne('App\Model\Sensor', 'equipment_id');
    }

    public function actuator()
    {
        return $this->hasOne('App\Model\Actuator', 'equipment_id');
    }

    public function thing()
    {
        return $this->hasOne('App\Model\Thing', 'equipment_id');
    }

    public function actions(){
        return $this->hasMany('App\Model\Action', 'equipment_id');
    }

    public function states(){
        return $this->hasMany('App\Model\StateText', 'equipment_id');
    }
}
