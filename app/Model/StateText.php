<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StateText extends Model
{
    protected $table = 'state_texts';
    protected $fillable = ['equipment_id', 'value', 'text'];

    public function equipment()
    {
        return $this->belongsTo('App\Model\Equipment', 'equipment_id');
    }
}
