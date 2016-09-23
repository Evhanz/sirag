@extends('layoutRH')

@section('content')

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Filtro</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <form class="form-inline" style="padding: 15px" method="post" action="{{ URL::route('txt') }}">
                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                <div class="form-group">
                                                    <label for="" >Nombre</label><br>
                                                    <input name="nombre" type="text" class="form-control" id="filNombre">
                                                </div>
                                                <div class="form-group">
                                                    <label for="" >Año</label><br>
                                                    <select name="filAnio" class="form-control" id="filAnio" required>
                                                        <option value="">--------</option>
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
                                                    <label for="">Tipo Abono</label><br>
                                                    <select  name="t_pago" id="f_tipo_pago" class="form-control"  required>
                                                        <option value="q" >Quincena</option>
                                                        <option value="f">F. Mes</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""></label><br>
                                                    <a class="btn btn-success" id="btnBuscarDoc" ng-click="getDataAll()">
                                                        <i class="fa fa-search fa-lg"></i>
                                                    </a>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label><br>

                                                </div>

                                                <div class="form-group">
                                                    <label for="">Referencia de Planilla</label><br>
                                                    <input class="form-control" name="ref_planilla" type="text" id="ref_planilla" required>
                                                </div>


                                                <div class="form-group">
                                                    <label for=""></label><br>
                                                    <button class="btn btn-default" id="btnBuscarDoc">
                                                        <i class="fa fa-download fa-lg"></i>
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
                            		Tipo de Moneda de Abono	Monto de Abono	Validación IDC del proveedor vs Cuenta



                            </label> <br> -->


                            <div class="row">
                                <div class=" col-lg-12 form-inline">


                                </div>
                            </div>




                            <div class="row" style="padding: 15px">
                                <div class="table-responsive" style="overflow: auto">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>I</th>
                                            <th>T. Registro</th>
                                            <th>T. Cuenta Abono</th>
                                            <th>Cuenta de Abono</th>
                                            <th>T. Doc. de Identidad</th>
                                            <th>DNI</th>
                                            <th>Nombre</th>
                                            <th>T. Moneda Abono</th>
                                            <th>Monto Abono</th>
                                            <th>Validación IDC del proveedor vs Cuenta</th>

                                        </tr>
                                        </thead>
                                        <tbody >
                                        <tr  ng-repeat=" item in Documentos | filter:search" id="tr_Doc_@{{ $index }}">
                                            <td>@{{ $index }}</td>
                                            <td>@{{ item.TIPO_REGISTRO }}</td>
                                            <td>@{{ item.TIPO_CUENTA_ABONO }}</td>
                                            <td>@{{ item.CUENTAS_ABONO }}</td>
                                            <td>@{{ item.TIPO_DOCUMENTO }}</td>
                                            <td>@{{ item.DNI }}</td>
                                            <td>@{{ item.Nombre }}</td>
                                            <td>@{{ item.TIPO_MONEDA }}</td>
                                            <td>@{{ item.MONTO }}</td>
                                            <td>@{{ item.VALIDACION_IDC }}</td>
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

                var nombre = $("#filNombre").val();

                var t_pago = $("#f_tipo_pago").val();
                var mes = $("#filMes").val();
                var anio = $("#filAnio").val();

                var ultimoDia = new Date(anio,mes, 0);

                ultimoDia = ultimoDia.getDate()+'/'+(ultimoDia.getMonth()+1)+'/'+ultimoDia.getFullYear();

                var bandera = validator();

                if(bandera==0){
                    ruta = '{{ URL::route('getTelecredito') }}';

                    $http.post(ruta,
                            {_token : token,
                                periodo:ultimoDia,
                                nombre:nombre,
                                t_pago:t_pago
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

                }else{
                    alert("Llene los campos obligatorios");
                }


            };


            $scope.getTxt = function () {

                var bandera = validator();

                var t_pago = $("#f_tipo_pago").val();
                var mes = $("#filMes").val();
                var anio = $("#filAnio").val();
                var ref_planilla = $("#ref_planilla").val();

                if(ref_planilla==null || ref_planilla.length<1){
                    bandera=1;
                }

                var ultimoDia = new Date(anio,mes, 0);

                ultimoDia = ultimoDia.getDate()+'-'+(ultimoDia.getMonth()+1)+'-'+ultimoDia.getFullYear();

                if(bandera==0){
                    window.location="{{ URL::route('modRH') }}/txt/telecredito/"+ultimoDia+"/"+t_pago+"/"+ref_planilla;
                }else{
                    alert("Llene los datos obligatorio");
                }

            };




            /*funcion helper*/


            function validator() {


                var t_pago = $("#f_tipo_pago").val();

                var mes = $("#filMes").val();
                var anio = $("#filAnio").val();

                var bandera = 0;

                if(t_pago==null || t_pago.length<1){
                    console.log("t_pago");
                    bandera=1;
                }
                if(mes==null || mes.length<1){
                    bandera=1;
                    console.log("mes");
                }
                if(anio==null || anio.length<1){
                    bandera=1;
                    console.log("bandera");
                }


                return bandera;
            }

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