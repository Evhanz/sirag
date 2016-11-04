@extends('layout')

@section('content')

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

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
                                                <label for="">Fundo</label>
                                                <select class="form-control" ng-model="f_fundo" id="f_fundo">
                                                    <option value="">---------</option>
                                                    <option ng-repeat="fundo in fundos "
                                                                value="@{{fundo.CODIGO}}">
                                                            @{{fundo.CODIGO}}
                                                    </option>
                                                </select>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div ng-repeat="parron in parrones" class="col-md-2">
                                                <label for="">Parron @{{ $index }}</label>
                                                <input class="form-control " name="daterange" id="reservation" type="text">
                                                
                                            </div>
                                            <div class="col-md-1">
                                                <br>
                                                <button href="" class="btn btn-success" onclick="imprimir()">
                                                    <i class=""></i> guardar </button>
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

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });
        $('[data-toggle="tooltip"]').tooltip();
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


        var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];

            $scope.totales = {};

            var ruta = '';


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

            };


            






            $scope.getFamilias = function() {

                

                



            };



           
            $scope.getData =  function ()
            {

                var token = $('#_token').val();
                var f_inicio ="";
                var f_fin = "";
                var nivel = $("#nivel").val();

                var fecha_s_format = $('#reservation').val();

                fecha_s_format=fecha_s_format.split("-");

                f_inicio = formatDateToText(fecha_s_format[0]);
                f_fin = formatDateToText(fecha_s_format[1]);

                var ruta = '{{ URL::route('getBalanceByNivelesApi') }}';

                $('#btnBuscarDoc').attr("disabled", true);
                $scope.Documentos = [];
                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                
                $http.post(ruta,{_token : token,
                            f_i:f_inicio,
                            f_f: f_fin,
                            nivel:nivel
                        })
                        .success(function(data){

                            $scope.Documentos = data.items;
                            //console.log(data);

                            $scope.totales.total_SI_DEUDOR = data.total_SI_DEUDOR;
                            $scope.totales.total_SI_ACREEDOR = data.total_SI_ACREEDOR;
                            $scope.totales.total_MOV_DEBE = data.total_MOV_DEBE;
                            $scope.totales.total_MOV_HABER = data.total_MOV_HABER;
                            $scope.totales.total_SF_DEUDOR = data.total_SF_DEUDOR;
                            $scope.totales.total_SF_ACREEDOR = data.total_SF_ACREEDOR;


                            $('#btnBuscarDoc').attr("disabled", false);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                    console.log(data);
                    $("#box_maestro").remove(".overlay");
                    $("#box_maestro").remove(".loading-img");
                });
                
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