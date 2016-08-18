<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 16/08/2016
 * Time: 05:52 PM
 */

namespace sirag\Repositories;
use sirag\Entities\Familia;
use sirag\Entities\SubFamilia;
use sirag\DTO\ProductoDTO;

class ProductoRep
{

    //funcion para obtener productos de acuerdo a una subfamilia especifica
    //teniendo en cuenta que se creo una visata para esta funcion la vista es v_allProductsAndProveedores

    public function getAllProductosByProveedor($data)
    {

        $glosa  = $data['glosa'];
        $subfamilia = $data['subfamilia'];
        $familia = $data['familia'];
        $p = new ProductoDTO();

        $p = \DB::select("SELECT RazonSocial,TipoDocto,Moneda,GLOSA,SUBFAMILIA,
                          CAST(CONVERT(FLOAT,ROUND(AVG(Precio),2,1)) AS VARCHAR) as Promedio
                          FROM v_allProductsAndProveedores
                          where SUBFAMILIA like '%$subfamilia%' AND FAMILIA like '%$familia%'
                          AND GLOSA like  '%$glosa%'
                          GROUP BY RazonSocial,TipoDocto,Moneda,GLOSA,SUBFAMILIA");

        //obtenermos el ultimo dato de cada producto
        foreach($p as $item)
        {

            $last = \DB::select("SELECT top 1 CAST(CONVERT(FLOAT,ROUND(Precio,2,1)) AS VARCHAR) as Precio, UnidadIngreso
                                            FROM v_allProductsAndProveedores
                                            WHERE GLOSA = '$item->GLOSA'
                                            AND RazonSocial = '$item->RazonSocial'
                                            order by Fecha desc");

            $item->last_precio = $last[0]->Precio;
            $item->UnidadIngreso = $last[0]->UnidadIngreso;
        }

        return $p;
    }

    public function  getDetailProductoCompra($data){
        $glosa  = $data['glosa'];
        $proveedor = $data['proveedor'];
        $p = new ProductoDTO();



        $p = \DB::select("SELECT Fecha,Numero,TipoDocto,UnidadIngreso,
                        CAST(CONVERT(FLOAT,ROUND(Precio,2,1)) AS VARCHAR) AS Precio
                        FROM v_allProductsAndProveedores
                        WHERE GLOSA = '$glosa'
                        AND RazonSocial = '$proveedor'
                        order by Fecha desc");


        return $p;
    }




    //funcion para mandar todas las familias

    public function getAllFamilias(){
        $fam = new Familia();

        $fam = \DB::select("select CODIGO,DESCRIPCION from flexline.gen_tabcod
                            where EMPRESA='e01' and TIPO='producto.familia' AND VIGENCIA <> 'N' ");
        return $fam;

    }
    public function getAllSubFamilias(){
        $sub = new SubFamilia();

        $sub = \DB::select("select CODIGO,DESCRIPCION,RELACIONCODIGO1 from flexline.gen_tabcod where EMPRESA='e01'
                            and TIPO='producto.subfamilia' AND VIGENCIA <> 'N'");

        return $sub;

    }


    //funcion para mandar las subfamilias de acuerdo a su famili





}