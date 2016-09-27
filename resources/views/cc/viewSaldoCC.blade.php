@extends('layoutCC')

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
                            <li class="active"><a data-toggle="tab" href="#home">Centro de Costo</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />

                                            <div class="col-md-4">
                                                <label>Rango de Fechas</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control " name="daterange" id="reservation" type="text">
                                                </div><!-- /.input group -->
                                            </div>
                                            <div class="col-md-1">
                                                <br>
                                                <button href="" class="btn btn-success" onclick="getData()">
                                                    <i class="fa fa-search fa-lg"></i> Buscar
                                                </button>
                                            </div>
                                            <div class="col-md-1">
                                                <br>
                                                <button href="" class="btn btn-default" onclick="imprimir()">
                                                    <i class="fa fa-print fa-lg"></i> Imprimir </button>


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

            <div class="row">
                <div class="col-lg-12">
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">
                            <!-- tools box -->
                        </div><!-- /.box-header -->
                        <div class="box-body ">

                            <!--
                            <label>
                                Any: <input ng-model="search.$">
                            </label> <br> -->

                            <!-- external libs from cdnjs -->
                           <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
                            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

                            <!-- PivotTable.js libs from ../dist -->
                            <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/pivottable/pivot.css')}}">
                            <script type="text/javascript" src="{{ asset('js/plugins/pivottable/pivot.js')}}"></script>
                            <script type="text/javascript" src="{{ asset('js/plugins/pivottable/export_renderers.js')}}"></script>
                            <script type="text/javascript" src="{{ asset('js/plugins/printThis/printThis.js')}}"></script>



                            <div id="output" style="margin: 30px;overflow: auto" ></div>

                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

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


        function getData() {
            var token = $('#_token').val();

            var renderers = $.extend($.pivotUtilities.renderers,
                    $.pivotUtilities.export_renderers);

            var fecha = $('input[name="daterange"]').val();

            fecha = fecha.split('-');
            var f_i = changeFormat(fecha[0]);
            var f_f = changeFormat(fecha[1]);

            $.post("{{ URL::route('getSaldoCCByCuentaAndPeriodo') }}"
                    , { _token: token,
                        f_i: f_i,
                        f_f: f_f
                    })
                    .done( function(mps) {
                        $("#output").pivotUI(mps, {
                            renderers: renderers,
                            cols: ["CENTRO DE COSTO"], rows: ["CUENTA","DESCRIPCION"],
                            rendererName: "Table",
                            aggregatorName: "Sum",
                            vals: ["SALDO"]
                        });
                    });

        }

        function changeFormat(fecha)
        {

            fecha = fecha.split('/');

            fecha = fecha[0]+"-"+fecha[1]+"-"+fecha[2];

            return fecha;

        }

        function ver() {



            $(".pvtTable tbody tr").each(function (index) {

                var tx = '';
                var bandera ;

                console.log("Entro");

                $(this).children("td").each(function (index2)
                {
                    bandera = parseFloat($(this).text());

                    if(bandera<0){
                        $(this).css("background-color", "#ff6666");

                    }

                });



            });




        }

        /**/


        var app = angular.module("app", ['ui.bootstrap']);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];

            var ruta = '';

            //funcioines que inician la pagina



            //traer la data por el click

            $scope.getData = function(){

                var fecha_s_format = $('#reservation').val();
                console.log(fecha_s_format.length);// 0 si es nulo
            };

            $scope.getDataAll = function()
            {

                var token = $('#_token').val();
                var f_inicio ="";
                var f_fin = "";

                var fecha_s_format = $('#reservation').val();

                if(fecha_s_format.length == 0){
                    ruta = '{{ URL::route('getTrabajadoresByParamOutDates') }}';

                }else {

                    fecha_s_format = fecha_s_format.split('-');
                    f_inicio =fecha_s_format[0];
                    f_fin = fecha_s_format[1];
                    f_inicio = changeFormat(f_inicio);
                    f_fin = changeFormat(f_fin);

                    ruta = '{{ URL::route('getAllTrabajadoresByParameter') }}';
                }

                var categoria = $scope.filCategoria;
                var vigencia = $scope.filVigencia;

                if(categoria=='' || categoria == null)
                    categoria ='';
                if(vigencia=='' || vigencia == null)
                    vigencia ='';


                /*--- Procedimiento que se haga mientras no termine  */

                $('#btnBuscarDoc').attr("disabled", true);
                $scope.Documentos = [];
                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");
                /*-----------------*/

                // console.log($scope.TipoDoct);


                $http.post(ruta,
                        {_token : token,
                            f_i:f_inicio,
                            f_f: f_fin,
                            categoria:categoria,
                            vigencia:vigencia
                        })
                        .success(function(data){

                            $scope.Documentos = data;
                            console.log(data);

                            $('#btnBuscarDoc').attr("disabled", false);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                    console.log(data);
                    $("#box_maestro").remove(".overlay");
                    $("#box_maestro").remove(".loading-img");
                });
            };

            $scope.viewDireccion = function (item) {

                $scope.ubigeo = item;

                $('#modUbigeo').modal('show');


            };



            /*funcion helper*/




        });
    </script>


@stop