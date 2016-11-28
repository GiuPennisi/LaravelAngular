<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Province;
use App\Country;
use App\City;

class Province extends Model{

protected $fillable = ['province'];

    public function province(){
    	return $this->belongsTo('App\Country');
    }

    public function users(){
    	return $this->hasMany('App\City');
    }
}
