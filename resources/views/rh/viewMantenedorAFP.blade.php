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
                            <li class="active"><a data-toggle="tab" href="#home">Mantenedor de Sistema de Pensiones</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="box box-info">
                                                    <div class="box-header">

                                                    </div>
                                                    <div class="box-body">

                                                        <form action="{{route('editPersonalAFP')}}" method="post">
                                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <label for="anio">Periodo</label>
                                                                    <select name="anio" id="anio" class="form-control" required>
                                                                        <option value="2018">2018</option>
                                                                        <option value="2017">2017</option>
                                                                        <option value="2016">2016</option>
                                                                        <option value="2015">2015</option>
                                                                    </select>

                                                                    <label for="mes">&nbsp;</label>

                                                                    <select name="mes" id="mes" class="form-control" required>
                                                                        <option value="01">Enero</option>
                                                                        <option value="02">Febrero</option>
                                                                        <option value="03">Marzo</option>
                                                                        <option value="04">Abril</option>
                                                                        <option value="05">Mayo</option>
                                                                        <option value="06">Junio</option>
                                                                        <option value="07">Julio</option>
                                                                        <option value="08">Agosto</option>
                                                                        <option value="09">Septiembre</option>
                                                                        <option value="10">Octubre</option>
                                                                        <option value="11">Noviembre</option>
                                                                        <option value="12">Diciembre</option>
                                                                    </select>


                                                                </div>
                                                                <div class="col-lg-6">

                                                                    <label for="">Generar AFP/SNP:</label>

                                                                    <a ng-click="insertPersonalAFP()" class="btn btn-info" style="width: 100%">
                                                                        <i class="fa fa-dot-circle-o"></i>
                                                                    </a>
                                                                    <hr>

                                                                    <label for="ficha" >Ficha Trabajador</label>

                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-users text-blue"></i>
                                                                        </div>
                                                                        <input name="ficha"  ng-model="trabajador.ficha" class="form-control" id="ficha" type="text" ng-change="changeFicha()" required>
                                                                        <div class="input-group-addon" style="padding-bottom: 0px;padding-top: 0px;">
                                                                            <a class="btn-xs btn btn-info" ng-click="getTrabajador()">
                                                                                <i class="fa fa-search "></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <input class="form-control" name="nombre" type="text" ng-model="trabajador.nombre" readonly="readonly"  required>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <label for="fondo" >Fondo</label>
                                                                            <select CLASS="form-control" name="fondo" id="fondo" ng-model="trabajador.afp" ng-change="updateFondo()" required>
                                                                                <option value="">--------</option>
                                                                                <option ng-repeat="item in afps" value="@{{item.DESCRIPCION}}">@{{ item.DESCRIPCION }}</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label for="ficha" >Comision</label>
                                                                            <select class="form-control" name="comision" id="comision" ng-model="trabajador.comision" required>
                                                                                <option value="">--------</option>
                                                                                <option ng-repeat="item in comisiones" value="@{{item.DESCRIPCION}}">@{{ item.DESCRIPCION }}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <a class="btn btn-success" style="width: 100%" ng-click="updateTrabajador()">
                                                                        <i class="fa fa-floppy-o"></i>
                                                                    </a>

                                                                </div>
                                                            </div>
                                                        </form>



                                                    </div>
                                                    <div class="box-footer">

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="box box-warning">
                                                    <div class="box-body">
                                                        <label for="cargo">Mantenedor de porcentajes
                                                            <a ng-click="getProcentajesAfp()" class="btn btn-warning btn-xs">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                        </label>
                                                        <br>
                                                       <table class="table table-bordered">
                                                           <thead>
                                                           <tr>
                                                               <th>Descripcion</th>
                                                               <th>Comision Flujo</th>
                                                               <th>Comision Mixto</th>
                                                               <th>Seguro</th>
                                                           </tr>
                                                           </thead>
                                                           <tbody>
                                                           <tr ng-repeat="item in porcentajes">
                                                               <td>@{{ item.descripcion }}</td>
                                                               <td><input ng-keyup="$event.keyCode == 13 && updatePorcentaje(item,'flujo',$index)" id="@{{ $index }}_flujo" class="form-control" ng-dblclick="changePorcentaje('flujo',$index)" step="any" type="number" ng-model = "item.COMI_FLUJO " readonly> </td>
                                                               <td><input ng-keyup="$event.keyCode == 13 && updatePorcentaje(item,'mixta',$index)" id="@{{ $index }}_mixta" class="form-control" ng-dblclick="changePorcentaje('mixta',$index)" step="any"  type="number" ng-model = "item.COMI_MIXTO " readonly> </td>
                                                               <td><input ng-keyup="$event.keyCode == 13 && updatePorcentaje(item,'seguro',$index)" id="@{{ $index }}_seguro" class="form-control" ng-dblclick="changePorcentaje('seguro',$index)" step="any" type="number" ng-model="item.SEGURO" readonly> </td>
                                                           </tr>
                                                           </tbody>

                                                       </table>
                                                    </div>
                                                </div>


                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div><!-- /.row - inside box -->
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->

            </div>

        </div>

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


            $scope.trabajador = {ficha:'',afp:'',nombre:'',comision:''};
            $scope.afps =[];
            $scope.comisiones =[];
            $scope.porcentajes = [];




            getInitData();

            var token = $("#_token").val();

            $scope.getTrabajador  = function () {
                var ficha  = $scope.trabajador.ficha.trim();
                if($scope.ficha !== ''){
                    var periodo = $("#anio").val()+''+$("#mes").val()+'01';
                    var ruta = "{{route('modRH')}}/api/getTrabajadorForAFP/"+ficha+'/'+periodo;
                    $http.get(ruta)
                        .success(function(data){
                            $scope.trabajador = data;

                            if($scope.trabajador.afp === 'ONP'){
                                //disabled select
                                $('#comision').prop('disabled', 'disabled');
                            }else{
                                $('#comision').prop('disabled', false);
                            }

                            //console.log(data);
                        }).error(function(data) {
                        console.log(data);
                        alert('Valor No Encontrado');
                    });
                }else{
                    alert('Debe Ingresar una Ficha');
                }

            };
            $scope.updateFondo = function () {

                var bandera = $scope.trabajador.afp ;

                if(bandera === 'ONP'){
                    //disabled select
                    $('#comision').prop('disabled', 'disabled');
                    $scope.trabajador.comision = '';
                }else{
                    $('#comision').prop('disabled', false);
                }

            };
            $scope.updateTrabajador = function () {

                var bandera = validateForm();

                if(bandera === 0){

                    var token = $("#_token").val();
                    var ruta = "{{route('editPersonalAFP')}}";
                    var periodo = $("#anio").val() +''+ $("#mes").val()+'01';

                    $http.post(ruta,{
                        toke:token,
                        trabajador:$scope.trabajador,
                        periodo:periodo
                    }).success(function(data){

                        if(data.detalle_res === 1){
                            alert('Correcto');
                            $scope.trabajador = {ficha:'',afp:'',nombre:'',comision:''};


                        }else{
                            alert('Revisar la consola , Error:500');
                            console.log(data);
                        }



                    }).error(function(data) {
                        console.log(data);
                        alert('Valor No Encontrado');
                    });

                }else{
                    alert("Ingrese todos los datos obligatorios");
                }



            };
            $scope.changeFicha = function () {
                $scope.trabajador.nombre = '';
            };
            $scope.insertPersonalAFP = function () {

                var periodo = $("#anio").val() +''+ $("#mes").val()+'01';
                var ruta = "{{route('modRH')}}/store/insertFichaAfp/"+periodo;

                var a = confirm('Seguro que desea continuar ? , Se ingresaran los datos del periodo seleccionado');

                if(a === true){
                    $http.get(ruta)
                        .success(function(data){
                            if(data === true){
                                alert('Proceso Finalizó Correctamente');
                            }else{
                                alert('Revisar');
                                console.log(data);
                            }
                        }).error(function(data) {
                        console.log(data);
                        alert('Error en el proceso');
                    });
                }
            };
            $scope.getProcentajesAfp = function () {

                var periodo = $("#anio").val()+''+$("#mes").val()+'01';
                var ruta = "{{route('modRH')}}/api/getPorcentajesAFP/"+periodo;

                $scope.porcentajes = [];

                $http.get(ruta)
                    .success(function(data){
                        $scope.porcentajes = data;
                    }).error(function(data) {
                    console.log(data);
                    alert('Error en el proceso');
                });

            };

            $scope.changePorcentaje = function (opcion, index) {

              //  alert('llega');

                $("#"+index+"_"+opcion).removeAttr("readonly");

               // $().prop('disabled', false);
            };


            $scope.updatePorcentaje = function (item,opcion,index) {

                var columna = '',value=0;
                var ruta = "{{route('editPorcentajeAFP')}}";
                var token = $("#_token").val();
                var periodo = $("#anio").val()+''+$("#mes").val()+'01';
                $("#"+index+"_"+opcion).attr("readonly");

                switch (opcion){

                    case 'flujo':  columna = 'valor1'; value = item.COMI_FLUJO; break;
                    case 'mixta':  columna = 'valor2'; value = item.COMI_MIXTO; break;
                    case 'seguro': columna = 'valor3'; value = item.SEGURO; break;
                }


                $http.post(ruta,{
                    _token:token,
                    columna:columna,
                    value:value,
                    periodo:periodo,
                    descripcion:item.descripcion
                })
                    .success(function(data){
                        if(data=== 'ok'){
                            alert('Cambiado Correctamente');
                            $scope.getProcentajesAfp();
                        }else{
                            alert('Error:500');
                            console.log(data);
                            $scope.getProcentajesAfp();
                        }
                    }).error(function(data) {
                    console.log(data);
                    alert('Error en el proceso');
                    $scope.getProcentajesAfp();
                });




            };


            function validateForm() {
                var trabajador  = $scope.trabajador;
                var bandera = 0;
                var anio = $("#anio").val();
                var mes = $("#mes").val();


                if(trabajador.ficha === ''){
                    bandera = 1;
                }
                if(trabajador.nombre === ''){
                    bandera = 1;
                }
                if(trabajador.afp === ''){
                    bandera = 1;
                }
                if(trabajador.comision === '' && trabajador.afp !== 'ONP'){
                    bandera = 1;
                }
                if(trabajador.anio === ''){
                    bandera = 1;
                }
                if(trabajador.mes === ''){
                    bandera = 1;
                }


                return bandera;


            }
            function getInitData() {

                var ruta = "{{ route('getInitMantAFP') }}";

                $http.get(ruta)
                    .success(function(data){
                        $scope.comisiones = data.comision;
                        $scope.afps  = data.afp;
                }).error(function(data) {
                    console.log(data);

                });

            }






        });
    </script>


@stop