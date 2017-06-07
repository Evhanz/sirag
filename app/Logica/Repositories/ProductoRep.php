<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 16/08/2016
 * Time: 05:52 PM
 */

namespace sirag\Repositories;
use sirag\Entities\Familia;
use sirag\Entities\Obj;
use sirag\Entities\SubFamilia;
use sirag\DTO\ProductoDTO;
use sirag\Helpers\HelpFunct;

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
        --AND tp.Sistema IN ('Inventario','Produccion') 
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



    //esta es la funcion que se encarga de traer al kardex
    //convinando la entrada con las salidas
    public function getKardex($data)
    {

        if(!isset($data['subFamilia'])){
            $data['subFamilia'] = '';
        }

        //sacaremos la fecha

        $f_i    =   $data['f_i'];
        $f_f    =   $data['f_f'];
        $glosa  =   $data['producto'];
        $familia = $data['familia'];
        $subFamilia = $data['subFamilia'];
        //primero sacamos a toda la data general

        $query = "select 
        CONVERT(DATE,A.Fecha,113) fecha ,A.Numero numero,'entrada' as tipo,C.PRODUCTO,
        C.GLOSA glosa,B.Cantidad cantidad,B.UnidadIngreso unidad ,'-' as FUNDO_PARRON, B.Costo
        from flexline.Documento A, flexline.DocumentoD B, flexline.PRODUCTO C, flexline.TipoDocumento tp
        where
        A.idDocto=B.idDocto
        AND B.Empresa= C.EMPRESA
        and B.Producto= C.PRODUCTO
        AND A.Empresa=TP.Empresa
        AND B.Empresa=TP.Empresa
        AND C.EMPRESA=TP.Empresa
        AND A.TipoDocto=TP.TipoDocto
        AND B.TipoDocto=TP.TipoDocto
        AND tp.FactorInventario='1' 
        --AND A.TipoDocto in ('N/I ALMACEN (A)','DEVOLUCION PACKING','AJUSTE T/INVENTARIO')
        and A.Empresa='e01'
        AND B.Fecha BETWEEN '$f_i' and '$f_f'
        AND C.GLOSA like '%$glosa%'
        AND C.FAMILIA like '%$familia%'
        AND C.SUBFAMILIA like '%$subFamilia%'
        UNION
        SELECT 
        CONVERT(DATE,dd.Fecha,113) fecha,'-' as numero,'salida' as tipo,p.PRODUCTO,
        p.GLOSA glosa,sum(dd.Cantidad) cantidad,dd.UnidadIngreso unidad, coalesce(dd.analisis15,'-') FUNDO_PARRON , dd.Costo
        FROM flexline.DocumentoD dd, flexline.PRODUCTO p , flexline.TipoDocumento tp
        where
        dd.Empresa=p.EMPRESA
        and dd.Producto = p.PRODUCTO
        AND dd.EMPRESA = tp.Empresa
        AND dd.TipoDocto = tp.TipoDocto
        and dd.Empresa='e01'
        AND dd.Bodega <> '' 
        --AND tp.Sistema IN ('Inventario','Produccion') 
        AND tp.FactorInventario='-1' 
        AND dd.Fecha BETWEEN '$f_i' and '$f_f'
        AND p.GLOSA like '%$glosa%'
        AND p.FAMILIA like '%$familia%'
        AND p.SUBFAMILIA like '%$subFamilia%'
        group by dd.Fecha ,p.GLOSA,dd.UnidadIngreso, dd.analisis15 , dd.Costo,p.PRODUCTO
        ORDER BY A.Fecha";

        HelpFunct::writeQuery($query);


        $res = \DB::select($query);

        $res = collect($res);

        $result = $res->groupBy('glosa');

        $dataFormated = [];


        foreach ($result as $item){


            $producto = $item[0];

            $obj = new Obj();
            $obj->producto_name  = $producto->glosa;
            $obj->unidad = $producto->unidad;
            $obj->saldo  = $this->getSaldoFinal($f_i,$f_f,$producto->glosa);
            $obj->codigo = $producto->PRODUCTO;

            $saldo_inicial = round($obj->saldo,3);
            #el anterior saldo inicial va ir variado , el siguiente es para que quede fijo y se use despues
            $s_inicial = $saldo_inicial;

            /*estas variables paara obener la suma de entradas  y salidas*/
            $total_entradas = 0;
            $total_salidas = 0;


            foreach ($item as $i){

                if($i->tipo == 'entrada'){
                   $saldo_inicial += $i->cantidad;
                    $total_entradas += $i->cantidad;
                }else{
                    $saldo_inicial -= $i->cantidad;
                    $total_salidas += $i->cantidad;
                }
                $i->saldo = round($saldo_inicial,3);

                //$i->costo =
            }



            //el ultimo saldo se considera como saldo final o actual
            $obj->saldo_final = round($saldo_inicial,3);
            $obj->total_entrada = $total_entradas;
            $obj->total_salidas = $total_salidas;
            $obj->saldo_inicial = $s_inicial;

            $obj->detalle = $item;
            $obj->costo = round($item->avg('Costo'),3);


            array_push($dataFormated,$obj);

        }




        return $dataFormated;


    }


    public function getCantRequerimientOfProduct($producto,$f_inicio,$f_fin){

        $query = "select A.Producto , SUM(A.Cantidad) cant_requerimiento
                    from flexline.DocumentoD A,
                    flexline.Documento B,
                    flexline.PRODUCTO P
                    where 
                    A.idDocto=B.idDocto
                    AND A.Empresa=P.EMPRESA
                    AND A.Producto=P.PRODUCTO
                    AND A.Empresa='e01'
                    AND A.TipoDocto='R/COMPRA (A)'
                    AND A.Fecha BETWEEN '$f_inicio' and '$f_fin' -- SE FILTRA POR FECHA yyyymmdd
                    AND A.Producto = '$producto' -- FILTRO
                    GROUP BY A.Producto ";

       

        $res = \DB::select($query);
        $response = 0;
        if(count($res)>0){
            $response = $res[0]->cant_requerimiento;
        }

        return $response;

    }

    //esta funcion saca el saldo del producto
    // a un dia antes de los seleccionado, par asacar su saldo inicial
    public function getSaldoFinal($f_i,$f_f,$glosa)
    {

        $query = "select coalesce((select 
                SUM(B.Cantidad) entrada
                from  flexline.DocumentoD B, flexline.PRODUCTO C, flexline.TipoDocumento tp
                where
                B.Empresa=C.EMPRESA
                and B.Producto=C.PRODUCTO
                AND B.TipoDocto = tp.TipoDocto
                AND B.Empresa = tp.Empresa
                --AND tp.Sistema IN ('Compras','Inventario','Produccion') 
                AND tp.FactorInventario='1'
                and B.Empresa='e01'
                AND B.Fecha < '$f_i'
                AND C.GLOSA = '$glosa'),0) -
                coalesce((SELECT sum(dd.Cantidad)salida
                FROM flexline.DocumentoD dd, flexline.PRODUCTO p , flexline.TipoDocumento tp
                where
                dd.Empresa=p.EMPRESA
                and dd.Producto = p.PRODUCTO
                AND dd.EMPRESA = tp.Empresa
                AND dd.TipoDocto = tp.TipoDocto
                and dd.Empresa='e01'
                AND dd.Bodega <> '' 
                --AND tp.Sistema IN ('Inventario','Produccion') 
                AND tp.FactorInventario='-1' 
                and dd.Vigente <> 'A' 
                AND dd.Fecha < '$f_i'
                AND p.GLOSA = '$glosa'),0) saldo";


        $res = \DB::select($query);

        //HelpFunct::writeQuery($query);

        return $res[0]->saldo;

    }


    public function getSalidaByCCI($data){


        $cci = $data['cci'];
        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'] ;
        $familia = $data['familia'];
        if(isset($data['subFamilia'])){
            $subFamilia = $data['subFamilia'];
        }else{
            $subFamilia = '';
        }



        $query  = "
        SELECT coalesce(dd.analisis15,'-') CCI, CONVERT (date,dd.Fecha,103) fecha,p.GLOSA glosa
        ,sum(dd.Cantidad) cantidad,dd.UnidadIngreso unidad,'-' as numero ,'salida' as tipo
        FROM flexline.DocumentoD dd, flexline.PRODUCTO p , flexline.TipoDocumento tp
        where
        dd.Empresa=p.EMPRESA
        and dd.Producto = p.PRODUCTO
        AND dd.EMPRESA = tp.Empresa
        AND dd.TipoDocto = tp.TipoDocto
        and dd.Empresa='e01'
        AND dd.Bodega <> '' 
        AND tp.FactorInventario='-1' 
        AND dd.Fecha BETWEEN '$f_inicio' and '$f_fin' 
        AND p.FAMILIA like '%$familia%'
        AND p.SUBFAMILIA like '%$subFamilia%'
        AND DD.Analisis15 in $cci 
        group by dd.Fecha ,p.GLOSA,dd.UnidadIngreso, dd.analisis15
        ORDER BY A.Fecha ";

       

        $res = \DB::select($query);


        return $res;


    }















}