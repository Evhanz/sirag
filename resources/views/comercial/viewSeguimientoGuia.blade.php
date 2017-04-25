@extends('layout')

@section('content')

    <!-- Este se transformó en seguimientos de documentos  -->

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Orden Compra</a></li>
                            <li ><a data-toggle="tab" href="#requerimiento">Requerimiento</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding" >
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <form class="form-inline" style="padding: 15px">

                                                <div class="form-group">
                                                    <label for="" >Año</label><br>
                                                    <select name="filAnio" class="form-control" id="filAnio" required>
                                                        <option value="">--------</option>
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" >Mes</label><br>
                                                    <select name="filMes" class="form-control" id="filMes" required>
                                                        <option value="">--------</option>
                                                        <option value="1">Enero</option>
                                                        <option value="2">Febrero</option>
                                                        <option value="3">Marzo</option>
                                                        <option value="4">Abril</option>
                                                        <option value="5">Mayo</option>
                                                        <option value="6">Junio</option>
                                                        <option value="7">Julio</option>
                                                        <option value="8">Agosto</option>
                                                        <option value="9">Septiembre</option>
                                                        <option value="10">Octubre</option>
                                                        <option value="11">Noviembre</option>
                                                        <option value="12">Diciembre</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""></label><br>
                                                    <button class="btn btn-success" id="btnBuscarDoc" ng-click="getDataByDoc()">
                                                        <i class="fa fa-search fa-lg"></i>
                                                    </button>
                                                </div>
                                            </form>


                                            <div class="row" style="padding: 15px" >
                                                <div class="col-lg-12"  >
                                                    <table class="table table-bordered " id="table_data_op1">
                                                        <thead >
                                                        <tr>
                                                            <th>FECHA</th>
                                                            <th>GUIA</th>
                                                            <th>RAZON SOCIAL</th>
                                                            <th>*</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody  ng-repeat=" item in Documentos | filter:search">
                                                        <tr id="tr_Doc_@{{ item.idDocto }}">
                                                            <td>@{{ item.FECHA }}</td>
                                                            <td>@{{ item.GUIA }}</td>
                                                            <td>@{{ item.RAZON_SOCIAL }}</td>
                                                            <td>NO SE ENCUENTRA FACTURA</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div><!-- /.row - inside box -->

                                        </div>

                                    </div>
                                    <!-- Tab filtro documento -->
                                    <div id="requerimiento" class="tab-pane fade">
                                        <form class="form-inline" style="padding: 15px" method="post" action="{{route('getExcelRequerimiento')}}">
                                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

                                            <div class="form-group">
                                                <label>Rango de Fechas</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control " name="rango_requerimiento" id="rango_requerimiento" type="text">
                                                </div><!-- /.input group -->
                                            </div>
                                            <div class="form-group">
                                                <label for="" >Tipo Requerimiento</label><br>
                                                <select name="tipo" class="form-control" id="tipoR" required>
                                                    <option value="ambos">Ambos</option>
                                                    <option value="R/COMPRA (A)">R/COMPRA (A)</option>
                                                    <option value="R/C SERVICIO">R/C SERVICIO</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="" >Vigencia</label><br>
                                                <select name="vigencia" class="form-control" id="vigenciaR" required>
                                                    <option value="">--------</option>
                                                    <option value="S">Vigente</option>
                                                    <option value="N">No Vigente</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="" >Aprobacion</label><br>
                                                <select name="aprobacion" class="form-control" id="vigenciaR" required>
                                                    <option value="">--------</option>
                                                    <option value="S">Aprobado</option>
                                                    <option value="N">No Aprobado</option>
                                                    <option value="P">Pendiente</option>
                                                </select>
                                            </div>

                                            <!--

                                            <div class="form-group">
                                                <label for=""></label><br>
                                                <button name="option" value="excel" class="btn btn-success"  >
                                                    <i class="fa fa-file-excel-o fa-lg"></i>
                                                </button>
                                            </div>
                                            -->



                                            <div class="form-group">
                                                <label for=""></label><br>
                                                <button name="option" value="pdf" class="btn btn-danger"  >
                                                    <i class="fa fa-file-pdf-o fa-lg"></i>
                                                </button>
                                            </div>



                                        </form>


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

        $('input[name="daterange"]').daterangepicker();

        $('#rango_requerimiento').daterangepicker({
            format : "DD/MM/YYYY"
        });
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

                var anio = $('#filAnio').val();
                var mes = $('#filMes').val();


                if( anio.length >0 && mes.length >0 ){

                    if(mes < 10){
                        mes = '0'+mes;
                    }
                    var fecha = anio+'-'+mes;

                    /*--- Procedimiento que se haga mientras no termine  */

                    $('#btnBuscarDoc').attr("disabled", true);

                    $scope.Documentos = [];

                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");


                    $http.post('{{ URL::route('getGuiaFaltaFactura') }}',
                            {   _token : token,
                                fecha   : fecha

                            })
                            .success(function(data){

                                $scope.Documentos = data;
                                console.log( data);
                                $('#btnBuscarDoc').attr("disabled", false);

                                $( "div" ).remove( ".overlay" );
                                $( "div" ).remove( ".loading-img" );


                            }).error(function(data) {
                                console.log(data);
                                alert("Error Revisar");
                                $( "div" ).remove( ".overlay" );
                                $( "div" ).remove( ".loading-img" );
                            });




                }else{

                    alert('Debe ingresar primero una fecha');

                }






            };






            /*funcion helper*/

            function changeFormat(fecha)
            {
                fecha = fecha.split('/');

                fecha = fecha[2]+"-"+fecha[1]+"-"+fecha[0];

                return fecha;

            }







        });
    </script>


@stop