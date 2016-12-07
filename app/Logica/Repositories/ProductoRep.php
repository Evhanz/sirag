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
                          CAST(CONVERT(FLOAT,ROUND(AVG(Precio),4,1)) AS VARCHAR) as Promedio
                          FROM v_allProductsAndProveedores
                          where SUBFAMILIA like '%$subfamilia%' AND FAMILIA like '%$familia%'
                          AND GLOSA like  '%$glosa%'
                          GROUP BY RazonSocial,Moneda,GLOSA,SUBFAMILIA");

        //obtenermos el ultimo dato de cada producto
        foreach($p as $item)
        {

            $last = \DB::select("SELECT top 1 CAST(CONVERT(FLOAT,ROUND(Precio,4,1)) AS VARCHAR) as Precio, UnidadIngreso
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
                        CAST(CONVERT(FLOAT,ROUND(Precio,4,1)) AS VARCHAR) AS Precio
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

        $sub = \DB::select("select CODIGO,DESCRIPCION,RELACIONCODIGO1 from flexline.gen_tabcod where EMPRESA='e01'  and TIPO='producto.subfamilia' AND VIGENCIA <> 'N'");

        return $sub;

    }


    //funcion para mandar las subfamilias de acuerdo a su famili



    //funcion para traer a el kardex de consumo 


    public function getKardexSalida($data)
    {

       
        $f_i        = $data['f_i'];
        $f_f        = $data['f_f'];
        $producto   = $data['producto'];
        $familia    = $data['familia'];



        //primero llamaremos a el 

        $query = "SELECT dd.Fecha fecha,p.GLOSA glosa,dd.Cantidad cantidad,dd.UnidadIngreso unidad
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
        AND dd.Fecha BETWEEN '$f_i' and '$f_f'
        AND p.GLOSA like '%$producto%'
        AND p.FAMILIA like '%$familia%'
        --AND dd.Fecha BETWEEN '2016-01-01' and '2016-30-11'
        ORDER by Fecha";

       
        
        $res = \DB::select($query);
        foreach ($res as $i) {
                # code...
            $i->glosa = utf8_encode($i->glosa);

        }

        $res = collect($res);
        $result = $res->groupBy('glosa');


        //primero sacaremos los key de cada uno de los elementos del array y lo asignaremos a un array 
        //donde estara formateada la data de acuerdo a lo requerido

        $dataFormated = array();

        foreach ($result as $item) {

            $obj = new ProductoDTO();
            $obj->producto_name = $item[0]->glosa;
            $obj->cantidad_total = $item->sum("cantidad");
            $obj->unidad = $item[0]->unidad;
            $obj->detalle = $item;
             array_push($dataFormated, $obj);

        }



        //return $result;
        return $dataFormated;
            
       

    }


    //luego unir la funcion en una sola de entrada y salida

    public function getKardexEntrada($data)
    {


        $f_i        = $data['f_i'];
        $f_f        = $data['f_f'];
        $producto   = $data['producto'];
        $familia    = $data['familia'];



        //primero llamaremos a el

        $query = "select A.Fecha fecha ,A.Numero numero,
                  C.GLOSA glosa,B.Cantidad cantidad,B.UnidadIngreso unidad
                  from flexline.Documento A, flexline.DocumentoD B, flexline.PRODUCTO C
                  where
                  A.idDocto=B.idDocto
                  AND B.Empresa=C.EMPRESA
                  and B.Producto=C.PRODUCTO
                  AND A.TipoDocto='N/I ALMACEN (A)'
                  and A.Empresa='e01'
                  AND B.Fecha BETWEEN '$f_i' and '$f_f'
                  AND C.GLOSA like '%$producto%'
                  AND C.FAMILIA like '%$familia%'
                  ORDER BY A.Fecha";



        $res = \DB::select($query);
        foreach ($res as $i) {
            # code...
            $i->glosa = utf8_encode($i->glosa);

        }

        $res = collect($res);
        $result = $res->groupBy('glosa');


        //primero sacaremos los key de cada uno de los elementos del array y lo asignaremos a un array
        //donde estara formateada la data de acuerdo a lo requerido

        $dataFormated = array();

        foreach ($result as $item) {

            $obj = new ProductoDTO();
            $obj->producto_name = $item[0]->glosa;
            $obj->cantidad_total = $item->sum("cantidad");
            $obj->unidad = $item[0]->unidad;
            $obj->detalle = $item;
            array_push($dataFormated, $obj);

        }



        //return $result;
        return $dataFormated;



    }






}