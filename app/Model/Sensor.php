<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public $table = 'sensors';
    public $fillable = ['name', 'value', 'image', 'metric'];
}
