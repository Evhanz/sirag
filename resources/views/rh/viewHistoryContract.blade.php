@extends('layout')

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
                                                <input type="text" class="form-control" ng-model="personal.F_INICIO_FORMAT" disabled>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="">Fin Contrato</label>
                                                <input type="text" class="form-control" ng-model="personal.F_TERMINO_FORMAT" disabled>
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
                    <div class="box box-success" id="box_maestro">
                        <div class="box-header" style="padding-left: 15px">
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
                                <div class="table-responsive" style=" height: 190px; overflow: auto; ">
                                    <table class="table table-bordered" id="table_data_op1" >
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
                                            <td>@{{ item.f_inicio_format }}</td>
                                            <td>@{{ item.f_fin_format }}</td>
                                            <td>@{{ item.estado }}</td>
                                            <td>
                                                <a class="btn btn-danger" ng-click="eliminarContrato(item);">
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
                    <div class="box box-warning" id="box_maestro">
                        <div class="box-header"  style="padding-left: 15px">
                            <h4>Contratos Asignados (FlexLine)</h4>
                            <button class="btn btn-default" ng-click="calculeDiasAcumuladosVacaciones();calcCantidadDiasVacaciones();">Calcular</button>
                        </div><!-- /.box-header -->
                        <div class="box-body ">
                            <div class="row" style="padding: 15px" >
                                <div class="table-responsive"  style=" height: 224px; overflow: auto; ">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>FICHA</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>D. Dados</th>
                                            <th>Adeuda. a Hoy</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat=" item in contratos | filter:search"
                                            id="tr_contrato_@{{ item.FICHA }}">
                                            <td>@{{ item.FICHA }}</td>
                                            <td>@{{ item.f_inicio_format }}</td>
                                            <td>@{{ item.f_fin_format }}</td>
                                            <td>@{{ item.d_acumulados }}</td>
                                            <td>@{{ item.d_asignados - item.d_acumulados | number:2}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div><!-- /.row - inside box -->
                        </div><!-- /.box-body -->



                    </div><!-- /.box -->

                </div>
            </div>
            <div class="row">
                <div class="col-lg-6" >
                    <!-- Box (with bar chart) -->
                    <div class="box box-info" id="box_maestro">
                        <div class="box-header" style="padding-left: 15px">
                            <h4>Vacaciones </h4>
                        </div><!-- /.box-header -->
                        <div class="box-body ">
                            <div class="row" style="padding: 15px" >
                                <div class="table-responsive"  style=" height: 224px; overflow: auto; ">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>I</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Transcurrido</th>
                                            <th>Periodo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat=" item in vacaciones "
                                            id="tr_vacaciones_@{{ item.ID_VACA }}">
                                            <td>@{{ item.ID_VACA }}</td>
                                            <td>@{{ item.FEC_INISOL_F }}</td>
                                            <td>@{{ item.FEC_FINSOL_F }}</td>
                                            <td>@{{ item.d_transcurrido }}</td>
                                            <td style="overflow: hidden" >
                                                <div class="row" >
                                                    <div class="col-xs-5" style="padding: 5px;margin: 0px;">
                                                        <select ng-model="item.periodo1" class="form-control" ng-change="updateVacaciones($index)">
                                                            <option value="">-----</option>
                                                            <option value="2014">2014</option>
                                                            <option value="2015">2015</option>
                                                            <option value="2016">2016</option>
                                                            <option value="2017">2017</option>
                                                            <option value="2018">2018</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-5" style="padding: 5px;margin: 0px;">
                                                        <select ng-model="item.periodo2" class="form-control" ng-change="updateVacaciones($index)">
                                                            <option value="">-----</option>
                                                            <option value="2014">2014</option>
                                                            <option value="2015">2015</option>
                                                            <option value="2016">2016</option>
                                                            <option value="2017">2017</option>
                                                            <option value="2018">2018</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-1" style="padding: 5px;margin: 0px;">
                                                        <button id="btnSave@{{ item.ID_VACA }}" ng-click="saveChange($index)"  class="btn bg-olive btn-xs">
                                                            <i class="fa fa-floppy-o"></i>
                                                        </button>
                                                    </div>
                                                </div>
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

        $('.bg-olive').hide();
        /*----*/





        var app = angular.module("app", ['ui.bootstrap']);
        app.controller("PruebaController", function($scope,$http,$window) {

            var ficha = '{{ $ficha }}';

            $scope.s = "a";
            //Declaraciones

            $scope.contratos= [{}];
            $scope.renovaciones = [];
            $scope.vacaciones = [];

            //funiones que inician al principio

            getDataInit();




             function getDataInit()
            {

                var token = $('#_token').val();


                //primero traemos al personal
                $http.get('{{ URL::route('modRH') }}/api/getTrabajadorBy/'+ficha)
                        .success(function(data){

                            $scope.personal = data;

                            $scope.personal.F_INICIO_FORMAT = ch_format_DateTime_DateDMY($scope.personal.FECHA_INICIO);
                            $scope.personal.F_TERMINO_FORMAT = ch_format_DateTime_DateDMY($scope.personal.FECHA_TERMINO);

                            }).error(function(data) {
                                console.log('Error trabajador'+data);
                    });

                //traemos luego a sus contratos registrados
                $http.get('{{ URL::route('modRH') }}/api/getContratos/'+ficha)
                        .success(function(data){

                            for(var i = 0;i<data.length; i++){

                                data[i].f_inicio_format = ch_format_YMD_DMY(data[i].fecha_inicio);
                                data[i].f_fin_format = ch_format_YMD_DMY(data[i].fecha_fin);
                                data[i].d_acumulados = 0;
                                data[i].d_asignados = 0;
                            }

                            $scope.contratos = data;

                        }).error(function(data) {
                    console.log('Error contrato'+data);
                });

                //traemos las renovaciones
                getRenovacionesByFicha(ficha);
                //traemos a las vacaciones
                getVacaciones(ficha);
                //luego calculamos sus dias de vacciones por cada contrato

            }

            function getRenovacionesByFicha(f) {
                //traemos las renovaciones
                $http.get('{{ URL::route('modRH') }}/api/getRenovacionesByFicha/'+f)
                        .success(function(data){

                            for(var i = 0;i<data.length; i++){

                                data[i].f_inicio_format = ch_format_DateTime_DateDMY(data[i].fecha_inicio);
                                data[i].f_fin_format = ch_format_DateTime_DateDMY(data[i].fecha_fin);
                            }

                            $scope.renovaciones = data;

                        }).error(function(data) {
                    console.log('Error contrato'+data);
                });
            }

            function getVacaciones(f) {

                //traemos las renovaciones
                $http.get('{{ URL::route('modRH') }}/api/getVacacionesByFicha/'+f)
                        .success(function(data){


                            for(var i = 0;i<data.length; i++){

                                data[i].FEC_FINSOL_F = ch_format_YMD_DMY(data[i].FEC_FINSOL);
                                data[i].FEC_INISOL_F = ch_format_YMD_DMY(data[i].FEC_INISOL);
                                data[i].d_transcurrido = getCantDiasBetweendates(data[i].FEC_INISOL,data[i].FEC_FINSOL);

                                var periodo = data[i].periodo;
                                periodo = periodo.split("-");

                                switch(periodo.length) {
                                    case 1:
                                        data[i].periodo1 = periodo[0];
                                        data[i].periodo2 = "";
                                        break;
                                    case 2:
                                        data[i].periodo1 = periodo[0];
                                        data[i].periodo2 = periodo[1];
                                        break;
                                    default:
                                        data[i].periodo1 = "";
                                        data[i].periodo2 = "";
                                        break;
                                }

                            }

                            $scope.vacaciones = data;

                            //luego calculamos si en cada periodo de contratos cuantos dias de vacaciones an acumulado
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
                                getDataInit();
                                $('#modAddContract').modal('hide');

                            }).error(function(data) {
                        console.log(data);

                    });
                }else{
                    alert(mensaje);
                }

            };

            $scope.eliminarContrato =function (item) {

                var token = $('#_token').val();
                var r = confirm("Seguro que desea:  eliminar el contrato ?");
                if (r == true) {


                    //averiguaremos si la fecha de inicio de

                    var actual = new Date();
                    var fecha_inicio = new Date(item.fecha_inicio);

                    var dias = actual - fecha_inicio;
                    dias = Math.floor(dias / (1000 * 60 * 60 * 24));

                    //console.log(item.f_fin_cambiada);

                    if(dias<15){

                        var ruta = "{{ URL::route('deleteRenovacion') }}";
                        var f_f = ch_format_DateTime_DateDMY(item.f_fin_cambiada);

                        $http.post(ruta,
                                {_token : token,
                                    id:item.id,
                                    fecha_fin:f_f,
                                    ficha:item.FICHA
                                })
                                .success(function(data){
                                    getDataInit();
                                }).error(function(data) {
                            console.log(data);

                        });




                    }else{
                        console.log(item.f_fin_cambiada);
                        alert("A Pasado la fecha Limite, llamar a la oficina de sistemas");
                    }

                }

            };

            $scope.calculeDiasAcumuladosVacaciones = function () {


                //limpiamos los dias acumulados
                for(var x=0;x<$scope.contratos.length;x++){
                    $scope.contratos[x].d_acumulados = 0;
                }

                //luego asignamos en cada uno cuantas dias tiene acumulado por contrato

                for (var i=0;i<$scope.vacaciones.length;i++){

                    //por cada una de las vacaciones verificamos si pertenece al rango de
                    for (var j=0;j<$scope.contratos.length;j++){

                        var bandera = getStateRangeDates( $scope.vacaciones[i].FEC_INISOL,$scope.vacaciones[i].FEC_FINSOL,
                                $scope.contratos[j].fecha_inicio,$scope.contratos[j].fecha_fin);

                        if(bandera==1){

                            $scope.contratos[j].d_acumulados += $scope.vacaciones[i].d_transcurrido;
                        }

                    }

                }



            };


            //esta funcion sirve para ver cuatos dias de vacaciones tiene
            $scope.calcCantidadDiasVacaciones = function () {


                var fecha = moment().format('YYYY-M-D');
                var bandera ;
                var dias ;
                var tipo;

                for(var i = 0;i<$scope.contratos.length;i++){

                    bandera = getCantDiasBetweendates($scope.contratos[i].fecha_fin,fecha);
                    //dias;

                    if(bandera > 0){
                        dias = getCantDiasBetweendates($scope.contratos[i].fecha_inicio,$scope.contratos[i].fecha_fin);
                    }else
                        dias = getCantDiasBetweendates($scope.contratos[i].fecha_inicio,fecha);



                    //EMPLEADO
                    tipo = $scope.personal.TIPO_TRABAJADOR;

                    if(tipo=='EMPLEADO'){

                        $scope.contratos[i].d_asignados = dias * 0.082;
                        $scope.contratos[i].d_asignados =  Math.round($scope.contratos[i].d_asignados * 100) / 100
                    }else{

                        $scope.contratos[i].d_asignados = dias * 0.041;
                        $scope.contratos[i].d_asignados =  Math.round($scope.contratos[i].d_asignados * 100) / 100

                    }


                }

            };

            $scope.updateVacaciones = function (index) {

                var id = $scope.vacaciones[index].ID_VACA;
                $('#btnSave'+id).show();


            };

            $scope.saveChange = function (index) {

                var id = $scope.vacaciones[index].ID_VACA;
                var periodo = $scope.vacaciones[index].periodo1+'-'+$scope.vacaciones[index].periodo2;
                var ficha = $scope.vacaciones[index].FICHA;
                var token = $('#_token').val();
                var ruta = "{{route('editPeriodoVac')}}";


                $http.post(ruta,
                        {_token : token,
                            id:id,
                            periodo: periodo,
                            ficha: ficha
                        })
                        .success(function(data){

                            if(data.trim()=='ok'){
                                alert('Actualizacion concretada');
                                $('#btnSave'+id).hide();
                            }else{
                                alert('Hubo un error');
                                console.log(data);
                            }

                        }).error(function(data) {
                    console.log(data);

                });



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


            function ch_format_DateTime_DateDMY(fecha) {

                fecha = fecha.split(" ");

                var f = fecha[0];
                f = f.split("-");
                f = f[2].trim()+"-"+f[1].trim()+"-"+f[0].trim();

                return f;
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

            function getCantDiasBetweendates(f_i,f_f){

                f_i = new Date(f_i);
                f_f = new Date(f_f);

                var dias = f_f - f_i;
                dias = Math.floor(dias / (1000 * 60 * 60 * 24));

               return dias+1;

            }


        });
    </script>
@stop