<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Province;

class Country extends Model
{
	protected $fillable = ['country'];

    public function provinces(){
    	return $this->hasMany('App\Province');
    }
}
