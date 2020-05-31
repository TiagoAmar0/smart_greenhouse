<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function histories(){
        return $this->hasMany('App\Model\History', 'equipment_id')->orderBy('created_at', 'desc')->take(50)->skip(0);
    }

    public function getUpdatedAtAttribute($date) {
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
