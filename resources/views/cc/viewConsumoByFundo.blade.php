@extends('layout')

@section('content')



    
    <script src="{{ asset('js/plugins/moment/moment.js') }}"></script>

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/angular/angular-daterangepicker/angular-daterangepicker.js') }}"></script>
    



    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Consumo </a></li>
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
                                            <div class="col-md-2">
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
                                                <label for="">*Las fechas se encuentran en MM-DD-YYYY</label>
                                            </div>

                                        </div>

                                        <br><br>

                                        <div class="row">

                                           
                                            <div ng-repeat="parron in parrones" class="col-md-3">
                                                <label for="">@{{  parron.CODIGO }}</label>
                                                <input  name="data_range" date-range-picker class="form-control date-picker" type="text" ng-model="parron.fecha" ng-init="parron.fecha={startDate: null, endDate: null}" />
                                                
                                            </div>

                                            <div class="col-md-3"> 
                                                <label for="">Otros</label>
                                                <input  name="data_range2" date-range-picker class="form-control date-picker" type="text" ng-model="fecha_otros" ng-init="fecha_otros={startDate: null, endDate: null}"  />

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

        $('input[name="data_range"]').daterangepicker({
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


        var app = angular.module("app",['daterangepicker']);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];
            $scope.otros = {};

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

                angular.forEach($scope.parrones,function(item){

                    var fecha = item.fecha;

                    if (fecha.endDate == null || fecha.startDate == null) {
                        bandera = 1;
                    }else{

                        var f           = new Date(fecha.endDate);
                        item.endDate    = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();

                        var f = new Date(fecha.startDate);
                        item.startDate = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
                    }

                });


                var fecha = $scope.fecha_otros;

                if (fecha.endDate == null || fecha.startDate == null) {
                    bandera = 1;
                }else{
                    var f = new Date(fecha.endDate);
                    $scope.otros.endDate = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
                    var f = new Date(fecha.startDate);
                    $scope.otros.startDate = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
                }

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

                    var ruta = "{{ URL::route('sendDataForExcelConsumo') }}";
                    var token = $('#_token').val();

                    $http.post(ruta,{
                        _token   : token,
                        parrones : $scope.parrones,
                        fundo    : $("#f_fundo").val(),
                        otros    : $scope.otros,
                        cc       : cc

                    }).success(function (data) {

                        if (data=="correcto") {
                           
                            var url         = '{{ URL::route('getExcelConsumoByFundo') }}';
                            window.location = url;
                            $('#btnExcel').attr("disabled", false);

                        }else{
                        alert("Ocurrio un error, llamar al area de soporte");
                        $('#btnExcel').attr("disabled", false);
                        }
                        
                    }).error(function (data) {
                        alert("Ocurrio un error, llamar al area de soporte");
                        $('#btnExcel').attr("disabled", false);
                        console.log(data);
                    });


               }else{

                alert("Todos los parrones tienen que tener fecha");
               }

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

