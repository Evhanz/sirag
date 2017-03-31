<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/12/16
 * Time: 04:29 PM
 */

namespace sirag\Repositories\packing;


class MateriaPrimaRep
{

    public function getByParameters($data)
    {

        $query = "";


        $res = \DB::select($query);


        return $res;
    }

    public function store($data)
    {

        //primero guardamos la cabecera

        $cabecera = $data['cabecera'];

        $guia = $cabecera['guia_transportista'];
        $h_inicio = $cabecera['h_inicio'];
        $h_fin = $cabecera['h_fin'];
        $dni_responsable = $cabecera['responsable'];
        $dni_controlador = $cabecera['controlador'];
        $id_productor = $cabecera['id_productor'];
        $fecha = $cabecera['fecha'];

        \DB::insert("INSERT INTO sirag.ingreso_MP (guia_transportista,h_inicio,h_fin
                    ,dni_responsable,dni_controlador,id_productor) VALUES
                     ('$guia', '$h_inicio', '$h_fin','$dni_responsable','$dni_controlador',1,'$fecha')");

        $cabecera = \DB::select("SELECT * FROM sirag.ingreso_MP  where fecha = '$fecha'");
        $id_cabecera = $cabecera->id;


        //detalle uva

        $detalle_uva = $data['detalle_uva'];

        foreach ($detalle_uva as $item){

            $n_pesadas = $item['n_pesadas'];
            $n_guia = $item['guia'];
            $variedad = $item['variedad'];
            $fundo_parron = $item['fundo'].'/'.$item['parron'];
            $l_produccion = $item['l_produccion'];
            $n_jaba = $item['n_jaba'];
            $tara_jaba = $item['tara_jaba'];
            $tara_parihuela = $item['tara_parihuela'];
            $peso_bruto = $item['peso_bruto'];

            \DB::insert("INSERT INTO sirag.detalle_uva (n_pesadas , n_guia , variedad ,fundo_parron
                        ,l_produccion , n_jaba , tara_jaba , tara_parihuela , peso_bruto , id_ingreso_MP ) VALUES
                     ('$n_pesadas', '$n_guia', '$variedad','$fundo_parron','$l_produccion',$n_jaba,$tara_jaba,
                     $tara_parihuela,$peso_bruto,'$id_cabecera')");

        }

        //detalle descarte

        $detalle_descarte = $data['detalle_descarte'];

        foreach ($detalle_descarte as $item){


            $fundo_parron = $item['fundo_parron'];
            $variedad = $item['variedad'];
            $racimo = $item['racimo'];
            $baya = $item['baya'];
            $k_racimo = $item['kl_racimo'];
            $k_baya = $item['kl_baya'];



            \DB::insert("INSERT INTO sirag.detalle_uva (n_pesadas , n_guia , variedad ,fundo_parron
                        ,l_produccion , n_jaba , tara_jaba , tara_parihuela , peso_bruto , id_ingreso_MP ) VALUES
                     ('$n_pesadas', '$n_guia', '$variedad','$fundo_parron','$l_produccion',$n_jaba,$tara_jaba,
                     $tara_parihuela,$peso_bruto,'$id_cabecera')");

        }

        //detalle de choferes
        $conductores = $data['conductores'];

        foreach ($conductores as $item){



        }



    }
    public function update($data)
    {

        $query = "";


        $res = \DB::update($query);


        return $res;
    }

    public function delete($data)
    {

        $query = "";


        $res = \DB::delete($query);


        return $res;
    }

    public function getDetalleUva($data){

    }

    public function getDetalleDescarte($data){

    }

    public function storeDetalleUva($data){

    }

    public function storeDetalleDescarte($data){

    }

    public function updateDetalleUva($data){

    }

    public function updateDetalleDescarte($data){

    }

    public function deleteDetalleUva($data){

    }

    public function deleteDetalleDescarte($data){

    }




}