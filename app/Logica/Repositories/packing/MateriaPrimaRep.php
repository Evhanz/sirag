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


    public function getMateriaPrima($f_i = null,$f_f=null){

        $q = '';

        if($f_i != null || $f_f != null){
            $q = "where fecha between '$f_i' and '$f_f' ";
        }

        $query = "SELECT *  FROM sirag.ingreso_MP $q";

        $res = \DB::select($query);

        return $res;

    }


    public function getMateriaPrimaById($id){


        $query ="SELECT *  FROM sirag.ingreso_MP where id = $id";
        $imp = \DB::select($query);
        if(count($imp)>0){
            //traemos a sus detalles de choferes

            $imp = $imp[0];

            $q = "SELECT dc.id,dc.placa,dc.dni_chofer as dni,dc.dni_chofer,
                    (t.APELLIDO_PATERNO+' '+t.APELLIDO_MATERNO+' '+t.NOMBRE) chofer
                    FROM sirag.detalle_chofer_mp dc inner join flexline.PER_TRABAJADOR t
                    on dc.dni_chofer = t.EMPLEADO
                    where id_ingreso_mp = $id";
            $imp->detalle_chofer = \DB::select($q);


            $q = "SELECT * FROM sirag.detalle_uva where id_ingreso_mp = $id";
            $temp =  \DB::select($q);
            foreach ($temp as $i){
                $bandera = explode('/',$i->fundo_parron);
                $i->fundo = $bandera[0];
                $i->parron = $bandera[1];
            }
            $imp->detalle_uva = $temp;

            $q = "SELECT * FROM sirag.detalle_descarte where id_ingreso_mp = $id";
            $imp->detalle_descarte = \DB::select($q);
        }

        return $imp;

    }

    public function getByParameters($data)
    {

        $query = "";


        $res = \DB::select($query);


        return $res;
    }

    public function store($data)
    {


        \DB::transaction(function () use ($data) {

            //primero guardamos la cabecera

            $cabecera = $data['cabecera'];

            $guia = $cabecera['guia_transportista'];
            $h_inicio = $cabecera['h_inicio'];
            $h_fin = $cabecera['h_fin'];
            $dni_responsable = $cabecera['responsable'];
            $dni_controlador = $cabecera['controlador'];
            $id_productor = '1';
            $fecha = $cabecera['fecha'];

            \DB::insert("INSERT INTO sirag.ingreso_MP (guia_transportista,h_inicio,h_fin
                    ,dni_responsable,dni_controlador,id_productor,fecha) VALUES
                     ('$guia', '$h_inicio', '$h_fin','$dni_responsable','$dni_controlador',1,'$fecha')");

            $cabecera = \DB::select("SELECT * FROM sirag.ingreso_MP  where fecha = '$fecha'");
            $id_cabecera = $cabecera[0]->id;


            //detalle uva
            $detalle_uva = $data['detalle_uva'];
            $this->storeDetalleUva($detalle_uva,$id_cabecera);


            //detalle descarte
            $detalle_descarte = $data['detalle_descarte'];
            $this->storeDetalleDescarte($detalle_descarte,$id_cabecera);


            //detalle de choferes
            $conductores = $data['conductores'];
            $this->storeDetalleChofer($conductores,$id_cabecera);




            return 'correcto';
        });





    }
    public function update($data)
    {
        \DB::transaction(function () use ($data) {

            //primero guardamos la cabecera

            $cabecera = $data['cabecera'];

            $guia = $cabecera['guia_transportista'];
            $h_inicio = $cabecera['h_inicio'];
            $h_fin = $cabecera['h_fin'];
            $dni_responsable = $cabecera['responsable'];
            $dni_controlador = $cabecera['controlador'];
            $id_productor = '1';
            $fecha = $cabecera['fecha'];
            $id = $cabecera['id'];

            \DB::insert("UPDATE sirag.ingreso_MP SET guia_transportista='$guia', h_inicio='$h_inicio'
                          ,h_fin = '$h_fin',dni_responsable = '$dni_responsable' ,
                          dni_controlador= '$dni_controlador',fecha ='$fecha'
                          WHERE id = $id");
            $id_cabecera = $id;


            //primero eliminamos todos os detalles
            $this->deleteDetalleChofer($id_cabecera);
            $this->deleteDetalleDescarte($id_cabecera);
            $this->deleteDetalleUva($id_cabecera);


            //agregamos todos los detalles denuevo


            //detalle uva
            $detalle_uva = $data['detalle_uva'];
            $this->storeDetalleUva($detalle_uva,$id_cabecera);


            //detalle descarte
            $detalle_descarte = $data['detalle_descarte'];
            $this->storeDetalleDescarte($detalle_descarte,$id_cabecera);


            //detalle de choferes
            $conductores = $data['conductores'];
            $this->storeDetalleChofer($conductores,$id_cabecera);




            return 'correcto';
        });
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



    public function storeDetalleUva($detalle_uva,$id_cabecera){

        foreach ($detalle_uva as $item){

            $n_pesadas = $item['n_pesadas'];
            $n_guia = $item['n_guia'];
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

    }

    public function storeDetalleDescarte($detalle_descarte,$id_cabecera){

        foreach ($detalle_descarte as $item){


            $fundo_parron = $item['fundo_parron'];
            $variedad = $item['variedad'];
            $racimo = $item['racimo'];
            $baya = $item['baya'];
            $k_racimo = $item['k_racimo'];
            $k_baya = $item['k_baya'];
            $porcentaje = $item['porcentaje'];
            $total = $item['total'];


            \DB::insert("INSERT INTO sirag.detalle_descarte (fundo_parron , variedad , racimo ,baya
                        ,k_racimo , k_baya , porcentaje , total , id_ingreso_MP ) VALUES
                     ('$fundo_parron', '$variedad', $racimo,$baya,$k_racimo,$k_baya,$porcentaje,
                     $total,'$id_cabecera')");

        }

    }

    public function storeDetalleChofer($conductores,$id_cabecera){

        foreach ($conductores as $item){

            $dni = $item['dni'];
            $placa = $item['placa'];

            \DB::insert("INSERT INTO sirag.detalle_chofer_mp (placa , dni_chofer , id_ingreso_mp ) VALUES
                     ('$placa', '$dni', $id_cabecera)");
        }

    }

    public function updateDetalleUva($data){

    }

    public function updateDetalleDescarte($data){

    }

    public function deleteDetalleUva($id){

        $q = "delete from sirag.detalle_uva where id_ingreso_MP = $id";

         \DB::delete($q);

    }

    public function deleteDetalleDescarte($id){
        $q = "delete from sirag.detalle_descarte where id_ingreso_MP = $id";

        \DB::delete($q);

    }

    public function deleteDetalleChofer($id){
        $q = "delete from sirag.detalle_chofer_mp where id_ingreso_MP = $id";

        \DB::delete($q);

    }




}