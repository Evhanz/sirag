<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use sirag\Helpers\HelpFunct;
use sirag\Helpers\NumberToLetter;
use sirag\Repositories\ContabilidadRep;
use sirag\Repositories\ProductoRep;

use Maatwebsite\Excel\Facades\Excel;

class ContabilidadController extends Controller
{

    protected $contabilidadRep;
    protected $productoRep;


    function __construct(ContabilidadRep $contabilidadRep,ProductoRep $productoRep)
    {
        $this->contabilidadRep = $contabilidadRep;
        $this->productoRep = $productoRep;
    }


    public function viewBalanceGeneral(){

        return view('cc/viewBalanceGeneral');

    }


    public function viewControlOrdenCompra()
    {
        return view('cc/viewControlOrdenCompra');
    }

    public function viewPDB()
    {
        return view('cc/viewPDB');
    }


    public function viewConsumoByFundo()
    {
        return view('cc/viewConsumoByFundo');
    }

    public function viewComprobanteEgreso(){
        return view('cc/viewComprobanteEgreso');
    }


    public function viewRetenciones(){
        return view('cc/viewRetenciones');
    }



    public function sendDataForExcelConsumo()
    {


          //aumente el tiempo de espera del servidor

            set_time_limit (360);
        //


        $data = \Input::all();


        if($data['cc']=='materiaPrima')
        {
            $res            = $this->contabilidadRep->sendDataForExcelConsumo($data);
        }else{
            $res            = $this->contabilidadRep->sendDataForExcelConsumo($data);
        }



        $res['fundo']   = $data['fundo'];
        $res['f_otros'] = $data['otros']; 

        $ruta =base_path()."/storage/contabilidad/excel/";

        Excel::create('consumo_por_fundo', function($excel) use ($res){

            $excel->sheet('resultado', function($sheet) use ($res){

                $parrones   =   $res['parrones'] ;
                $productos  =   collect($res['productos']) ;
                $fundo      =   $res['fundo'];
                $otros      =   $res['otros'];
                $f_otros_i  =   $res['f_otros_i'];//fecha de los productos que no registran parron
                $f_otros_f  =   $res['f_otros_f'];

                $sheet->loadView('cc/excelConsumoByFundoAndParron',compact('parrones','productos','fundo','otros','f_otros_i','f_otros_f'));
            });

        })->store('xls',$ruta);


        return \Response::json("correcto");
    }


    public function getExcelConsumoByFundo(){
        return response()->download(base_path()."/storage/contabilidad/excel/consumo_por_fundo.xls");
    }

    public function getExcelConsumoByFundo2(){
        return response()->download(base_path()."/storage/contabilidad/excel/consumo_por_fundo_cci.xls");
    }


    
    //APIS

    public function getBalanceByNiveles()
    {
        # code...

        $data = \Input::all();

        $res = $this->contabilidadRep->getBalanceByNiveles($data);


        return \Response::json($res);

    }




    public function getFamiliasProductos()
    {
        $res = $this->productoRep->getAllFamilias();

        return  \Response::json($res);
    }

    public function getAllSubFamiliasProductos()
    {
        $res = $this->productoRep->getAllSubFamilias();
    }

    public function getAllInitDataConsumoReporte()
    {

       $familias = $this->productoRep->getAllFamilias();
       $subFamilias = $this->productoRep->getAllSubFamilias();
       $fundos = $this->contabilidadRep->getFundos();

      // $data['familias'] = $familias;
      // $data['subFamilias'] = $subFamilias;
       $data['fundos'] = $fundos;




       return \Response::json($data);

    }


    public function getParronByFundo($fundo)
    {
        
        $res = $this->contabilidadRep->getParronByFundo($fundo);

        return \Response::json($res);
    }



    //funcion para el control de las ordenes de compras 
    public function getOrdenCompraForControl()
    {
       

        $data = \Input::all();

        $res = $this->contabilidadRep->getOrdenCompraForControl($data);


        return \Response::json($res);

    }

