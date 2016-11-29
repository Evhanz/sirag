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


                                    <label for="">Exportar</label><br>
                                    <a href="#" class="btn btn-success btn-xs" onClick ="print_excel()" title="Reporte Totalizado Excel">
                                        <i class="fa fa-file-excel-o fa-lg"></i>
                                    </a>
                                </div>
                            </form>

                            <div class="row" style="padding: 15px">
                                <div class="table-responsive" style="overflow: auto" id="cont_tabla">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th>FICHA</th>
                                            <th>NOMBRE</th>
                                            <th>QUINCENA</th>
                                            <th>FIN DE MES</th>
                                            <th>LIQUIDACION </th>

                                        </tr>
                                        </thead>
                                        <tbody >
                                        <tr  ng-repeat=" item in Documentos | filter:search" id="tr_Doc_@{{ item.FICHA }}">
                                            <td >@{{ item.FICHA}}</td>
                                            <td >@{{ item.NOMBRE }}</td>
                                            <td>@{{ item.QUINCENA }}</td>
                                            <td>@{{ item.F_MES }}</td>
                                            <td>@{{ item.LIQUIDACION }}</td>
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

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });
        $('[data-toggle="tooltip"]').tooltip();
        /*
         $(document).ready(function(){

         });*/


        function print_excel() {


            $("#table_data_op1").table2excel({
                exclude: ".noExl",
                name: "export_personal",
                filename: "export_personal",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

        }

        /*----*/


        var app = angular.module("app", ['ui.bootstrap']);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];

            var ruta = '';

            //funciones que inician la pagina



            //traer la data por el click

            $scope.getData = function(){

                var fecha_s_format = $('#reservation').val();
                console.log(fecha_s_format.length);// 0 si es nulo
            };

            $scope.getDataAll = function()
            {

                var token = $('#_token').val();

                var periodo=new Date($("#filAnio").val(), $("#filMes").val(), 0);

                if($("#filMes").val() < 10){
                    periodo = periodo.getFullYear()+"0"+(periodo.getMonth()+1)+""+periodo.getDate();
                }else {
                    periodo = periodo.getFullYear()+""+(periodo.getMonth()+1)+""+periodo.getDate();
                }


                var ruta = "{{URL::route('getPlanilla')}}";

                $("#btnBuscarDoc").attr("disabled", true);
                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                $http.post(ruta,
                        {_token : token,
                            periodo:periodo
                        })
                        .success(function(data){

                            $scope.Documentos = data;
                            console.log(data);

                            $('#btnBuscarDoc').attr("disabled", false);
                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );

                        }).error(function(data) {
                    alert("Se encontró un error en el sistema , contacte con el área de soporte.");
                    $( "div" ).remove( ".overlay" );
                    $( "div" ).remove( ".loading-img" );
                });
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