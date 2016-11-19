<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Destinatario;



class TypeReferedTo extends Model
{

	 protected $fillable = ['typeRef'];

	
    public function destinatarios(){
    	return $this->hasMany('App\Destinatario');
    }

}
