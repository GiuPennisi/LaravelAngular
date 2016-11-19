<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TypeReferedTo;
use App\User;
use App\Message;

class Destinatario extends Model
{
	protected $fillable = [
        'usrName','usrLastname', 'email', 'password', 'usrUsername',
    ];

    public function typereferedto(){
    	return $this->belongsTo('App\TypeReferedTo');
    }

    public function user(){
    	return $this->hasOne('App\User');
    }

    public function message(){
    	return $this->belongsTo('App\Message');
    }
}
