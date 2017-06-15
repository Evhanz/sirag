@extends('layout')

@section('content')

    <style>
        tr[data-style^="body_table1"]:hover{
            background: #0970A8;
            color: white;
        }

        tr[data-style^="body_table1"] td input[type^="checkbox"]:hover{
           /* outline: 2px solid #F00; */
        }
    </style>

	

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <input type="hidden" id="_token" value="{{ csrf_token() }}" />

                <div class="col-md-12">
                    <!-- Box (usu) -->
                    <div class="box box-default" >
                        <div class="box-header">
                            <ul class="nav nav-tabs" id="tab_filtros">
                                <li class="active"><a data-toggle="tab" href="#home">Usuarios Rol</a></li>
                                <li class=""><a data-toggle="tab" href="#modulos">Módulos </a></li>
                                <li class=""><a data-toggle="tab" href="#mantenedor_opciones">Mantenedor Opciones </a></li>
                            </ul>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding">

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active ">
                                    <div class="row" style="padding-left: 15px;padding-right: 15px;">
                                        <div class="col-lg-8">
                                            <table class="table table-bordered" data-style="tabla1">
                                                <tr>
                                                    <td> <h4>Personal</h4></td>
                                                    <td  ng-repeat=" item in roles">
                                                        @{{item.name}}
                                                    </td>
                                                    <td>
                                                        *
                                                    </td>
                                                </tr>
                                                <tr  ng-repeat=" u in usuarios" data-style="body_table1">
                                                    <td>
                                                        @{{ u.usr }}
                                                    </td>
                                                    <td  ng-repeat=" d in u.detail" >
                                                        <input type="checkbox" ng-model="d.res" ng-change="changeState(u,d)">
                                                    </td>
                                                    <td>
                                                        <div  ng-show="u.change">
                                                            <button class="btn btn-success btn-xs" ng-click="update_roles(u)"> <i class="fa fa-floppy-o" ></i> </button>
                                                        </div>

                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div><!-- /.row - inside box -->
                                </div>

                                <div id="modulos" class="tab-pane fade" style="padding-left: 15px;padding-right: 15px;">

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="">Personal   <span class="mensaje_cargando" > <i class="fa fa-spinner fa-spin  fa-fw"></i></span></label>
                                            <select class="form-control" name="" id="" ng-change="getModulesUser(usuario)" ng-model="usuario" ng-init="usuario = ''">
                                                <option value="">-------------</option>
                                                <option  ng-repeat=" u in usuarios" value="@{{ u.usr  }}">@{{ u.usr }}</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-8">

                                            <div class="row">
                                                <div ng-repeat=" m in modulos" class="col-lg-6">
                                                    <span > <input type="checkbox" ng-model="m.check" ng-change="changeModulo(m,'modulo')">
                                                        @{{ m.alias }}
                                                    </span>

                                                    <ul class="list-group">
                                                        <li ng-repeat=" s in m.sub_modulo" class="list-group-item">
                                                            <span > <input type="checkbox"  ng-model="s.check" ng-change="changeModulo(s,'sub_modulo')">
                                                                @{{ s.nombre }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div id="mantenedor_opciones">

                                    <div class="row">
                                        <div class="col-lg-6">

                                            

                                        </div>
                                        <div class="col-lg-6">

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">

                        </div><!-- /.box-footer -->
                    </div><!-- /.box -->

                </div>
             

                <div class="col-lg-12">



                </div>
            </div>

        </div><!--/. content-->

    


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


            initData();

            $scope.modulos = [];




            function initData() {
                
                var ruta = '{{ URL::route('getAllUsersAndRoles') }}';

                $http.get(ruta)
                .success(function (data) {
                    
                    $scope.roles = data.roles;
                    $scope.usuarios = data.usuarios;

                })
                .error(function (data) {
                    
                    alert("Hay un problema con el servidor");
                    console.log(data);
                });


                var ruta = '{{ URL::route('getModulosAndSubModulos') }}';

                $http.get(ruta)
                    .success(function (data) {

                      //console.log(data);
                        $scope.modulos = [];
                        $scope.modulos = data;

                    })
                    .error(function (data) {

                        alert("Hay un problema con el servidor");
                        console.log(data);
                    });


                $(".mensaje_cargando").hide();


            }


            $scope.changeState = function (user,d) {
                
                user.change = true;
                //if (d.res) {d.res = false} else {d.res = true}

            };

            $scope.update_roles = function (user) {
                //console.log(user);

                var _token = $("#_token").val();

                var ruta   = "{{ URL::route('updateRolesUsuarios') }}";


                $http.post(ruta,{
                    _token: _token,
                    user  : user
                })
                .success(function (data) {

                    user.change = false;
                    
                    //console.log(data);

                })
                .error(function (data) {
                    
                    alert("Hay un problema con el servidor");
                    console.log(data);
                });


                
            };

            $scope.changeModulo = function (modulo,tipo) {
                    //alert('a');

                $(".mensaje_cargando").show();

                if($scope.usuario !== ''){
                    var _token = $("#_token").val();
                    var ruta   = "{{ URL::route('modUser') }}"+"/api/changeModulo/"+modulo.id+"/"+$scope.usuario+"/"+tipo;

                    $http.get(ruta)
                        .success(function (data) {
                            $(".mensaje_cargando").hide();

                        })
                        .error(function (data) {

                            alert("Hay un problema con el servidor");
                            console.log(data);
                            $(".mensaje_cargando").hide();
                        });
                }else{
                    alert('Debe seleccionar un usuario');
                    $(".mensaje_cargando").hide();
                    modulo.check = false;
                }




            };


            $scope.getModulesUser= function (usr) {

                clearModules();

                var _token = $("#_token").val();
                var ruta   = "{{ URL::route('modUser') }}"+"/api/getModulesOfUser/"+usr;
                $(".mensaje_cargando").show();
                $http.get(ruta)
                    .success(function (data) {

                        //comparamos los módulos que encontremos para colocar un check
                        
                        angular.forEach($scope.modulos,function (item,key) {

                            angular.forEach(data,function (m, index) {
                                if (item.id == m.id_modulo){
                                    item.check = true;
                                    angular.forEach(item.sub_modulo,function (sub_modulo,k) {
                                        angular.forEach(m.sub_modulo,function (s_m, i) {
                                            if (sub_modulo.id == s_m.id_submodulo){
                                                sub_modulo.check = true;
                                            }
                                        });
                                    });
                                }
                            });
                            
                        });

                        $(".mensaje_cargando").hide();
                    })
                    .error(function (data) {
                        alert("Hay un problema con el servidor");
                        $(".mensaje_cargando").hide();
                    });



            };


           function clearModules() {

               angular.forEach($scope.modulos,function (item,key) {
                   item.check = false;
                   angular.forEach(item.sub_modulo,function (sub_modulo,k) {
                       sub_modulo.check = false;
                   });

               });

           }









        });
    </script>


@stop