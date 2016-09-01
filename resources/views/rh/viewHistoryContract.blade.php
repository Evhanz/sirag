@extends('layout')

@section('content')

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">

                            <li class="active"><a data-toggle="tab" href="#personal">Pesonal</a></li>

                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">

                                    <!-- Tab  proveedor -->
                                    <div id="personal" class="tab-pane fade">
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

    <!--PAra exportar a excel-->
    <script src="{{asset('js/plugins/table2excel/jquery.table2excel.js')}}"></script>

    <!--para exportar a PDF -->

        <!-- PAra esto primero se exporta las funciones de table -->
        <script  src="{{asset('js/plugins/tableExport.jquery.plugin/tableExport.js')}}"></script>
        <script  src="{{asset('js/plugins/tableExport.jquery.plugin/jquery.base64.js')}}"></script>
        <!--Luego instalamos los de pdf-->
        <script  src="{{asset('js/plugins/tableExport.jquery.plugin/jspdf/libs/sprintf.js')}}"></script>
        <script  src="{{asset('js/plugins/tableExport.jquery.plugin/jspdf/jspdf.js')}}"></script>
        <script  src="{{asset('js/plugins/tableExport.jquery.plugin/jspdf/libs/base64.js')}}"></script>
    <!-- ./ en expor pdf -->

    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker();
        /*----*/


        var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];


            $scope.familias = [];
            $scope.subfamilias = [];
            $scope.ProductosDTO =[];

            $scope.proveedores = [];
            $scope.prov_active = {};
            $scope.prod_provee = [];



            //funcioines que inician la pagina
            getAllFamilias();
            getAllSubFamilias();

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
                if($scope.subFamilia == null || $scope.subFamilia.length == 0){

                    $scope.subFamilia = '';
                }
                if($("#f_familia").val() == null || $("#f_familia").val().length == 0){

                    $("#f_familia").val('');
                }


                $http.post('{{ URL::route('getAllProductosByProveedor') }}',
                        {   _token : token,
                            glosa: $scope.producto_glosa,
                            subfamilia: $scope.subFamilia,
                            familia:$("#f_familia").val()
                        })
                        .success(function(data){

                            $scope.ProductosDTO = data;

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                            console.log(data);
                            $("#box_maestro").remove(".overlay");
                            $("#box_maestro").remove(".loading-img");
                        });
            };

            //reutilizar esta funcion para insertar los detalles

            $scope.addDetail = function (i,item)
            {

                var token = $('#_token').val();

                var id_detail_row = 'tr_detail_'+i;
                var hidd_v_detail ="hd_v_detail_"+i;

                var bandera = $("#"+hidd_v_detail).val();

                var ruta = '{{ URL::route('getDetailProductoCompra') }}';


                /*si no se a llamado a ese detalle entonces llamar*/
                if(bandera == 0)
                {
                    $http.post(ruta,
                            {   _token : token,
                                glosa: item.GLOSA,
                                proveedor: item.RazonSocial,
                                moneda: item.Moneda
                            })
                            .success(function(data){

                                item.detalle = data;


                            }).error(function (data) {
                                console.log("error en :"+data);
                            });

                    $("#"+hidd_v_detail).val(1);
                    item.v_detail = '1';
                }else{
                    $("#"+id_detail_row).show();
                }

            };

            $scope.removeDetail = function (idDoc)
            {
                var id_detail_row = 'tr_detail_'+idDoc;
                $("#"+id_detail_row).hide();
            };


            $scope.export_all_excel = function()
            {

                //$("ul[data-group='Companies'] li[data-company='Microsoft']");

               $('.tr_details').remove();

                $("#table_data_op1").table2excel({
                    exclude: ".noExl",
                    name: "Libro 1",
                    filename: "rep",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true
                });

                /* esto es para el pugin table2excel urL consula http://www.jqueryscript.net/table/Export-Html-Table-To-Excel-Spreadsheet-using-jQuery-table2excel.html
                $("#table_data_op1").table2excel({
                    exclude: ".noExl",
                    name: "Libro 1",
                    filename: "rep",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true
                });*/

                /*esto es paa el publig ableExport.Jquery.plugin https://github.com/kayalshri/tableExport.jquery.plugin http://w3lessons.info/2015/07/13/export-html-table-to-excel-csv-json-pdf-png-using-jquery/
                $('#table_data_op1').tableExport({
                    type:'excel',
                    escape:'false'
                });
                 */

            };


            $scope.export_all_pdf = function ()
            {


                var familia = $("#f_familia").val();

                // console.log($scope.TipoDoct);
                if($scope.producto_glosa == null || $scope.producto_glosa.length == 0){

                    $scope.producto_glosa = '-';
                }
                if($scope.subFamilia == null || $scope.subFamilia.length == 0){

                    $scope.subFamilia = '-';
                }
                if(familia == null || $("#f_familia").val().length == 0){

                    familia='-';
                }


                window.location = "{{ URL::route('modComercial') }}/pdf/getPDFProductProveedor/"+$scope.producto_glosa+
                "/"+$scope.subFamilia+"/"+familia;




             //
            };


            $scope.export_Detail_excel = function(i){

                $(".cont-temp" ).append("<tr><th>Descripcion Producto</th><th>" +
                        "Proveedor</th><th>Moneda</th><th>Und</th><th>Ult. Precio</th></tr>");
                $( ".cont-temp" ).append( $( "#tr_Doc_"+i ) );

                $( ".cont-temp" ).append( $( "[data-tipo='tbl_dt_"+i+"']") );


                $(".cont-temp").table2excel({
                    exclude: ".noExl",
                    name: "Libro 1",
                    filename: "rep_det",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true
                });

                $( ".cont-temp" ).empty();

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

            function getAllSubFamilias(){

                var ruta = '{{ URL::route('getAllSubFamilias')}}';

                $http.get(ruta)
                        .success(function(data){
                            $scope.subfamilias = data;
                        }).error(function (data) {
                            console.log("error en :"+data);
                        });
            }


            /*funcion helper*/


            //funcion para exportar en excel


            //funciones para los proveedores

            $scope.getProveedor  = function ()
            {

                var token = $('#_token').val();
                var razon = $scope.razon_social;
                var ruc = $scope.fil_ruc;

                if(razon == '' || razon == null)
                {
                    razon  = '';
                }

                if(ruc == '' || ruc == null)
                {
                    ruc  = '';
                }



                $http.post('{{ URL::route('getProveedoresByRazonAndRUC') }}',
                        {   _token : token,
                            razon: razon,
                            ruc:ruc

                        })
                        .success(function(data){

                            $scope.proveedores = data;

                        }).error(function(data) {

                            console.log('error'+data);
                        });

            };


            $scope.getActiveProveedor = function(i)
            {

                $scope.prod_active = $scope.proveedores[i];


                var ruta = '{{ URL::route('modComercial') }}/api/getProductosComercioProveedor/'+$scope.proveedores[i].ruc;

                $http.get(ruta)
                        .success(function(data){
                            $scope.prod_active.productos = data;
                        }).error(function (data) {
                            console.log("error en :"+data);
                        });

            }









        });
    </script>


@stop