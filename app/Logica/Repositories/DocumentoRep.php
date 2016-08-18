<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 10/08/2016
 * Time: 02:16 PM
 */

namespace sirag\Repositories;
use sirag\DTO\DocumentoDTO;
use sirag\DTO\DetalleDocDTO;

class DocumentoRep
{

    /*funcion para sacar los reportes de los documentos*/
    public function getDocumentoByParameters($data)
    {
        $docDTO = new DocumentoDTO();

        $f_inicio = $data['f_inicio'];
        $f_fin = $data['f_fin'];
        $tipo_doct =$data['tipoDoct'];


        //echo("EXECUTE ps_getVAllDocsByParameters @f_inicio= '$f_inicio', @f_fin= '$f_fin', @t_comprobante= '$tipo_doct' ");

        //primero traemos a todos los documentos
        $docDTO = \DB::select("EXECUTE ps_getVAllDocsByParameters @f_inicio= '$f_inicio', @f_fin= '$f_fin', @t_comprobante= '$tipo_doct' ");



        return $docDTO;


    }


    /*funciones ghelpers que pueden ser usadas si son requeidas*/

    //--funcion para traer detalle del documento con el producto asigndo a este producto
    public function getDetalleDocByID($id)
    {
        $dtalleDocDTO = new DetalleDocDTO();

        $dtalleDocDTO = \DB::select("exec ps_getVAllDetailsByIdDoc @Id = $id;");

        return $dtalleDocDTO;

    }


}