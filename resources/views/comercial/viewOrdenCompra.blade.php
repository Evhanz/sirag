@extends('layout')

@section('content')

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
                                                    <label for="">Proveedor</label>
                                                    <input type="text" class="form-control" ng-model="filProveedor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">N° Orden</label>
                                                    <input type="text" class="form-control" ng-model="filNOrden">
                                                </div>

                                                <div class="form-group">
                                                    <label for="">Vigencia</label><br>
                                                    <select class="form-control" name="" id="" ng-model="filVigencia">
                                                        <option value="">----------</option>
                                                        <option value="S">Si</option>
                                                        <option value="N">No</option>
                                                    </select>
                                                </div>

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
                                                    <label for=""></label><br>
                                                    <button class="btn btn-success" id="btnBuscarDoc" ng-click="getDataByDoc()">
                                                        <i class="fa fa-search fa-lg"></i>
                                                    </button>
                                                </div>
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
                                            <th>ID</th>
                                            <th>#</th>
                                            <th>Proveedor</th>
                                            <th>Fecha</th>
                                            <th>*</th>
                                        </tr>
                                        </thead>
                                        <tbody  ng-repeat=" item in Documentos | filter:search">
                                        <tr id="tr_Doc_@{{ item.idDocto }}">
                                            <td>@{{ item.idDocto }}</td>
                                            <td>@{{ item.Numero }}</td>
                                            <td>@{{ item.EMPRESA }}</td>
                                            <td>@{{ item.FechaF }}</td>
                                            <td>
                                                <a class="" style="cursor: pointer" ng-click="addDetail(item.idDocto,item)">
                                                    <i class="fa fa-plus fa-lg"></i>
                                                    <input id="hd_v_detail_@{{ item.idDocto }}" type="hidden" value="0" ng-model="item.v_detail">
                                                </a>

                                                <a ng-click="removeDetail(item.idDocto)" style="cursor: pointer">
                                                    <i class="fa fa-chevron-circle-up fa-lg"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        <tr id="tr_detail_@{{ item.idDocto }}"  ng-show="item.v_detail=='1'">
                                           <td colspan="5">
                                               <table class="table table-bordered">
                                                   <thead>
                                                   <tr>
                                                       <td>I</td>
                                                       <td>Nombre</td>
                                                       <td>UND</td>
                                                       <td>Cant.</td>
                                                       <td>Cant. Atendida</td>
                                                       <td>Estado</td>
                                                       <th>*</th>
                                                   </tr>

                                                   </thead>
                                                   <tbody>
                                                   <tr ng-repeat=" val in item.detalle ">
                                                       <td>@{{ $index }}</td>
                                                       <td>@{{ val.GLOSA }}</td>
                                                       <td>@{{ val.UnidadIngreso }}</td>
                                                       <td>@{{ val.Cantidad }}</td>
                                                       <td>@{{ val.cant_atendida }}</td>
                                                       <td>

                                                           <div class="animate-switch-container"
                                                                ng-switch on="val.estado">
                                                               <div  ng-switch-when="atendido">
                                                                   <label  class="label label-success">
                                                                       <i class="fa fa-check-circle" ></i>
                                                                   </label>
                                                               </div>
                                                               <div  ng-switch-when="falta">
                                                                   <label  class="label label-warning">
                                                                       <i class="fa fa-clock-o" ></i>
                                                                   </label>
                                                               </div>
                                                               <div  ng-switch-when="natendido">
                                                                   <label class="label label-danger">
                                                                       <i class="fa fa-exclamation-triangle" ></i>
                                                                   </label>
                                                               </div>

                                                           </div>


                                                       </td>
                                                       <td>
                                                           <a href="" class="btn btn-default" ng-click="viewGuia(val.guia)">
                                                               <i class="fa fa-eye fa-lg"></i>
                                                           </a>
                                                       </td>
                                                   </tr>

                                                   </tbody>

                                               </table>
                                           </td>

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

        <!-- modal Detail-->
        <div class="modal fade" id="modDetailGuia" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Guias</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-condensed">

                            <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Cantidad</th>
                                <th>Fecha de Entrega</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="item in detailGuia">
                                <td>@{{ item.Numero  }}</td>
                                <td>@{{ item.Cantidad }}</td>
                                <td>@{{ item.Fecha }}</td>

                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!--./ modal Detail-->


    </div>


    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/angular/angular-ui-bootstrap-0.3.0.min.js') }}"></script>
    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker();
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
                var proveedor = $scope.filProveedor;
                var numero = $scope.filNOrden;
                var vigencia = $scope.filVigencia;



                if( fecha_s_format.length >0){
                    fecha_s_format = fecha_s_format.split('-');
                    var f_inicio =fecha_s_format[0];
                    f_inicio = changeFormat(f_inicio);

                    var f_fin = fecha_s_format[1];
                    f_fin = changeFormat(f_fin);



                    if(proveedor == null )
                        proveedor = '';
                    if(numero == null)
                        numero = '';
                    if(vigencia == null)
                        vigencia = '';
                    if(f_fin==null)
                        f_fin ='';

                    /*--- Procedimiento que se haga mientras no termine  */

                    $('#btnBuscarDoc').attr("disabled", true);

                    $scope.Documentos = [];

                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                    /*-----------------*/

                    // console.log($scope.TipoDoct);




                    $http.post('{{ URL::route('getOrdenesCompra') }}',
                            {   _token : token,
                                f_inicio:f_inicio,
                                f_fin: f_fin,
                                proveedor:proveedor,
                                numero:numero,
                                vigencia:vigencia

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


            $scope.addDetail = function (idDoc,Doc)
            {

                var id_detail_row = 'tr_detail_'+idDoc;
                var hidd_v_detail ="hd_v_detail_"+idDoc;

                var bandera = $("#"+hidd_v_detail).val();

                var ruta = '{{ URL::route('modComercial') }}/api/getDetailOrden/'+idDoc;



                /*si no se a llamado a ese detalle entonces llamar*/
                if(bandera == 0)
                {

                    $http.get(ruta)
                            .success(function(data){

                                Doc.detalle = data;
                                console.log(data);

                            }).error(function (data) {
                                console.log("error en :"+data);
                            });

                    $("#"+hidd_v_detail).val(1);
                    Doc.v_detail = '1';
                }else{
                    $("#"+id_detail_row).show();
                }


            };

            $scope.removeDetail = function (idDoc)
            {

                var id_detail_row = 'tr_detail_'+idDoc;
                $("#"+id_detail_row).hide();
            };


            function getAll(){

                var ruta = '{{ URL::route('modComercial') }}/api/getAllTipoDocumentos';

                $http.get(ruta)
                        .success(function(data){

                            $scope.tipodocts = data;


                        }).error(function (data) {
                            console.log("error en :"+data);
                        });

            }

            $scope.viewGuia = function (guia) {

                $scope.detailGuia = [];

                $scope.detailGuia = guia;

                $('#modDetailGuia').modal('show');

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