    public function getGuiasAtendidasOfOC()
    {
        $data = \Input::all();

        $res = $this->contabilidadRep->getGuiasAtendidasOfOC($data);


        return \Response::json($res);


    }



    public function getCciByCodigo($codigo)
    {
        $res = $this->contabilidadRep->getCciByCodigo($codigo);

        return \Response::Json($res);

    }


    // -- esto es para el txt

    public function pdbTxtCompras()
    {

        //aumente el tiempo de espera del servidor

            set_time_limit (180);
        //

        $data  = \Input::all();

        
        // traemos la data de acuerdo a la fecha 

        $res = $this->contabilidadRep->pdbCompras($data['periodo']);
        $row = "";
        $body = "";


        foreach ($res as $item) {

            $bandera = 0;

            $row.=trim($item->c1).'|';
            $row.=trim($item->c2).'|';
            $row.=$this->changeFormatFecha($item->c3).'|';
            $item->c4 = str_replace('-','',$item->c4);
            $row.=trim($item->c4).'|';
            $row.=trim($item->c5).'|';
            $row.=trim($item->c6).'|';
            $row.=trim($item->c7).'|';
            $row.=trim($item->c8).'|';
            $row.=trim(HelpFunct::sanear_string($item->c9)).'|';
            $row.=trim(HelpFunct::sanear_string($item->c10)).'|';
            $row.=trim(HelpFunct::sanear_string($item->c11)).'|';
            $row.=trim(HelpFunct::sanear_string($item->c12)).'|';
            $row.=trim(HelpFunct::sanear_string($item->c13)).'|';
            $row.=trim($item->c14).'|';
            $row.=trim($item->c15).'|';
            $row.=trim($item->c16).'|';
            $row.=number_format(trim($item->c17),2, ".", "").'|';
            $row.=trim($item->c18).'|';
            $row.=number_format(trim($item->c19),2, ".", "").'|';
            $row.=number_format(trim($item->c20),2, ".", "").'|';
            $row.=trim($item->c21).'|';
            $row.=trim($item->c22).'|';
            $row.=trim($item->c23).'|';
            $row.=trim($item->c24).'|';
            $row.=trim($item->c25).'|';
            $row.=trim($item->c26).'|';
            $row.=trim($item->c27).'|';
            $row.=trim($item->c28).'|';
            $row.=trim($item->c29).'|';
            $row.=trim($item->c30).'|';


            /*

           foreach ($item as $val){

               if ($val != '|'){


                   if ($bandera == 2) {
                       $val = $this->changeFormatFecha($val);
                   }


                   $row.=trim($val).'|';
               }
               else
                   $row.=$val;




               $bandera++;

           }*/

           $row .= "\r\n";
        }


        $name_file= "C20518803078".$data['periodo'].".txt";


        $f['body'] = $row;
        $url ="C20518803078".$data['periodo'];

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);




