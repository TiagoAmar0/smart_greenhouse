<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SensorAction extends Model
{
    public $table = 'sensor_additional_actions';

    public $fillable = ['sensor_id', 'text', 'route', 'value'];
}
