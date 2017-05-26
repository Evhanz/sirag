@extends('layout')

@section('content')




    <script src="{{ asset('js/plugins/moment/moment.js') }}"></script>

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
   <!-- <script src="{{ asset('js/plugins/angular/angular-daterangepicker/angular-daterangepicker.js') }}"></script> -->
    



    <div ng-app="app" ng-controller="PruebaController">
        <div class="content">

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a ng-click="changeOption('consumo')"  data-toggle="tab" href="#home">Consumo </a></li>
                            <li ><a  ng-click="changeOption('cci')" data-toggle="tab" href="#home"> Consumo Por CCI </a></li>
                            <li ><a  ng-click="changeOption('macro')" data-toggle="tab" href="#macro"> Consumo Por CCI Macro</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;padding-right: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <!--
                                            <div class="col-md-2">
                                                <label for="" >Familia </label><br>
                                                <select class="form-control" ng-model="familia.RELACIONCODIGO1" id="f_familia">
                                                    <option value="">---------</option>
                                                    <option ng-repeat="familia in familias "
                                                                value="@{{familia.CODIGO}}">
                                                            @{{familia.CODIGO}}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="" >Sub Familia</label><br>
                                                <select class="form-control" ng-model="subFamilia" id="f_subfamilia">
                                                    <option value="">---------</option>
                                                    <option ng-repeat="item in subfamilias | filter:familia" value="@{{item.CODIGO}}">
                                                            @{{item.CODIGO}}
                                                    </option>
                                                </select>
                                            </div>
                                            -->
                                            <div class="col-md-2" id="mdCentroCosto">
                                                <label for="">Centro de Costo</label>
                                                <select name="" id="selCentroCosto" class="form-control">
                                                    <option value="materiaPrima">Materia Prima</option>

                                                    @if(Auth::user()->hasAnyRole(['ADMIN','CONTABILIDAD']))
                                                        <option value="gif">G.I.F.</option>
                                                    @endif

                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Fundo</label>
                                                <select class="form-control" ng-model="f_fundo" id="f_fundo">
                                                    <option value="">---------</option>
                                                    <option ng-repeat="fundo in fundos "
                                                                value="@{{fundo.CODIGO}}">
                                                            @{{fundo.CODIGO}}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="">*Las fechas se encuentran en DD-MM-YYYY</label>
                                            </div>

                                        </div>

                                        <br><br>

                                        <div class="row">

                                           
                                            <div ng-repeat="parron in parrones" class="col-md-3">
                                                <label for="">@{{  parron.CODIGO }}</label>
                                                <input id="date_@{{ $index }}"  name="data_range2"  class="form-control date-picker" type="text" ng-model="parron.fecha" ng-change="asign_fecha($index)"  ng-init="convert_input_date()"/>
                                                
                                            </div>

                                            <div class="col-md-3" id="mdOtros">
                                                <label for="">Otros</label>
                                                <input  name="data_range2" class="form-control" type="text" ng-model="fecha_otros" id="fecha_otros"  />

                                            </div>
                                        </div>
                                        
                                        <hr>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <button href="" class="btn btn-success" id="btnExcel" ng-click="sentData()">
                                                    <i class="fa fa-file-excel-o"></i> 
                                                    <strong>Generar Excel</strong> </button>
                                            </div>
                                           
                                        </div>

                                    </div>
                                    <!-- Tab filtro documento -->
                                    <div id="macro" class="tab-pane fade">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <div class="col-md-2">
                                                <label for="">Fundo</label>
                                                <select class="form-control" ng-model="f_fundo" id="f_fundo_macro">
                                                    <option value="">---------</option>
                                                    <option ng-repeat="fundo in fundos "
                                                            value="@{{fundo.CODIGO}}">
                                                        @{{fundo.CODIGO}}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="">*Las fechas se encuentran en DD-MM-YYYY</label>
                                                <input  name="data_range2" class="form-control" type="text" ng-model="fecha_filter_macro" id="fecha_filter_macro"  />
                                            </div>

                                        </div>

                                        <br><br>
                                        <!--
                                        <div class="row">
                                            @{{ parrones.length }}
                                        </div>
                                        -->

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <button href="" class="btn btn-success" id="btnExcel" ng-click="senDataMacro()">
                                                    <i class="fa fa-file-excel-o"></i>
                                                    <strong>Generar Excel</strong>
                                                </button>
                                            </div>

                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div><!-- /.row - inside box -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->


                <div class="col-lg-12">



                </div>
            </div>

           

           

        </div>



    </div>




    <script src="{{ asset('js/plugins/angular/angular-ui-bootstrap-0.3.0.min.js') }}"></script>
    <script>


        /*funciones de jquery*/

        $('input[name="data_range2"]').daterangepicker({
            format : "DD/MM/YYYY"
        });
        $('[data-toggle="tooltip"]').tooltip();

        /*
        $('input[name="data_range"]').daterangepicker(
        {
            {
              //format: 'YYYY-MM-DD'
              format: 'DD-MM-YYYY'
            }
        }
        */


        /*
         $(document).ready(function(){

         });*/




        /*----*/



        function imprimir()  {

            var fecha = $('input[name="daterange"]').val();

            fecha = fecha.split('-');
            var f_i = changeFormat(fecha[0]);
            var f_f = changeFormat(fecha[1]);

            $(".pvtTable").printThis({
                importCSS: true,
                loadCSS: "{{ asset('css/table_export.css')}}",
                header: "<h2>Reporte de centro de costos del :"+f_i+" al" +f_f+"  </h2>"
            });
        }


       

        /**/


        var app = angular.module("app",[]);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];
            $scope.otros = {};
            $scope.opcion = 'consumo';
            $scope.parrones = [];

            $scope.totales = {};

            var ruta = '';

          //  $scope.fecha_otros = {startDate: null, endDate: null};


            //funcioines que inician la pagina

            getInitData();


            //funcion para traer a todas las familias de los productos


            function getInitData(){

                var ruta = '{{ URL::route('getAllInitDataConsumoReporte') }}';


                $http.get(ruta)
                .success(function (data) {

                    //$scope.familias = data.familias;
                    //$scope.subfamilias = data.subFamilias;
                    $scope.fundos = data.fundos;

                    
                })
                .error(function (data) {
                    console.log(data);
                });

            }

            $("#f_fundo").change(function(){
                
                var fundo = $(this).val();

                var bandera = fundo.indexOf("FUNDO");

                if (bandera>-1) {

                    var f = "F"+fundo.substring(8,9);
                    var ruta = "{{ URL::route('modContabilidad') }}/api/getParronByFundo/"+f;
                    

                    $http.get(ruta)
                    .success(function(data){

                        $scope.parrones =[];

                        //console.log(data);
                        $scope.parrones = data;

                    })
                    .error(function(data){
                        console.log(data);
                    });

                    

                } else {


                    $scope.parrones =[];
                }


               // alert("Fundo: "+fundo);

            });

            $("#f_fundo_macro").change(function(){

                var fundo = $(this).val();

                var bandera = fundo.indexOf("FUNDO");

                if (bandera>-1) {

                    var f = "F"+fundo.substring(8,9);
                    var ruta = "{{ URL::route('modContabilidad') }}/api/getParronByFundo/"+f;


                    $http.get(ruta)
                        .success(function(data){

                            $scope.parrones =[];
                            //console.log(data);
                            $scope.parrones = data;
                        })
                        .error(function(data){
                            console.log(data);
                        });



                } else {


                    $scope.parrones =[];
                }


                // alert("Fundo: "+fundo);

            });

            $scope.sentData = function (){

               

                var bandera=0;

                //primero formateamos las fechas para determinar si estan en el rango



                angular.forEach($scope.parrones,function(item,index){

                    var fecha = $("#date_"+index).val();
                 //   console.log( $("#date_"+index).val());
                  //  console.log(fecha);
                    if(fecha === null || fecha ==='' || fecha.length ===0 ){
                        bandera = 1;
                    }else{
                        var fechas  = fecha.split('-');

                        var f           = fechas[0].trim().split('/');
                        item.startDate    = f[2]+"-"+f[1]+"-"+f[0];

                        var f           = fechas[1].trim().split('/');
                        item.endDate    = f[2]+"-"+f[1]+"-"+f[0];

                    }

                    /*

                    if (fecha.endDate == null || fecha.startDate == null) {
                        bandera = 1;
                    }else{

                        var f           = new Date(fecha.endDate);
                        item.endDate    = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();

                        var f = new Date(fecha.startDate);
                        item.startDate = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
                    }

                    */

                });

                    //var fecha = $scope.fecha_otros;

                    var fecha = $("#fecha_otros").val();

                    if(fecha === null || fecha ==='' || fecha.length ===0 ){
                        bandera = 1;
                    }else{
                        var fechas  = fecha.split('-');
                        var f           = fechas[0].trim().split('/');
                        $scope.otros.startDate    = f[2]+"-"+f[1]+"-"+f[0];
                        var f           = fechas[1].trim().split('/');
                        $scope.otros.endDate    = f[2]+"-"+f[1]+"-"+f[0];


                    }


                    /*

                    if (fecha.endDate == null || fecha.startDate == null) {
                        bandera = 1;
                    }else{
                        var f = new Date(fecha.endDate);
                        $scope.otros.endDate = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
                        var f = new Date(fecha.startDate);
                        $scope.otros.startDate = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
                    }

                    */

                /*
                if($scope.opcion == 'consumo'){

                }
                */

                //verificamos el centro de costo
                var cc = $("#selCentroCosto").val();

                if(cc.length == 0 || cc == null){
                    bandera = 1;
                    alert("tienes que elegir centro de costo");
                }
                //si la bandera = a 0 entonces se envia la data
               if(bandera == 0){

                    /*
                        fundo : modeloFundo,
                        parrones: $scope.parrones (parrones[endDate,starDate,CODIGO])


                    */

                    $('#btnExcel').attr("disabled", true);

                   var fundo = $("#f_fundo").val();
                   if($scope.opcion=='consumo'){
                       var ruta = "{{ URL::route('sendDataForExcelConsumo') }}";
                       var url         = '{{ URL::route('getExcelConsumoByFundo') }}';
                   }
                   else{
                       var ruta = "{{ URL::route('getDataForExcelConsumo2') }}";
                       var url         = '{{ URL::route('getExcelConsumoByFundo2') }}';
                       fundo = fundo.substring(8,9);
                   }

                    var token = $('#_token').val();

                  // console.log($scope.parrones);

                    $http.post(ruta,{
                        _token   : token,
                        parrones : $scope.parrones,
                        fundo    : fundo,
                        otros    : $scope.otros,
                        cc       : cc

                    })
                            .success(function (data) {

                        if (data=="correcto") {
                           

                            window.location = url;
                            $('#btnExcel').attr("disabled", false);

                        }else{
                        alert("Ocurrio un error, llamar al area de soporte");
                        $('#btnExcel').attr("disabled", false);
                            console.log(data);
                        }
                        
                    })
                            .error(function (data) {
                        alert("Ocurrio un error, llamar al area de soporte");
                        $('#btnExcel').attr("disabled", false);
                        console.log(data);
                    });


               }else{

                alert("Todos los parrones tienen que tener fecha");
               }

            };

            $scope.senDataMacro = function () {
                var  fundo = '';
                var token = $('#_token').val();
                if($scope.f_fundo === undefined){
                    fundo= '';
                }else{
                    fundo = ($scope.f_fundo).substring(8,9);
                }

                var fecha_filter_macro = $("#fecha_filter_macro").val();
                var f_i = '';
                var f_f = '';


                if(fecha_filter_macro.length>0 && fundo.length > 0){

                    var fechas =  fecha_filter_macro.split('-');
                    f_i = fechas[0].trim().split('/');
                    f_i = f_i[2]+"-"+f_i[1]+"-"+f_i[0];
                    f_f = fechas[1].trim().split('/');
                    f_f = f_f[2]+"-"+f_f[1]+"-"+f_f[0];

                    angular.forEach($scope.parrones,function(item,index){
                        item.startDate = f_i;
                        item.endDate = f_f;
                    });

                    var otros =  {startDate:f_i,endDate:f_f};

                    var ruta = '{{route('sendDataForExcelConsumoMacro')}}';
                    var url         = '{{ URL::route('getExcelConsumoByFundo2') }}';

                    $http.post(ruta,{
                        _token   : token,
                        parrones : $scope.parrones,
                        fundo    : fundo,
                        otros    : otros

                    })
                        .success(function (data) {

                            if (data=="correcto") {


                                window.location = url;
                                $('#btnExcel').attr("disabled", false);

                            }else{
                                alert("Ocurrio un error, llamar al area de soporte");
                                $('#btnExcel').attr("disabled", false);
                                console.log(data);
                            }

                        })
                        .error(function (data) {
                            alert("Ocurrio un error, llamar al area de soporte");
                            $('#btnExcel').attr("disabled", false);
                            console.log(data);
                        });

                }else {

                    alert('Debe Ingresar las fechas y Fundo');

                }

            };

            $scope.changeOption = function (option) {



                if(option == 'cci'){

                   // $('#mdOtros').hide();
                    $('#mdCentroCosto').hide();
                    $scope.opcion = 'cci';
                    var fundo = {};
                    fundo.CODIGO = 'TODOS';

                    var bandera = 0;

                    angular.forEach( $scope.fundos, function(value, key) {
                        if(value.CODIGO == 'TODOS'){
                            bandera = 1;
                        }
                    });

                    if(bandera == 0){
                        $scope.fundos.push(fundo);
                    }

                }
                if(option == 'consumo'){
                    //$('#mdOtros').show();
                    $('#mdCentroCosto').show();
                    $scope.opcion = 'consumo';
                }
                if(option == 'macro'){
                    //$('#mdOtros').show();
                    var bandera_index = '';
                    for(var i=0;i<$scope.fundos.length;i++){
                        if($scope.fundos[i].CODIGO === 'COSTO IND. X ASIGNAR') bandera_index = i;
                    }
                    if(bandera_index !== '') $scope.fundos.splice(bandera_index,1);

                    var fundo = {};
                    fundo.CODIGO = 'TODOS';

                    var bandera = 0;

                    angular.forEach( $scope.fundos, function(value, key) {
                        if(value.CODIGO == 'TODOS'){
                            bandera = 1;
                        }
                    });

                    if(bandera == 0){
                        $scope.fundos.push(fundo);
                    }


                }

            };

            $scope.convert_input_date = function () {
                $('input[name="data_range2"]').daterangepicker({
                    format : "DD/MM/YYYY"
                });
            };

            $scope.asign_fecha = function (index) {

                var date = $('#date_'+index).val();

                console.log(date);

            };

            /*funcion helper*/

            function formatDateToText(fecha) {
                // body...

                fecha = fecha.split("/");
                fecha = fecha[2].trim()+""+fecha[1].trim()+""+fecha[0].trim();
                return fecha;

            }




        });
    </script>


@stop

