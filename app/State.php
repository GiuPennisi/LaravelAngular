<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use App\Country;

class Province extends Model
{

	protected $fillable = ['province'];

    public function country(){
    	return $this->belongsTo('App\Country');
    }

    public function cities(){
    	return $this->hasMany('App\City');
    }
}
