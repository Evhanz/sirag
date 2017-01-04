@extends('layout')

@section('content')

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/fileDownloader/jquery.fileDownload.js') }}"></script>

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">PLAME</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>PLAME REM</h4>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <div class="col-md-2">
                                                <label for="">Año</label><br>
                                                <select name="" id="anio" class="form-control">
                                                    <option value="">----------</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Mes</label><br>
                                                <select name="" id="mes" class="form-control">
                                                    <option value="">----------</option>
                                                    <option value="01">Enero</option>
                                                    <option value="02">Febrero</option>
                                                    <option value="03">Marzo</option>
                                                    <option value="04">Abril</option>
                                                    <option value="05">Mayo</option>
                                                    <option value="06">Junio</option>
                                                    <option value="07">Julio</option>
                                                    <option value="08">Agosto</option>
                                                    <option value="09">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <br>
                                                <button href="" class="btn btn-default" ng-click="getData()" id="btnExportar" >
                                                    <i class="fa fa-print fa-lg"></i> Exportar TXT </button>
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


        <span id="dnw"> </span>
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



           
            $scope.getData =  function ()
            {

                var token = $('#_token').val();
                var anio  = $('#anio').val();
                var mes  = $('#mes').val();

                var periodo = anio+''+mes;


               if (periodo.length == 6 ) {

                   var ruta = '{{ URL::route('getPlameRem') }}';

                    $('#btnExportar').attr("disabled", true);
                    $scope.Documentos = [];
                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                
                $http.post(ruta,{_token : token,
                            periodo:periodo
                        })
                        .success(function(data){
                            $('#btnExportar').attr("disabled", false);
                           //console.log(data);
                            var url = data;
                            window.location = url;

                        }).error(function(data) {
                            $('#btnExportar').attr("disabled", false);
                            console.log(data);
                            $("#box_maestro").remove(".overlay");
                            $("#box_maestro").remove(".loading-img");
                        });

               } else {

                    alert("Se tiene que ingresar , Año y mes");

               }      
            };





        });
    </script>


@stop