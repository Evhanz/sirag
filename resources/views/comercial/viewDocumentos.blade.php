@extends('layout')

@section('content')

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Documento</a></li>
                            <li><a data-toggle="tab" href="#menu1">Producto</a></li>
                            <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
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
                                                    <label for="">Sistema</label>
                                                    <input type="text" class="form-control" ng-model="searchText.Sistema">
                                                </div>
                                                <div class="form-group">
                                                    <label for="" >T. Comprobante</label><br>
                                                    <select class="form-control" ng-model="TipoDoct">
                                                        <option ng-repeat="tipo in tipodocts | filter:searchText"
                                                                value="@{{tipo.TipoDocto}}">
                                                            @{{tipo.TipoDocto}}
                                                        </option>
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
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button class="btn btn-danger btn-sm refresh-btn" data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>
                                <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                            <i class="fa fa-cloud"></i>

                            <h3 class="box-title">Data </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body ">


                            <label>
                                Any: <input ng-model="search.$">
                            </label> <br>

                            <div class="row" style="padding: 15px">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>ID</th>
                                            <th>#</th>
                                            <th>EMPRESA</th>
                                            <th>Fecha</th>
                                            <th>TOTAL</th>
                                            <th>*</th>
                                        </tr>
                                        </thead>
                                        <tbody  ng-repeat=" item in Documentos | filter:search">
                                        <tr id="tr_Doc_@{{ item.idDocto }}">
                                            <td>@{{ item.idDocto }}</td>
                                            <td>@{{ item.NC }}</td>
                                            <td>@{{ item.EMPRESA }}</td>
                                            <td>@{{ item.FECHA }}</td>
                                            <td>@{{ item.TOTAL }}</td>
                                            <td>
                                                <a class="" ng-click="addDetail(item.idDocto,item)">
                                                    <i class="fa fa-plus fa-lg"></i>
                                                    <input id="hd_v_detail_@{{ item.idDocto }}" type="hidden" value="0" ng-model="item.v_detail">
                                                </a>

                                                <a ng-click="removeDetail(item.idDocto)">
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
                                                       <td>Fam.</td>
                                                       <td>Tipo.</td>
                                                       <td>Cant.</td>
                                                       <td>Cost.</td>
                                                       <td>Fundo</td>
                                                       <td>Parron</td>
                                                   </tr>

                                                   </thead>
                                                   <tbody>
                                                   <tr ng-repeat=" val in item.detalle ">
                                                       <td>@{{ $index }}</td>
                                                       <td>@{{ val.NOMBRE }}</td>
                                                       <td>@{{ val.UNIDAD }}</td>
                                                       <td>@{{ val.FAMILIA }}</td>
                                                       <td>@{{ val.TIPO }}</td>
                                                       <td>@{{ val.CANTIDAD }}</td>
                                                       <td>@{{ val.COSTO | number:2 }}</td>
                                                       <td>@{{ val.FUNDO }}</td>
                                                       <td>@{{ val.PARRON }}</td>
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

        </div>
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




            //funcioines que inician la pagina
            getAllTiposDoc();



            //traer la data por el click

            $scope.getDataByDoc = function()
            {

                var token = $('#_token').val();

                var fecha_s_format = $('#reservation').val();
                fecha_s_format = fecha_s_format.split('-');


                var f_inicio =fecha_s_format[0];
                var f_fin = fecha_s_format[1];


                /*--- Procedimiento que se haga mientras no termine  */

                $('#btnBuscarDoc').attr("disabled", true);

                $scope.Documentos = [];

                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");



                /*-----------------*/

               // console.log($scope.TipoDoct);


                $http.post('{{ URL::route('api_getDocsByParameters') }}',
                        {_token : token,
                        f_inicio:f_inicio,
                        f_fin: f_fin,
                        tipoDoct:$scope.TipoDoct})
                        .success(function(data){

                            $scope.Documentos = data;
                            console.log( data);
                            $('#btnBuscarDoc').attr("disabled", false);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                            console.log(data);
                            $("#box_maestro").remove(".overlay");
                            $("#box_maestro").remove(".loading-img");
                        });



            };


            $scope.addDetail = function (idDoc,Doc)
            {

                var id_detail_row = 'tr_detail_'+idDoc;
                var hidd_v_detail ="hd_v_detail_"+idDoc;

                var bandera = $("#"+hidd_v_detail).val();

                var ruta = '{{ URL::route('modComercial') }}/api/getDetalByIdDoc/'+idDoc;

                /*si no se a llamado a ese detalle entonces llamar*/
                if(bandera == 0)
                {

                    $http.get(ruta)
                            .success(function(data){

                                Doc.detalle = data;

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



            /*funcion helper*/







        });
    </script>


@stop