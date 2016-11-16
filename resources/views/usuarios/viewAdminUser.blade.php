@extends('layout')

@section('content')

	

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <input type="hidden" id="_token" value="{{ csrf_token() }}" />

                <div class="col-md-12">
                    <!-- Box (usu) -->
                    <div class="box box-default" >
                        <div class="box-header">
                            <ul class="nav nav-tabs" id="tab_filtros">
                                <li class="active"><a data-toggle="tab" href="#home">Orden Compra</a></li>

                            </ul>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding">
                            <div class="row" style="padding-left: 15px;padding-right: 15px;">

                                <div class="col-lg-8">
                                     <table class="table table-bordered">
                                    <tr>
                                        <td> <h4>Personal</h4></td>
                                        <td  ng-repeat=" item in roles">
                                            @{{item.name}}
                                        </td>
                                        <td>
                                            *
                                        </td>

                                    </tr>

                                    <tr  ng-repeat=" u in usuarios">
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


            }


            $scope.changeState = function (user,d) {
                
                user.change = true;
                //if (d.res) {d.res = false} else {d.res = true}

            }

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


                
            }









        });
    </script>


@stop