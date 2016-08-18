<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 15/08/2016
 * Time: 05:42 PM
 */

namespace sirag\Repositories;

use sirag\Entities\TipoDocumento;

class TipoDocumentoRep
{

    public function getAllDocumentoRep()
    {
        $tipoDocumento = new TipoDocumento();
        $tipoDocumento = \DB::select("SELECT  TipoDocto,Sistema
 FROM flexline.TipoDocumento   where Empresa = 'E01' AND Vigente = 'S'
 AND (Sistema = 'Compras' or Sistema = 'Inventario' or Sistema = 'Ventas')");


       return $tipoDocumento;

    }


}