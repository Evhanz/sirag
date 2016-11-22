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
                            <li class="active"><a data-toggle="tab" href="#salidas">Salidas</a></li>
                            <li ><a data-toggle="tab" href="#entradas">Entradas</a></li>

                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <!-- Tab filtro producto -->
                                    <div id="salidas" class="tab-pane fade in active">
                                        <!--Filtro Principal de productos-->
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <form class="form-inline" style="padding: 15px">

                                                <div class="col-xs-3">
                                                    <label>Rango de Fechas</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control " name="daterange" id="reservation" type="text">
                                                    </div><!-- /.input group -->
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="" >Familia </label><br>
                                                    <select class="form-control" ng-model="familiaFilter" id="f_familia" ng-init="familiaFilter='MATERIA PRIMA'">
                                                        <option value="">---------</option>
                                                        <option ng-repeat="familia in familias "
                                                                value="@{{familia.CODIGO}}">
                                                            @{{familia.CODIGO}}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="">Producto</label>
                                                    <input class="form-control" type="text" ng-keyup="$event.keyCode == 13 && getProduct()" ng-model="producto_glosa">
                                                </div>

                                                

                                                <div class="col-xs-2">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a href="" class="btn btn-info" ng-click="getProduct()">
                                                        Buscar <i class="fa fa-search"></i>
                                                    </a>

                                                </div>

                                            </form>
                                        </div>
                                        <br><br>
                                        <!--./ Filro Principal-->
                                        <!-- data procesada  -->
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <!-- Box (with bar chart) -->
                                                <div class="box box-info" id="box_maestro">
                                                    <div class="box-header">

                                                        <div class="row">

                                                            <div class="col-xs-1  col-md-offset-11">
                                                                <button class="btn btn-success btn-xs" title="Exportar Excel" onclick="printPrincipal()">
                                                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row" style="padding: 15px">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover" id="table_data_op1">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>i</th>
                                                                        <th>GLOSA</th>
                                                                        <th>CANTIDAD</th>
                                                                        <th>UNIDAD</th>
                                                                        <th>*</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody  ng-repeat=" item in ProductosDTO | filter:search">
                                                                    <tr id="tr_Doc_@{{ $index }}">
                                                                        <td>@{{ $index }}</td>
                                                                        <td>@{{ item.producto_name }}</td>
                                                                        <td>@{{ item.cantidad_total }}</td>
                                                                        <td>@{{ item.unidad }}</td>
                                                                        <td>
                                                                            <a class="btn btn-default" ng-click="viewDetalle(item)">
                                                                                <i class="fa fa-bullseye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.row - inside box -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->

                                            </div>

                                            <div class="col-lg-5">

                                             <!-- Box (with bar chart) -->
                                                <div class="box box-info" id="box_maestro">
                                                    <div class="box-header">
                                                     <div class="row">

                                                            <div class="col-xs-2  col-md-offset-10">
                                                                <button class="btn btn-success btn-xs" title="Exportar Excel" onclick="printSecundario()" style="margin-left: 15px;">
                                                                    <i class="fa fa-file-excel-o" ></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row" style="padding: 15px">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="table_data_op2">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>*</th>
                                                                        <th>Fecha</th>
                                                                        <th>Producto</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Unidad</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody  ng-repeat=" item in detalles | filter:search">
                                                                    <tr >
                                                                        <td>@{{ $index }}</td>
                                                                        <td>@{{ item.fecha   }}</td>
                                                                        <td>@{{ item.glosa }}</td>
                                                                        <td>@{{ item.cantidad }}</td>
                                                                        <td>@{{ item.unidad }}</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.row - inside box -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                            


                                                
                                            </div><!--detalle de la data -->


                                        </div>

                                            

                                        <!-- ./data procesada  -->
                                    </div>
                                    <!-- Tab filtro proveedor -->
                                    <div id="entradas" class="tab-pane fade">
                                        <!--Filtro Principal opcion proveedor-->
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />

                                            <!--filtro de cabecera-->
                                            <div class="col-lg-5">
                                                <form class="form-inline" style="padding: 15px">
                                                    <div class="form-group">
                                                        <label for="">Razon Social</label>
                                                        <input class="form-control" type="text" ng-keyup="$event.keyCode == 13 && getProveedor()"
                                                               ng-model="razon_social">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">RUC</label>
                                                        <input class="form-control" ng-keyup="$event.keyCode == 13 && getProveedor()" type="number"  ng-model="fil_ruc">
                                                    </div>
                                                </form>
                                            </div>

                                            <!--Datos Pronósticos-->
                                            <div class="col-lg-7">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" data-tipo="process_1" id="table_data_op1">
                                                        <thead >
                                                        <tr>
                                                            <th>Razón Social</th>
                                                            <th>RUC</th>
                                                            <th>Email</th>
                                                            <th>Telefono</th>
                                                            <th>*</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat=" item in proveedores | filter:fil_ruc" id="tr_Doc_@{{ $index }}">
                                                            <td>@{{ item.razon }}</td>
                                                            <td>@{{ item.ruc }}</td>
                                                            <td>@{{ item.Email | limitTo:30 }}</td>
                                                            <td>@{{ item.Telefono }}</td>
                                                            <td>

                                                                <a href="" class="btn btn-default btn-xs" ng-click="getActiveProveedor($index)">
                                                                    <i class="fa fa-eye fa-lg"></i>
                                                                </a>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        <!--./ Filro Principal-->

                                        <hr>

                                        <!-- data procesada  opcion proveedor-->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <!-- Box  detalle-->
                                                <div class="box box-primary" id="box_maestro">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Datos del Proveedor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form action="">
                                                                    <div class="col-md-8">
                                                                        <label for=""> Razon</label>
                                                                        <input ng-model="prod_active.razon" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for=""> Ruc</label>
                                                                        <input ng-model="prod_active.ruc" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for=""> Direccion</label>
                                                                        <input ng-model="prod_active.Direccion" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <label for=""> Email</label>
                                                                        <input ng-model="prod_active.Email" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label for=""> Telefono</label>
                                                                        <input ng-model="prod_active.Telefono" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for=""> Contacto</label>
                                                                        <input ng-model="prod_active.Contacto" class="form-control" type="text" readonly>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="">Pais</label>
                                                                        <input ng-model="prod_active.Pais" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label for="">Departamento</label>
                                                                        <input ng-model="prod_active.departamento" class="form-control" type="text" readonly>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label for="">Distrito</label>
                                                                        <input ng-model="prod_active.distrito" class="form-control" type="text" readonly >
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label for="">Provincia</label>
                                                                        <input ng-model="prod_active.provincia" class="form-control" type="text" readonly>

                                                                    </div>

                                                                </form>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <h5>Otros</h5>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <table class="table table-bordered">
                                                                    
                                                                    <tr>
                                                                        <td>Direccion</td>
                                                                        <td>Telefono</td>
                                                                        <td>Email</td>
                                                                        <td>Locat.</td>
                                                                    </tr>

                                                                    <tr ng-repeat="item in prod_active.sucursales">
                                                                        <td>@{{ item.Direccion }}</td>
                                                                        <td>@{{ item.Telefono }}</td>
                                                                        <td>@{{ item.email }}</td>
                                                                        <td>@{{ item.Pais | limitTo:3 }}-
                                                                            @{{ item.Estado | limitTo:3 }}-
                                                                            @{{ item.Ciudad | limitTo:3 }}-
                                                                            @{{ item.Comuna | limitTo:3 }}
                                                                        </td>

                                                                    </tr>

                                                                </table>
                                                            </div>


                                                        </div>
                                                        <!-- /.row - inside box -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->

                                            </div>

                                            <div class="col-lg-6">
                                                <!-- Box (with bar chart) -->
                                                <div class="box box-warning" id="box_maestro">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Producto</h3>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="">Filtro</label>
                                                                <input ng-model="fil_glosa" type="text" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="ui table" id="">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>I</th>
                                                                        <th>Glosa</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr ng-repeat="item in prod_active.productos | filter:fil_glosa">
                                                                        <td>@{{ $index }}</td>
                                                                        <td>@{{ item.GLOSA }}</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.row - inside box -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                                            </div>
                                        </div>
                                        <!-- ./data procesada  -->
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




        </div>
    </div>

    <div class="cont-temp"></div>


    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });
        /*----*/



        function printSecundario() {
            
            $("#table_data_op2").table2excel({
                exclude: ".noExl",
                name: "tabla_detalle",
                filename: "tabla_detalle",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

        }

        function printPrincipal() {
            // body...

             $("#table_data_op1").table2excel({
                exclude: ".noExl",
                name: "tabla_general",
                filename: "tabla_general",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        }



        function print_excel() {
                    

            
                  
        }


        var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.detalles     =   [];
            $scope.familias     =   [];
            $scope.ProductosDTO =   [];

            $scope.proveedores  =   [];
            $scope.prov_active  =   {};
            $scope.prod_provee  =   [];



            //funcioines que inician la pagina
            getAllFamilias();
           

            //traer la data por el click

            $scope.getProduct = function () {
                var token = $('#_token').val();

                /*--- Procedimiento que se haga mientras no termine  */




                $scope.search = {};
                $scope.ProductosDTO = [];

                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                /*-----------------*/

                // console.log($scope.TipoDoct);
                if($scope.producto_glosa == null || $scope.producto_glosa.length == 0){

                    $scope.producto_glosa = '';
                }
                if($scope.familiaFilter == null || $scope.familiaFilter.length == 0){

                    $scope.familiaFilter = '';
                }


                if ( $("#reservation").val().length > 0 ) {



                    var fecha_s_format = $("#reservation").val().split('-');


                    var f_i = formatDateDMYtoMDY(fecha_s_format[0]);
                    var f_f = formatDateDMYtoMDY(fecha_s_format[1]);

                    var ruta = '{{ URL::route('api_getKardexSalida') }}';

                     $http.post(ruta,
                        {   _token : token,
                            producto: $scope.producto_glosa,
                            f_i: f_i,
                            f_f: f_f,
                            familia:$scope.familiaFilter

                        })
                        .success(function(data){

                            $scope.ProductosDTO = data;

                            //console.log(data);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                            console.log(data);
                            alert("Error _>");
                            $("div").remove(".overlay");
                            $("div").remove(".loading-img");
                        });


                } else {



                    alert("El campo de fecha es obligatorio");
                }


            };

            //reutilizar esta funcion para insertar los detalles

            $scope.viewDetalle = function (item)
            {

                angular.forEach(item.detalle,function (val) {

                    val.fecha = val.fecha.split(" ");
                    val.fecha = formatDateYMDtoDMY(val.fecha[0],'-');

                });


                $scope.detalles = item.detalle;


            };

       
            function getAllFamilias(){

                var ruta = '{{ URL::route('modComercial') }}/api/getAllFamilias';

                $http.get(ruta)
                        .success(function(data){
                            $scope.familias = data;
                        }).error(function (data) {
                            console.log("error en :"+data);
                        });
            }


            /*funcion helper*/


            function formatDateDMYtoMDY(fecha) {

                fecha = fecha.split('/');

                fecha = fecha[1]+"-"+fecha[0]+"-"+fecha[2];

                return fecha;

            }

            function formatDateYMDtoDMY(fecha,separador) {

                fecha = fecha.split(separador);

                fecha = fecha[2]+"-"+fecha[1]+"-"+fecha[0];

                return fecha;

            }




            //funcion para exportar en excel










        });
    </script>


@stop