<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    public $timestamps = false;

    public function users(){
        return $this->belongsToMany('App\User','user_role','role_id','USR');
    }
}
