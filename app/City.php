<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Province;
use App\User;

class City extends Model{

protected $fillable = ['city'];

    public function province(){
    	return $this->belongsTo('App\Province');
    }

    public function users(){
    	return $this->hasMany('App\User');
    }
}
