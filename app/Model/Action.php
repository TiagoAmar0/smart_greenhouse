<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';

    protected $fillable = ['equipment_id', 'text', 'route', 'value'];

    public function equipment()
    {
        return $this->belongsTo('App\Model\Equipment', 'equipment_id');
    }
}
