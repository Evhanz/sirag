@extends('layoutRH')

@section('content')

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Documento</a></li>
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
                                                    <label for="" >CATEGORIA</label><br>
                                                    <select name="" class="form-control" ng-model="filCategoria" ng-init="filCategoria='OPERARIO'">
                                                        <option value="">-----</option>
                                                        <option value="OPERARIO">OPERARIO</option>
                                                        <option value="SIN_CONTRATO">SIN_CONTRATO</option>
                                                        <option value="EMPLEADO">EMPLEADO</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" >Vigencia</label><br>
                                                    <select name="" class="form-control" ng-model="filVigencia" ng-init="filVigencia='ACTIVO'">
                                                        <option value="ACTIVO" >si</option>
                                                        <option value="INACTIVO">no</option>
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
                                                    <button class="btn btn-success" id="btnBuscarDoc" ng-click="getDataAll()">
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
                        </div><!-- /.box-header -->
                        <div class="box-body ">

                            <!--
                            <label>
                                Any: <input ng-model="search.$">
                            </label> <br> -->

                            <form class="form-inline" style="padding: 15px">

                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" ng-model="search.NOMBRE">
                                </div>
                                <div class="form-group">
                                    <label for="">DNI</label>
                                    <input type="text" class="form-control" ng-model="search.EMPLEADO">
                                </div>

                                <div class="form-group">
                                    <label for="" >Cargo </label><br>
                                    <input class="form-control" ng-model="search.CARGO">

                                </div>



                                <div class="form-group">

                                    <!--
                                    <label for="">Exportar</label><br>
                                    <a href="" class="btn btn-success btn-xs" ng-click="export_all_excel()" title="Reporte Totalizado Excel">
                                        <i class="fa fa-file-excel-o fa-lg"></i></a>
                                    <a href="" ng-click="export_all_pdf()"
                                       class="btn btn-default btn-xs"  title="Reporte Totalizado PDF">
                                        <i class="fa fa-file-pdf-o fa-lg" ></i>
                                    </a>
                                    -->
                                </div>
                            </form>

                            <div class="row" style="padding: 15px">
                                <div class="table-responsive" style="overflow: auto">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>CODIGO</th>
                                            <th>DNI</th>
                                            <th>Nombre</th>
                                            <th>Sexo</th>
                                            <th>F. Nac.</th>
                                            <th>Fecha Ini</th>
                                            <th>Fecha Fin</th>
                                            <th>Cargo</th>
                                            <th>Remuneración</th>
                                            <th>T_Contrato</th>
                                            <th>C. Costo</th>
                                            <th>CTA_CENTRA</th>
                                            <th>AFP/ONP</th>
                                            <th>T. COMI AFP</th>
                                            <th>FINIQUITO</th>
                                            <th>V</th>
                                            <th>Dirección</th>
                                            <th>*</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        <tr  ng-repeat=" item in Documentos | filter:search" id="tr_Doc_@{{ item.FICHA }}">
                                            <th>@{{ item.FICHA }}</th>
                                            <td>@{{ item.EMPLEADO }}</td>
                                            <td>@{{ item.NOMBRE }}</td>
                                            <td>@{{ item.SEXO | limitTo:1 }}</td>
                                            <td>@{{ item.FECHA_NACIMIENTO }}</td>
                                            <td>@{{ item.FECHA_INICIO }}</td>
                                            <td>@{{ item.FECHA_TERMINO }}</td>
                                            <td>@{{ item.CARGO }}</td>
                                            <td>@{{ item.REMUNERACION }} </td>
                                            <td>@{{ item.TIPO_CONTRATO }} </td>
                                            <td>@{{ item.CENTRO_COSTO }}</td>
                                            <td>@{{ item.CTA_CENTRA }}</td>
                                            <td>@{{ item.AFP_ONP }}</td>
                                            <td>@{{ item.TIPO_COMI_AFP }}</td>
                                            <td>@{{ item.MOTIVO_SALIDA }}</td>
                                            <td> <div class="animate-switch-container"
                                                      ng-switch on="item.VIGENCIA">
                                                    <div  ng-switch-when="A">
                                                        <label  class="label label-success">
                                                            <i class="fa fa-check-circle" ></i>
                                                        </label>
                                                    </div>
                                                    <div  ng-switch-when="I">
                                                        <label class="label label-danger">
                                                            <i class="fa fa-exclamation-triangle" ></i>
                                                        </label>
                                                    </div>

                                                </div></td>
                                            <td>
                                                <a class="btn btn-default" ng-click="viewDireccion(item)">
                                                    <i class="fa fa-map-marker fa-lg" ></i>
                                                </a>

                                            </td>
                                            <td>
                                                <a class="btn btn-default" ng-click="addDetail(item.idDocto,item)">
                                                    <i class="fa fa-eye fa-lg"></i>
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

            </div>

        </div>



        <!-- modal modUbigeo-->
        <div class="modal fade" id="modUbigeo" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    </div>
                    <div class="modal-body">

                        <h3>Dirección</h3>
                        <p>@{{ ubigeo.DIRECCION }}</p>
                        <h3>Ubigeo</h3>
                        <p>@{{ ubigeo.PAIS }} - @{{ ubigeo.DEPARTAMENTO }} - @{{ ubigeo.PROVINCIA }} -@{{ ubigeo.DISTRITO }}</p>

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

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });
        $('[data-toggle="tooltip"]').tooltip();
        /*
        $(document).ready(function(){

        });*/

        /*----*/


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

            function changeFormat(fecha)
            {
                //original dd/mm/yyyy en funcion yy/dd/mm

                fecha = fecha.split('/');

                fecha = fecha[2]+"-"+fecha[0]+"-"+fecha[1];

                return fecha;

            }


        });
    </script>


@stop