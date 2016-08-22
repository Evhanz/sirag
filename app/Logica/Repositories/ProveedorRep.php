<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 22/08/2016
 * Time: 11:13 AM
 */

namespace sirag\Repositories;
use sirag\Entities\Proveedores;


class ProveedorRep
{


    public function getProveedoresByRazonAndRUC($data)
    {
        $p = new Proveedores();
        $ruc = $data['ruc'];
        $razon = $data['razon'];

        //sacamos primero a todos los proveedores que cumplan
        $p = \DB::select("select top 3 c.RazonSocial as razon, c.CtaCte as ruc,
                            c.Contacto,c.Email,c.Telefono,
                            c.Direccion , c.Pais,
                            c.Comuna as 'distrito',
                            c.Ciudad as 'provincia' ,
                            c.Estado as 'departamento'
                            from flexline.CtaCte c
                            where c.Empresa = 'e01'
                            and c.TipoCtaCte = 'PROVEEDOR'
                            AND c.CtaCte like '%$ruc%'
                            AND c.RazonSocial like '%$razon%'");


        foreach($p as $item){
            $item->sucursales = \DB::select("SELECT *
                                      FROM flexline.CtaCteDirecciones
                                      where CtaCte = $item->ruc
                                      AND Empresa ='e01'
                                      AND Principal <> 'S'");
        }



        //obtenemos sus direcciones varias



        return $p;
    }

    public function getProductosComercioProveedor($ruc)
    {

        $productos = \DB::select("SELECT GLOSA FROM v_allProductsAndProveedores
                                    where CtaCte = '$ruc'
                                    group by GLOSA");

        return $productos;

    }



}