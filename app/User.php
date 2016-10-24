<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'security.SEG_USUARIO';
    public $timestamps = false;
    protected $primaryKey = 'USR';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['USR', 'pwd'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function roles(){
        return $this->belongsToMany('App\Role','user_role','USR','role_id');
    }

    public function hasAnyRole($roles)
    {

        $bandera = false;
        if (is_array($roles)){
            foreach ($roles as $role){
                if ($this->hasRole($role)){
                    //return true;
                    //$bandera ="Entra  en array";
                    $bandera = true;
                }
            }
        }else{
            if ($this->hasRole($roles)){
               // return true;
                //$bandera ="Entra  en unidad";
                $bandera = true;
            }
        }

        return $bandera;
    }


    public function hasRole($role)
    {

        $rol = Role::where('name',$role)->first();

        $pivot = UserRole::where('role_id',$rol->id)->where('USR','=',$this->USR)->first();

        if(count($pivot)>0){
            return true;
        }else
            return false;
    }


}
