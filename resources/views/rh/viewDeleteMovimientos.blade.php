@extends('layout')

@section('content')

	<script type="text/javascript" src="{{ asset('js/plugins/table2excel/jquery.table2excel.min.js') }} "></script>	

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Orden Compra</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <form class="form-inline" style="padding: 15px">

                                                <div class="form-group">
                                                    <label>Rango de Fechas</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control " name="daterange" id="reservation" type="text">
                                                    </div><!-- /.input group -->
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Movimiento</label>
                                                    <input type="text" class="form-control" ng-model="filMovimiento">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Ficha</label>
                                                    <input type="text" class="form-control" ng-model="filFicha">
                                                </div>



                                                <div class="form-group">
                                                    <label for=""></label><br>
                                                    <button class="btn btn-success" id="btnBuscarDoc" ng-click="getDataByDoc()">
                                                        <i class="fa fa-search fa-lg"></i>
                                                    </button>
                                                </div>

                                                <div class="form-group">
                                                    <label for="">&nbsp;</label><br>
                                                   
                                                </div>
                                                 <div class="form-group">
                                                    <label for="">&nbsp;</label><br>
                                                   
                                                </div>

                                                <!--
												<div class="form-group">
				                                    <label for="">Exportar</label><br>
				                                    <a href="#" class="btn btn-success btn-sm" onClick ="print_excel()" title="Reporte Totalizado Excel">
				                                        <i class="fa fa-file-excel-o fa-lg"></i></a>
				                                </div>
				                                -->

                                            </form>

                                        </div>

                                    </div>
                                    <!-- Tab filtro documento -->
                                    <div id="menu1" class="tab-pane fade">
                                        <h3>Menu 1</h3>
                                        <p>Some content in menu 1.</p>

                                        <label>Date range:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input class="form-control " name="daterange" id="reservation" type="text">
                                        </div><!-- /.input group -->


                                    </div>
                                    <div id="menu2" class="tab-pane fade">
                                        <h3>Menu 2</h3>
                                        <p>Some content in menu 2.</p>
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
            <div class="row">
                <div class="col-lg-12">
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">

                        </div><!-- /.box-header -->
                        <div class="box-body ">


                            <label>
                              <!--  Any: <input ng-model="search.$">-->
                            </label> <br>

                            <div class="row" style="padding: 15px">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>*</th>
                                            <th>FICHA</th>
                                            <th>PERIODO</th>
                                            <th>MOVIMIENTO</th>
                                            <th>DESCRIPCION</th>
                                            <th>MONTO</th>

                                        </tr>
                                        </thead>
                                        <tbody  ng-repeat=" item in Documentos | filter:search">
                                        <tr id="tr_Doc_@{{ item.idDocto }}">
                                            <td>

                                                <a href="" class="btn btn-danger" ng-show="item.ATENDIDO!=0" ng-click="viewGuia(item)" >
                                                    <i class="fa fa-stop-circle-o fa-lg"></i>
                                                </a>

                                            </td>
                                            <td>@{{ item.FICHA }}</td>
                                            <td>@{{ item.PERIODO }}</td>
                                            <td>@{{ item.MOVIMIENTO }}</td>
                                            <td>@{{ item.DESCRIPCION}}</td>
                                            <td>@{{ item.MONTO | number:2 }}</td>


                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div><!-- /.row - inside box -->
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->

                </div>

            </div>
        </div><!--/. content-->




    </div>


    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/angular/angular-ui-bootstrap-0.3.0.min.js') }}"></script>
    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });


        function print_excel() {
                    

            $("#table_data_op1").table2excel({
                exclude: ".noExl",
                name: "export_personal",
                filename: "export_personal",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
                  
        }
        
        /*----*/


        var app = angular.module("app", ['ui.bootstrap']);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];
            $scope.detailGuia = [];


            //traer la data por el click

            $scope.getDataByDoc = function()
            {

                var token = $('#_token').val();

                var fecha_s_format = $('#reservation').val();
                var movimiento = $scope.filMovimiento;
                var ficha = $scope.filFicha;




                if( fecha_s_format.length >0){
                    fecha_s_format = fecha_s_format.split('-');
                    var f_inicio =fecha_s_format[0];
                    f_inicio = changeFormat(f_inicio);

                    var f_fin = fecha_s_format[1];
                    f_fin = changeFormat(f_fin);



                    if(movimiento == null )
                        movimiento = '';
                    if(ficha == null)
                        ficha = '';
                    if(f_fin==null)
                        f_fin ='';

                    /*--- Procedimiento que se haga mientras no termine  */

                    $('#btnBuscarDoc').attr("disabled", true);

                    $scope.Documentos = [];

                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                    /*-----------------*/

                    // console.log($scope.TipoDoct);


                    $http.post('{{ URL::route('getMovimientosByFichaAndPeriodo') }}',
                            {   _token : token,
                                f_inicio:f_inicio,
                                f_fin: f_fin,
                                movimiento:movimiento,
                                ficha:ficha

                            })
                            .success(function(data){

                                $scope.Documentos = data;
                                //console.log( data);
                                $('#btnBuscarDoc').attr("disabled", false);

                                $( "div" ).remove( ".overlay" );
                                $( "div" ).remove( ".loading-img" );


                            }).error(function(data) {
                                console.log(data);
                                $("div").remove(".overlay");
                                $("div").remove(".loading-img");
                                alert('Error: :>');
                            });
                }else{

                    alert('Debe ingresar primero una fecha');
                }
            };






            /*funcion helper*/

            function changeFormat(fecha)
            {
                fecha = fecha.split('/');

                fecha = fecha[2].trim()+"-"+fecha[1].trim()+"-"+fecha[0].trim();

                return fecha;

            }







        });
    </script>


@stop