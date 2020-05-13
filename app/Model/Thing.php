<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    protected $table = 'things';

    protected $fillable = ['equipment_id'];

    public function equipment()
    {
        return $this->belongsTo('App\Model\Equipment', 'equipment_id');
    }
}
