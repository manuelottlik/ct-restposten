<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public $fillable = ['name', 'description', 'levels'];

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }
}
