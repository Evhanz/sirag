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

        $p = \DB::select("SELECT RazonSocial,Moneda,GLOSA,SUBFAMILIA,
                          CAST(CONVERT(FLOAT,ROUND(AVG(Precio),2,1)) AS VARCHAR) as Promedio
                          FROM v_allProductsAndProveedores
                          where SUBFAMILIA like '%$subfamilia%' AND FAMILIA like '%$familia%'
                          AND GLOSA like  '%$glosa%'
                          GROUP BY RazonSocial,Moneda,GLOSA,SUBFAMILIA");

        //obtenermos el ultimo dato de cada producto
        foreach($p as $item)
        {

            $last = \DB::select("SELECT top 1 CAST(CONVERT(FLOAT,ROUND(Precio,2,1)) AS VARCHAR) as Precio, UnidadIngreso
                                FROM v_allProductsAndProveedores
                                WHERE GLOSA = '$item->GLOSA'
                                AND RazonSocial = '$item->RazonSocial'
                                AND Moneda = '$item->Moneda'
                                order by Fecha desc");

            $item->last_precio = $last[0]->Precio;
            $item->UnidadIngreso = $last[0]->UnidadIngreso;
        }

        return $p;
    }

    public function  getDetailProductoCompra($data){
        $glosa  = $data['glosa'];
        $proveedor = $data['proveedor'];
        $moneda = $data['moneda'];
        $p = new ProductoDTO();



        $p = \DB::select("SELECT Fecha,Numero,TipoDocto,UnidadIngreso,ANO,
                        CAST(CONVERT(FLOAT,ROUND(Precio,2,1)) AS VARCHAR) AS Precio
                        FROM v_allProductsAndProveedores
                        WHERE GLOSA = '$glosa'
                        AND RazonSocial = '$proveedor'
                        and Moneda = '$moneda'
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



    //funcion para traer a el kardex de consumo 


    public function getKardexSalida($data)
    {

        /*
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];
*/

        //primero llamaremos a el 

        $query = "SELECT dd.Fecha fecha,p.GLOSA glosa,dd.Cantidad cantidad
        FROM flexline.DocumentoD dd, flexline.PRODUCTO p , flexline.TipoDocumento tp
        where
        dd.Empresa=p.EMPRESA
        and dd.Producto = p.PRODUCTO
        AND dd.EMPRESA = tp.Empresa
        AND dd.TipoDocto = tp.TipoDocto
        and dd.Empresa='e01'
        AND dd.Bodega <> '' 
        AND tp.Sistema IN ('Inventario','Produccion') 
        AND tp.FactorInventario='-1' 
        --AND dd.Fecha BETWEEN '2016-01-01' and '2016-30-11'
        ORDER by Fecha";

        try {

            $res = \DB::select($query);
            foreach ($res as $i) {
                # code...
                $i->glosa = utf8_decode($i->glosa);

            }

            $res = collect($res);


            $result = $res->groupBy('glosa');



            return $result;
            
        } catch (\Exception $e) {
            return $e;
            
        }

        

        /*

        $result = $res->groupBy('glosa')->map(function ($item) {
                return $item->sum(function ($item) {
                    return ($item['cantidad']);
                });
            })->toArray();

        */


        

    }





}