<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $fillable = ['name', 'seats', 'windows'];

    public function building() {
        return $this->hasOne('App\Building');
    }
}
