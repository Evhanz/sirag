<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

    public function __construct(DocumentoRep $documentoRep,TipoDocumentoRep $tipoDocumentoRep,ProductoRep $productoRep,
                                ProveedorRep $proveedorRep){
        $this->documentoRep = $documentoRep;
        $this->tipoDocuementoRep = $tipoDocumentoRep;
        $this->productoRep = $productoRep;
        $this->proveedorRep = $proveedorRep;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

}
