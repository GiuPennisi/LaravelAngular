<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Folder;
use App\User;
use App\Destinatario;


class Message extends Model{

	protected $fillable = ['msgSubject','msgBody','msgSenddate'];

    public function folder(){
    	return $this->belongsTo('App\Folder');
    }

    public function users(){
    	return $this->belongsTo('App\User');
    }

    public function destinatarios(){
    	return $this->hasMany('App\Destinatario');
    }
}
