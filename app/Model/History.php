<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';

    protected $fillable = ['equipment_id', 'value'];

    public function equipment(){
        return $this->belongsTo('App\Model\Equipment', 'equipment_id');
    }
}