            return "correcto";
            
        } catch (\Exception $e) {
            return "error :-";
        }
    }

    public function getTxtCompras($periodo){
        return response()->download(base_path()."/storage/logs/C20518803078$periodo.txt");
    }


    public function pdbTxtVentas()
    {
        # code...
        //aumente el timpo

            set_time_limit (180);
        //

        $data  = \Input::all();

        
        // traemos la data de acuerdo a la fecha 

        $res = $this->contabilidadRep->pdbVentas($data['periodo']);
        $row = "";
        $body = "";
        $row = "";


        foreach ($res as $item) {

            $bandera = 0;

            $row.=trim($item->c1).'|';
            $row.=trim($item->c2).'|';
            $row.=$this->changeFormatFecha($item->c3).'|';
            $row.=trim($item->c4).'|';
            $row.=trim($item->c5).'|';
            $row.=trim($item->c6).'|';
            $row.=trim($item->c7).'|';
            $row.=trim($item->c8).'|';
            $row.=trim($item->c9).'|';
            $row.=trim($item->c10).'|';
            $row.=trim($item->c11).'|';
            $row.=trim($item->c12).'|';
            $row.=trim($item->c13).'|';
            $row.=trim($item->c14).'|';
            $row.=trim($item->c15).'|';
            $row.=trim($item->c16).'|';
            $row.=number_format(trim($item->c17), 2,".", "").'|';
            $row.=trim($item->c18).'|';
            $row.=trim($item->c19).'|';
            $row.=trim($item->c20).'|';
            $row.=trim($item->c21).'|';
            $row.=trim($item->c22).'|';
            $row.=trim($item->c23).'|';
            $row.=trim($item->c24).'|';
            $row.=trim($item->c25).'|';
            $row.=trim($item->c26).'|';
            $row.=trim($item->c27).'|';
            $row.= ($item->c28='' || is_null($item->c28)) ? ''.'|' : $this->changeFormatFecha($item->c28).'|' ;
            //$row.=$this->changeFormatFecha($item->c28).'|';
            $row.=number_format(trim($item->c29), 2, ".", "").'|';
            $row.=number_format(trim($item->c30), 2, ".", "").'|';

           $row .= "\r\n";
        }
        

        $name_file= "V20518803078".$data['periodo'].".txt";


        $f['body'] = $row;
        $url ="V20518803078".$data['periodo'];

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);
            return "correcto";
            
        } catch (\Exception $e) {
            return "error :-";
        }

    }

    public function getTxtVentas($periodo){
        return response()->download(base_path()."/storage/logs/V20518803078$periodo.txt");
    }


    //--
    public function getTipoCambio()
    {
        $data = \Input::all();

        $res = $this->contabilidadRep->getTipoCambio($data);

        $row = "";
        $body = "";
        

       
        foreach ($res as $item) {

           
            $row.=$this->changeFormatFecha($item->c1).'|';
            $row.=trim($item->c2).'|';
            $row.='|';

            $row .= "\r\n";
        }
        

        $name_file= "20518803078.tc";


        $f['body'] = $row;
        $url ="20518803078";

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);
            return "correcto";
            
        } catch (\Exception $e) {
            return "error :-";
        }
    }


    public function getTxtTipoCambio(){
        return response()->download(base_path()."/storage/logs/20518803078.tc");
    }


    public function getConsumoByFechas($data) 
    {
        $f_i = $data['f_i'];
        $f_f = $data['f_f'];

        $query = "EXEC SP_getConsumo '2016-09-01','2016-10-01';";

        $res = \DB::select();


    }



    // -- esto es para excel


    public function pdbExcelCompras($periodo)
    {   

      //aumente el timpo

            set_time_limit (180);
        //

        $res = $this->contabilidadRep->pdbCompras($periodo);
    
        Excel::create('C20518803078', function($excel) use ($res){
 
            $excel->sheet('Productos', function($sheet) use ($res){
 
                
                $sheet->fromArray($res);
 
            });
        })->export('csv');
              
    }



    public function getDataForExcelConsumo2(){

        $data = \Input::all();

        //return \Response::Json($data);


        if($data['fundo'] != ''){
            $res = $this->contabilidadRep->getDataForExcelConsumo2($data);

            $res['fundo']   = $data['fundo'];

            $ruta =base_path()."/storage/contabilidad/excel/";

            Excel::create('consumo_por_fundo_cci', function($excel) use ($res){

                $excel->sheet('resultado', function($sheet) use ($res){

                    $parrones   =   $res['parrones'] ;
                    $productos  =   collect($res['productos']) ;
                    $fundo      =   $res['fundo'];
                    $cci        =    $res['cci'];
                    $otros      =   $res['otros'];
                    $f_otros_i  =   $res['f_otros_i'];
                    $f_otros_f  =   $res['f_otros_f'];

                    $sheet->loadView('cc/excelConsumoByFundoAndParron',compact('parrones','productos','fundo','cci','otros','f_otros_i','f_otros_f'));
                });

            })->store('xls',$ruta);


            return \Response::json("correcto");
        }else{

            $res = $this->contabilidadRep->getDataForExcelConsumoAll($data);

            $ruta =base_path()."/storage/contabilidad/excel/";

            Excel::create('consumo_por_fundo_cci', function($excel) use ($res){

                $excel->sheet('resultado', function($sheet) use ($res){

                    $otros      =   $res['otros'];
                    $f_otros_i  =   $res['f_otros_i'];
                    $f_otros_f  =   $res['f_otros_f'];

                    $sheet->loadView('cc/excel/consumoFundoParronTodo',compact('otros','f_otros_i','f_otros_f'));
                });

            })->store('xls',$ruta);


            return \Response::json("correcto");
        }




       // $data = \Input::all();


    }



    public function getRetenciones(){

        $data = \Input::all();


        $res = $this->contabilidadRep->getRetenciones($data);


        return \Response::Json($res);


    }


    public function updateRetencion(){

        $data = \Input::all();
        $item = $data['item'];

        $res = $this->contabilidadRep->updateRetencion($item);

        return $res;

    }


    public function buildTxtRetenciones(){

        $data = \Input::all();

        $fecha = $data['fecha'];
        if(isset($data['num_veces'])){
            $num_veces = $data['num_veces'];
        }else{
            $num_veces = 1;
        }


        $res = $this->contabilidadRep->getFormatOfRetencion($fecha);

        //'2017-01-26'


        $row = "";
        $new_fecha = explode('-',$fecha);
        $new_fecha = $new_fecha[0].$new_fecha[1].$new_fecha[2];

        foreach ($res as $item) {


            $row.=trim($item->c1).'|';
            $row.=$item->c2.'|';
            $row.=$item->c3.'|';
            $row.= $this->changeFormatFecha($item->c4).'|';
            $row.=$item->c5.'|';
            $row.=$item->c6.'|';
            $row.=$item->c7.'|';
            $row.=$item->c8.'|';
            $row.=$item->c9.'|';
            $row.=round($item->c10,2).'|';
            $row.=round($item->c11,2).'|';
            $row.=$item->c12.'|';
            $row.=$item->c13.'|';
            $row.=$item->c14.'|';
            $row.= $this->changeFormatFecha($item->c15).'|';
            $row.=round($item->c16,2).'|';
            $row.=$item->c17.'|';
            $row.= $this->changeFormatFecha($item->c18).'|';
            $row.=$item->c19.'|';
            $row.=round($item->c20,2).'|';
            $row.=$item->c21.'|';
            $row.=round($item->c22,2).'|';
            $row.= $this->changeFormatFecha($item->c23).'|';
            $row.=round($item->c24,2).'|';
            $row.=$item->c25.'|';
            $row.=round($item->c26,2).'|';
            $row.= $this->changeFormatFecha($item->c27).'|';

            $row .= "\r\n";
        }


        $name_file= "20518803078-20-$new_fecha-$num_veces.txt";


        $f['body'] = $row;
        $url ="20518803078";

        try {
            $file = fopen(base_path()."/storage/logs/$name_file", "w");
            fputs($file,$f['body'] );
            fclose($file);
            return ['estado'=>"correcto",'file'=>$name_file];

        } catch (\Exception $e) {
            return "error :-";
        }





    }


    public function getTxtRetenciones($file){
        return response()->download(base_path()."/storage/logs/$file");
    }


    public function getLibroRetenciones(){

        $data = \Input::all();

        $fecha = $data['anio'].'-'.$data['mes'].'-%';

        $res = $this->contabilidadRep->getFormatOfRetencion($fecha);

        foreach ($res as $item){

            $item->c4 = $this->changeFormatFecha($item->c4);
            if( $item->c3 == 6){
                $item->c3  = '000'.$item->c3;
            }

        }


        $newDate = getdate();

        if($newDate['mon'] < 10){

            $newDate['mon'] = '0'.$newDate['mon'];
        }

        $newDate = $newDate['mday'].'/'.$newDate['mon'].'/'.$newDate['year'];
        $fecha_actual = $newDate;

        $mes = HelpFunct::NameMonth($data['mes']);
        $anio = $data['anio'];


        $view =  \View::make('cc.pdf.libroRetenciones',compact('res','fecha_actual','mes','anio'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        // return $pdf->stream('invoice');
        return $pdf->download('libro_retenciones');

        //return view('rh.pdf.comprobanteEgresoPdf')

    }


    public function getComprobanteRetencion(){

        $data = \Input::all();

        $fecha = $data['fecha'];
        $correlativo = $data['correlativo'];

        $res = $this->contabilidadRep->getFormatOfRetencion($fecha,$correlativo);
        $cabecera = null;

        if (count($res)>0){

            $newDate = getdate();

            if($newDate['mon'] < 10){

                $newDate['mon'] = '0'.$newDate['mon'];
            }

            $newDate = $newDate['mday'].'/'.$newDate['mon'].'/'.$newDate['year'];

            $cabecera['razon'] = $res[0]->c7;
            $cabecera['ruc'] = $res[0]->c5;
            $cabecera['fecha_emision1'] = $newDate;


            $total['monto']=0;

            foreach ($res as $item){
                $item->tipo =  $item->c12;
                $item->serie = $item->c13;
                $item->correlativo = $item->c14;
                $item->fecha_emision = $this->changeFormatFecha($item->c15);
                $item->monto_pago = round($item->c20,2) ;
                $item->monto_retenido = round($item->c22,2);

                $total['monto'] +=round($item->c22,2);

            }

            $total['monto_letras'] = NumberToLetter::convert($total['monto']);


            $view =  \View::make('cc.pdf.comprobanteRetencion',compact('res','total','cabecera'))->render();


            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);


            $ruta = base_path()."/storage/contabilidad/retenciones/comprobantes/l".$correlativo.'.pdf';
            $pdf->save($ruta);

         //   return 'correcto';


            /*
            $file = fopen(base_path()."/storage/contabilidad/retenciones/comprobantes/l".$correlativo.'.html', "w");
            fputs($file,$view );
            fclose($file);
            */

            return "correcto";


          //  return $view;


        }else{
            return 'No existen datos para mostrar';
        }

    }


    public function getComprobanteRetencionPdf($code){

       return response()->download(base_path()."/storage/contabilidad/retenciones/comprobantes/l".$code.'.pdf');


        /*
        $filename = 'test.pdf';
        $path = base_path()."/storage/contabilidad/retenciones/comprobantes/l".$code.'.html';

        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);

        */

    }



    //funciones helpers

    //-- change formato de fechas de yyyy-mm-dd

    public function changeFormatFecha($fecha)
    {
        
        $fecha = explode("-", $fecha);

        if(count($fecha)== 3){

        $fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];

        }else{
            $fecha = "** no hay fecha **";
        }


        return $fecha;

    }


    public function getComprobanteDeEgresoPdf()
    {


        $data = \Input::all();

        $response = $this->contabilidadRep->getComprobanteEgreso($data);

        $res = $response->data;
        $totales  = $response->totales;

        $newDate = getdate();

        if($newDate['mon'] < 10){

            $newDate['mon'] = '0'.$newDate['mon'];
        }


        $newDate = $newDate['mday'].'/'.$newDate['mon'].'/'.$newDate['year'];

        $res[0]->fecha_actual = $newDate;




        $view =  \View::make('cc.pdf.comprobanteEgresoPdf',compact('res','totales'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        // return $pdf->stream('invoice');
        return $pdf->download('comprobante_egreso');

        //return view('rh.pdf.comprobanteEgresoPdf');

    }

    public function getValuesOfOtherDB(){

        $res = \DB::select('select * from DICON.dbo.Bancos');

        dd($res);


    }

}
