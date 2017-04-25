<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use sirag\Repositories\ContabilidadRep;
use sirag\Repositories\DocumentoRep;
use sirag\Repositories\ProductoRep;
use sirag\Repositories\TipoDocumentoRep;
use sirag\Repositories\ProveedorRep;
class ComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $documentoRep;
    protected $tipoDocuementoRep;
    protected $productoRep;
    protected $proveedorRep;
    protected $contabiliddaRep;

    public function __construct(DocumentoRep $documentoRep,TipoDocumentoRep $tipoDocumentoRep,ProductoRep $productoRep,ProveedorRep $proveedorRep, ContabilidadRep $contabilidadRep){
        $this->documentoRep = $documentoRep;
        $this->tipoDocuementoRep = $tipoDocumentoRep;
        $this->productoRep = $productoRep;
        $this->proveedorRep = $proveedorRep;
        $this->contabilidadRep = $contabilidadRep;
    }



    /*de aqui son todo de los reportes en vistas*/

    public function viewDocumentos()
    {
        /*documentos*/
        return view('comercial/viewDocumentos',compact('documentos'));
    }


    public function  viewRepProductos()
    {
        return view('comercial/viewProductos');
    }


    public function viewOrdenCompra()
    {
        return view('comercial/viewOrdenCompra');
    }

    public function viewControlOrdenCompra()
    {
       return view('comercial/viewControlOrdenCompra');
    }

    public function viewKardex()
    {
        return view('comercial/viewKardex');
    }

    public function viewConsumoByFundoComercial(){
        return view('cc/viewConsumoByFundo');
    }

    public function viewSeguimientoGuia(){
        return view('comercial/viewSeguimientoGuia');
    }




    /*funciones para el rest de los documentos*/
    public function getAllDocumentosByParameters()
    {
        $parameters = \Input::all();

        $res = $this->documentoRep->getDocumentoByParameters($parameters);

        return \Response::Json($res);
    }

    public function getDetalleByIdDoc($id)
    {
        $detalle = $this->documentoRep->getDetalleDocByID($id);

        return \Response::Json($detalle);

    }

    public function getAllDocumentos(){
        $tipoDocs = $this->tipoDocuementoRep->getAllDocumentoRep();

        return \Response::Json($tipoDocs);
    }

    public function getAllFamilias()
    {
        $f = $this->productoRep->getAllFamilias();

        return \Response::Json($f);

    }

    public function getAllSubFamilias()
    {
        $f = $this->productoRep->getAllSubFamilias();

        return \Response::Json($f);

    }


    public function getAllProductosByProveedor()
    {
        $parameters = \Input::all();

        $res = $this->productoRep->getAllProductosByProveedor($parameters);

        return \Response::Json($res);

    }


    public function  getDetailProductoCompra(){
        $parameters = \Input::all();

        $res = $this->productoRep->getDetailProductoCompra($parameters);

        return \Response::Json($res);
    }



    public function apiGetKardexSalida()
    {
        
        $data = \Input::all();

        $res = $this->productoRep->getKardexSalida($data);

        return \Response::Json($res);



    }
    public function apiGetKardexEntrada()
    {

        $data = \Input::all();

        $res = $this->productoRep->getKardexEntrada($data);

        return \Response::Json($res);
        
    }





    /*API REST para los proveedores*/

    public function getProveedoresByRazonAndRUC()
    {
        $data = \Input::all();

        $res = $this->proveedorRep->getProveedoresByRazonAndRUC($data);

        return \Response::Json($res);

    }

    public function  getProductosComercioProveedor($ruc){

        $res = $this->proveedorRep->getProductosComercioProveedor($ruc);

        return \Response::Json($res);

        //var_dump($res);        
    }

    //API para las sordenes de compra

    public function getOrdenesCompra()
    {
        $data = \Input::all();

        $res = $this->documentoRep->getOrdenesCompras($data);

        return \Response::Json($res);

    }

    public function getDetailOrden($id)
    {
        $res = $this->documentoRep->getDetailOrden($id);

        return \Response::Json($res);
    }


    public function getKardex(){

        set_time_limit (360);

        $data = \Input::all();

        $res = $this->productoRep->getKardex($data);

        return \Response::Json($res);


    }

    public function getGuiaFaltaFactura(){
        $data = \Input::all();

        $fecha = $data['fecha'];

        $res = $this->documentoRep->getGuiaFaltaFactura($fecha);
        return \Response::Json($res);

    }

    public function excelControlOrdenCompraComercial()
    {

        $data = \Input::all();

        if (!isset($data['proveedor'])) {
            $data['proveedor'] = '';
        }
        if (!isset($data['numero'])) {
            $data['numero'] = '';
        }

        $fechas = explode('-', $data['daterange']);
        $data['f_inicio'] = trim($fechas[0]);
        $data['f_fin'] = trim($fechas[1]);

        $res = $this->contabilidadRep->getOrdenCompraForControl($data);

        $res = collect($res);
        $res  = $res->filter(function ($value) {
            return $value->estado != 'COMPLETADO';
        });

        $res = $res->groupBy('Numero');
       // dd($res);

        $pdf = \PDF::loadView('cc.excel.controlOrdenCompra', ['ordenes'=>$res] );
        return $pdf->stream('invoice.pdf');

    }
    

    /*esto es para reportes en PDF*/
    public function getPDFProductProveedor($glosa,$subfamilia,$familia)
    {
        if($glosa=='-'){
            $glosa='';
        }
        if($subfamilia=='-')
            $subfamilia='';
        if($familia=='-')
            $familia='';

        $parameters['glosa'] = $glosa  ;
        $parameters['subfamilia'] = $subfamilia;
        $parameters['familia'] = $familia;


        $productos = $this->productoRep->getAllProductosByProveedor($parameters);

        $pdf = \PDF::loadView('comercial.R_pdf.r_Product_Proveedores', ['productos'=>$productos] );
        return $pdf->stream('invoice.pdf');

    }


    public function excelConsumoPorCCI(){

        $data = \Input::all();
        $fechas =  explode('-',$data['daterange']);

        $data['f_inicio'] = trim($fechas[0]);
        $data['f_fin'] = trim($fechas[1]);
        $data['cci'] = '( '.$data['tags'].') ';

        $res = $this->productoRep->getSalidaByCCI($data);


        \Excel::create('Consumo CCI', function($excel) use ($res) {

            $excel->sheet('Productos', function($sheet) use ($res) {

                $data = array();

                foreach ($res as $result) {
                    $data[] = (array)$result;
                }

                $sheet->fromArray($data);

            });
        })->export('xlsx');


        dd($res);

    }

    public function getExcelRequerimiento(){

        $data = \Input::all();
        $fechas = explode('-',$data['rango_requerimiento']);
        $data['f_inicio'] = trim($fechas[0]) ;
        $data['f_fin'] = trim($fechas[1]) ;

        $res = $this->documentoRep->getRequerimiento($data);

        if($data['option'] == 'pdf'){
            $pdf = \PDF::loadView('comercial.R_pdf.r_requerimientos', ['requerimientos'=>$res] );
            return $pdf->stream('invoice.pdf');
        }else{

            \Excel::create('Requerimientos', function($excel) use ($res) {

                $excel->sheet('Sheetname', function($sheet) use($res) {

                    $sheet->fromModel($res);

                });
            })->export('xlsx');

        }




    }

}
