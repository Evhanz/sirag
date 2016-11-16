<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/08/2016
 * Time: 02:16 PM
 */

namespace sirag\Repositories;

class UsuarioRep
{

    public function getAllUsersAndRoles()
    {
        

        $roles = \DB::select("SELECT name,id
                            from dbo.roles
                            ORDER by name");

        $usuarios = \DB::select("SELECT  usr 
                    from security.SEG_USUARIO 
                    where EMPRESA = 'e01'
                    ORDER by USR");


        $all = \DB::select("SELECT  USR usr,name rol
                from dbo.user_role as ur INNER
                JOIN dbo.roles as r on ur.role_id = r.id");

        $all = collect($all);


        //ahora empezamos a sacar la data 


        foreach ($usuarios as $item) {

            $detail = [];

            foreach ($roles as $r) {

                $d = [];

                $bandera = $all->where('usr',$item->usr)->where('rol',$r->name);

                if (count($bandera)>0) {
                    # code...

                    $d = ['rol'=>$r->id,'res'=>true] ; 

                    array_push($detail, $d);

                }
                else
                {
                    $d = ['rol'=>$r->id,'res'=>false] ; 

                    array_push($detail, $d);
                }

            }


            $item->detail = $detail;
        }


        $data['roles'] = $roles;
        $data['usuarios'] = $usuarios;

        return $data;
    }


    public function updateRoles($data)
    {
        $usr    = $data['usr'];
        $detail = $data['detail'];

        $res = \DB::delete('DELETE FROM dbo.user_role where USR = ?', [$usr]);


        foreach ($detail as $d) {

            $rol = $d['rol'];

            if ($d['res']) {
              \DB::insert('insert into dbo.user_role (USR,role_id) values (?, ?)', [$usr, $rol]);
            }
        }


        return "ok";

    }





}