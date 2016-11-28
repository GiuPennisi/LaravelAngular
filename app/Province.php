<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;
use App\City;

class Province extends Model{

protected $fillable = ['province'];

    public function country(){
    	return $this->belongsTo('App\Country');
    }

    public function cities(){
    	return $this->hasMany('App\City');
    }
}
