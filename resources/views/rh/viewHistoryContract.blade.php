@extends('layoutRH')

@section('content')

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Personal</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px; padding-right: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <div class="col-lg-5">
                                                <label for="">Nombre</label>
                                                <input type="text" class="form-control" ng-model="personal.NOMBRE" disabled>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="">DNI</label>
                                                <input type="text" class="form-control" ng-model="personal.EMPLEADO" disabled>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="">Inicio Contrato</label>
                                                <input type="text" class="form-control" ng-model="personal.FECHA_INICIO" disabled>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="">Fin Contrato</label>
                                                <input type="text" class="form-control" ng-model="personal.FECHA_TERMINO" disabled>
                                            </div>
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
                <div class="col-lg-6" >
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">
                            <h4>Renovación de Contratos</h4>
                        </div><!-- /.box-header -->
                        <div class="box-body ">
                            <div class="row">
                                <div class="col-lg-4">
                                    <button class="btn btn-warning" title="nueva renovacion" ng-click="AddContract()">
                                        <i class="fa fa-plus-square fa-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="row" style="padding: 15px">
                                <div class="table-responsive"  style=" height: 190px; overflow: auto; ">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Estado</th>
                                            <th>*</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        <tr ng-repeat=" item in renovaciones | filter:search" id="tr_contrato_@{{ item.id }}">
                                            <td>@{{ item.id }}</td>
                                            <td>@{{ item.fecha_inicio }}</td>
                                            <td>@{{ item.fecha_fin }}</td>
                                            <td>@{{ item.estado }}</td>
                                            <td>
                                                <a class="btn btn-danger" ng-click="eliminarContrato(item.id);">
                                                    <i class="fa fa-times-circle-o fa-lg"></i>
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
                <div class="col-lg-6" >
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header">
                            <h4>Contratos Asignados (FlexLine)</h4>
                        </div><!-- /.box-header -->
                        <div class="box-body ">
                            <div class="row" style="padding: 15px" >
                                <div class="table-responsive"  style=" height: 190px; overflow: auto; ">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>FICHA</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat=" item in contratos | filter:search"
                                            id="tr_contrato_@{{ item.FICHA }}">
                                            <td>@{{ item.FICHA }}</td>
                                            <td>@{{ item.fecha_inicio }}</td>
                                            <td>@{{ item.fecha_fin }}</td>
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
        <div class="modal fade" id="modAddContract" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Renovacion de Contrato </h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <label for="">Fecha de Contrato</label>
                            <input class="form-control" name="daterange" id="reservation" type="text">
                            <label for="">Observación</label>
                            <input class="form-control" id="renov_observacion" type="text" >
                            <br>
                            <button class="btn btn-success" ng-click="saveNewContract()">
                                Guardar <i class="fa fa-floppy-o fa-lg"></i>
                            </button>
                        </form>
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
        /*----*/


        var app = angular.module("app", ['ui.bootstrap']);
        app.controller("PruebaController", function($scope,$http,$window) {

            var ficha = '{{ $ficha }}';

            $scope.s = "a";
            //Declaraciones

            $scope.contratos= [{}];
            $scope.renovaciones = [];

            //funiones que inician al principio

            getDataInit();


            function getDataInit()
            {

                var token = $('#_token').val();


                //primero traemos al personal
                $http.get('{{ URL::route('modRH') }}/api/getTrabajadorBy/'+ficha)
                        .success(function(data){

                            $scope.personal = data;

                            }).error(function(data) {
                                console.log('Error trabajador'+data);
                    });

                //traemos luego a sus contratos registrados
                $http.get('{{ URL::route('modRH') }}/api/getContratos/'+ficha)
                        .success(function(data){

                            $scope.contratos = data;

                        }).error(function(data) {
                    console.log('Error contrato'+data);
                });

                //traemos las renovaciones
                getRenovacionesByFicha(ficha);
            }

            function getRenovacionesByFicha(f) {

                //traemos las renovaciones
                $http.get('{{ URL::route('modRH') }}/api/getRenovacionesByFicha/'+f)
                        .success(function(data){

                          $scope.renovaciones = data;

                        }).error(function(data) {
                    console.log('Error contrato'+data);
                });
            }


            $scope.AddContract = function () {

                $('#modAddContract').modal('show');
                $('#reservation').val('');
                $("#renov_observacion").val('');

            };

            $scope.saveNewContract = function () {


                var mensaje = '';
                var token = $('#_token').val();

                var fecha = $('#reservation').val();
                fecha =  fecha.split('-');

                var f_i = changeFormat(fecha[0]);
                var f_f = changeFormat(fecha[1]);

                var f_i_trabajador = $scope.contratos[0].fecha_inicio;
                var f_f_trabajador = $scope.contratos[0].fecha_fin;

                var observacion = $("#renov_observacion").val();


                if(observacion == null || observacion == ''){
                    observacion = '-';
                }

               var bandera_range_date = getStateRangeDates(f_i,f_f,f_i_trabajador,f_f_trabajador);

                if(bandera_range_date == 1)
                {
                    mensaje += "Error: la fecha se encuentra en un rango fuera de lo admitido \n";
                }

                if($scope.renovaciones.length > 0)
                {
                    f_i_trabajador = $scope.renovaciones[0].fecha_inicio;
                    f_f_trabajador = $scope.renovaciones[0].fecha_fin;

                    bandera_range_date = getStateRangeDates(f_i,f_f,f_i_trabajador,f_f_trabajador);

                    if(bandera_range_date == 1)
                    {
                        mensaje += "Error: El Rango de fechas esta entre las renovciones \n";
                    }
                }

                if(mensaje.length == ''){

                  //si no existe error se crea el nuevo contrato

                    var ruta = "{{ URL::route('addNewRenovacion') }}";
                    var f_fin_cambiada = ch_format_YMD_DMY($scope.contratos[0].fecha_fin);
                    f_i=ch_format_YMD_DMY(f_i);
                    f_f=ch_format_YMD_DMY(f_f);
                    $http.post(ruta,
                            {_token : token,
                                f_i:f_i,
                                f_f: f_f,
                                f_fin_cambiada:f_fin_cambiada,
                                observacion:observacion,
                                ficha:ficha
                            })
                            .success(function(data){

                                console.log(data);
                                getRenovacionesByFicha(ficha);
                                $('#modAddContract').modal('hide');

                            }).error(function(data) {
                        console.log(data);

                    });
                }else{
                    alert(mensaje);
                }

            };


            $scope.eliminarContrato =function (id) {


                var r = confirm("Seguro que desea:  eliminar el contrato ?");
                if (r == true) {
                    console.log(id);
                }

            };


            /*funcion helper*/
            function changeFormat(fecha)
            {
                fecha = fecha.split('/');

                fecha = fecha[2].trim()+"-"+fecha[1].trim()+"-"+fecha[0].trim();

                return fecha;
            }

            function ch_format_YMD_DMY(fecha) {

                fecha = fecha.split('-');

                fecha =fecha[2].trim()+"-"+fecha[1].trim()+"-"+fecha[0].trim();

                return fecha;

            }

            function getStateRangeDates(f_i, f_f,f_i_trabajador,f_f_trabajador) {

                var bandera= 0;

                /*estas son la sfechas del trabajador , que es su ultimo contrato*/
                f_i_trabajador = new Date(f_i_trabajador);
                f_f_trabajador = new Date(f_f_trabajador);

                //convertimos en date las fechas que vienen como parametros de la funcion
                f_i = new Date(f_i);
                f_f = new Date(f_f);

                //luego comparamos para saber si esta en el rango del contrato establecido
                //el algoritmo sacado es del sp (@f_i < FECHA_TERMINO and  (@f_f > FECHA_INICIO  OR @f_f > FECHA_TERMINO) )

                if(f_i<f_f_trabajador && (f_f>f_i_trabajador || f_f>f_f_trabajador)){

                    bandera = 1;
                }

                return bandera;
            }
        });
    </script>
@stop