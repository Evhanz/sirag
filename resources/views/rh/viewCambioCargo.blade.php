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
                            <li class="active"><a data-toggle="tab" href="#home">Personal</a></li>
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
                                                        <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                                        <label for="ficha" >Ficha Trabajador</label>

                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-users text-blue"></i>
                                                            </div>
                                                            <input name="ficha"  ng-model="ficha" class="form-control" id="ficha" type="text">
                                                            <div class="input-group-addon" style="padding-bottom: 0px;padding-top: 0px;">
                                                               <button class="btn-xs btn btn-info" ng-click="getTrabajador()">
                                                                   <i class="fa fa-search "></i>
                                                               </button>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label for="ficha" >Trabajador</label>
                                                                <input name="" ng-model="trabajador.nombre" class="form-control" id="trabajador" type="text" disabled>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="ficha" >Cargo</label>
                                                                <input name="" ng-model="trabajador.CARGO" class="form-control" id="trabajador" type="text" disabled>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="box box-warning">
                                                    <div class="box-body">
                                                        <label for="cargo">Cargo</label>
                                                        <select class="form-control" name="cargo" id="cargo">
                                                            <option value="">-------------</option>
                                                            <option value="PESADO">PESADO</option>
                                                            <option value="EMBALAJE">EMBALAJE</option>
                                                            <option value="SELECCION">SELECCION</option>
                                                            <option value="PESO FIJO">PESO FIJO</option>
                                                        </select>
                                                        <br>
                                                        <button class="btn btn-success" ng-click="changeCargo()" style="width:100%">
                                                            Guardar
                                                        </button>
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


            $scope.trabajador = {};
            $scope.ficha = '';

            var token = $("#_token").val();

            $scope.getTrabajador  = function () {
                var ficha  = $scope.ficha.trim();
                if($scope.ficha !== ''){
                    var ruta = "{{route('modRH')}}/api/getTrabajadorByFichaAndActive/"+ficha;

                    $http.get(ruta)
                        .success(function(data){
                            $scope.trabajador = data;
                        }).error(function(data) {
                            console.log(data);
                            alert('Valor No Encontrado');
                    });
                }else{
                    alert('Debe Ingresar una Ficha');
                }

            };


            $scope.changeCargo = function () {

                var trabajador  = $scope.trabajador.nombre;
                var ficha = $scope.ficha;
                var cargo = $("#cargo").val();

                var t = confirm("Se cambiara el cargo , desea continuar ?");

                if(t===true){

                    if(trabajador !== '' && cargo !== ''){
                        var ruta = "{{route('editCargo')}}";

                        $http.post(ruta,{
                            toke:token,
                            ficha:ficha,
                            cargo:cargo
                        }).success(function(data){
                            $scope.trabajador = {};
                            console.log(data);
                            if(data===1){
                                alert('Dato Cambiado');
                            }else{

                            }


                        }).error(function(data) {
                            console.log(data);
                            alert('Valor No Encontrado');
                        });
                    }else{
                        alert('Debe Ingresar una Ficha y un cargo');
                    }

                }
            }
        });
    </script>


@stop