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

    public function getAccess(){

        $query_mod = "SELECT a.id id, m.alias alias,m.icono,a.id_modulo id_modulo  FROM sirag.accesos a inner join sirag.modulos m 
                    on a.id_modulo = m.id
                    where a.usuario = '$this->USR'
                    AND tipo = 'modulo'";

        $modulos = \DB::select($query_mod);

        $query = "SELECT a.id id_acceso,m.id id_modulo, a.descripcion descripcion, s.id id_submodulo , s.alias alias
                    FROM sirag.accesos a INNER JOIN sirag.sub_modulos s 
                    on a.id_modulo = s.id INNER join sirag.modulos m on s.id_modulo = m.id
                    where a.usuario = '$this->USR' AND tipo = 'sub_modulo'";

        $submodulos =  \DB::select($query);
        $submodulos =  collect($submodulos);

        $a_sub_modulos = [];
        foreach ($modulos as $modulo ){

            $a_sub_modulos = $submodulos->where('id_modulo',$modulo->id_modulo);
            $modulo->sub_modulo = $a_sub_modulos;
        }

        return $modulos;

    }


}
