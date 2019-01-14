<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    //
	public function rooms(){
	return $this->hasMany('App\Room');
	}
	protected $fillable = ['name', 'description'];
}
