@extends('layout')

@section('content')

    <!-- datepicker -->
    <script src="{{asset('templates/lte2/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/datepicker/datepicker3.css')}}">

    <script type="text/javascript" src="{{ asset('js/plugins/table2excel/jquery.table2excel.min.js') }} "></script>
    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Personal</a></li>
                            <li ><a data-toggle="tab" href="#agraria">Agrario</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="row" id="box_maestro">
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

                                            <div class="col-lg-12" style="padding: 15px">
                                                <div class="table-responsive" style="overflow: auto" id="cont_tabla">
                                                    <table class="table table-bordered" id="table_data_op1">
                                                        <thead >
                                                        <tr>
                                                            <th>*</th>
                                                            <th>FICHA</th>
                                                            <th>NOMBRE</th>
                                                            <th>QUINCENA</th>
                                                            <th>FIN DE MES</th>
                                                            <th>LIQUIDACION </th>
                                                            <th>TOTAL</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody >
                                                        <tr  ng-repeat=" item in Documentos | filter:search" id="tr_Doc_@{{ item.FICHA }} ">
                                                            <td>@{{ $index + 1}}</td>
                                                            <td>@{{ item.FICHA}}</td>
                                                            <td>@{{ item.NOMBRE }}</td>
                                                            <td>@{{ item.QUINCENA }}</td>
                                                            <td>@{{ item.F_MES }}</td>
                                                            <td>@{{ item.LIQUIDACION }}</td>
                                                            <td>@{{ item.TOTAL }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><H2>TOTALES</H2></td>
                                                            <td>@{{ totales.t_quincena }}</td>
                                                            <td>@{{ totales.t_f_mes }}</td>
                                                            <td>@{{ totales.t_liquidacion }}</td>
                                                            <td>@{{ totales.total }}</td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div><!-- /.row - inside box -->


                                        </div>

                                    </div>
                                    <!-- Tab filtro documento -->
                                    <div id="agraria" class="tab-pane fade">
                                       <h2>Agraria</h2>
                                        <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                        <form class="form-inline" style="padding: 15px">
                                            <div class="form-group">
                                                <label for="">Fecha</label>
                                                <input id="periodo_agrario" class="form-control datepicker">
                                            </div>
                                            <div class="form-group">
                                                <label for=""></label><br>
                                                <button class="btn btn-success" id="btnBuscarDocAgraria" ng-click="getDataAllAgraria()">
                                                    <i class="fa fa-search fa-lg"></i>
                                                </button>
                                            </div>
                                        </form>

                                        <form class="form-inline" style="padding: 15px">

                                            <div class="form-group">
                                                <label for="">Nombre</label>
                                                <input type="text" class="form-control" ng-model="searchA.NOMBRE">
                                            </div>
                                            <div class="form-group">

                                                <label for="">Exportar</label><br>
                                                <a href="#" class="btn btn-success btn-xs" onClick ="print_excel_agraria()" title="Reporte Totalizado Excel">
                                                    <i class="fa fa-file-excel-o fa-lg"></i>
                                                </a>
                                            </div>
                                        </form>

                                        <div class="row" style="padding: 15px">
                                            <div class="table-responsive" style="overflow: auto" id="cont_tabla">
                                                <table class="table table-bordered" id="table_data_op1" data-table="1">
                                                    <thead >
                                                    <tr>
                                                        <th>*</th>
                                                        <th>FICHA</th>
                                                        <th>NOMBRE</th>
                                                        <th>Remuneracion Basica</th>
                                                        <th>Haber Movilidad</th>
                                                        <th>Asignacion Familiar</th>
                                                        <th>Reintegros</th>
                                                        <th>Vacaciones Gozadas</th>
                                                        <th>H.100%</th>
                                                        <th>Vacaciones Truncas</th>
                                                        <th>CTS</th>
                                                        <th>Gratificacion</th>
                                                        <th>Movilidad Condicion</th>
                                                        <th>Bonificacion Extraor</th>
                                                        <th>Total Haber</th>
                                                        <th>SNP</th>
                                                        <th>AFP</th>
                                                        <th>Comision AFP</th>
                                                        <th>Seguro AFP</th>
                                                        <th>Liquidacion</th>
                                                        <th>Desc Movilidad_con </th>
                                                        <th>Reembolso Movilidad </th>
                                                        <th>Desc Venta </th>
                                                        <th>Essalud </th>
                                                        <th>Descuentos</th>
                                                        <th>SEMANAL</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody >
                                                    <tr  ng-repeat=" item in DocAgraria | filter:searchA" id="tr_Doc_@{{ item.FICHA }}">
                                                        <td>@{{ $index + 1}}</td>
                                                        <td>@{{ item.FICHA}}</td>
                                                        <td>@{{ item.NOMBRE }}</td>
                                                        <td>@{{ item.remuneracion_basica }}</td>
                                                        <td>@{{ item.haber_movilidad }}</td>
                                                        <td>@{{ item.asignacion_familiar }}</td>
                                                        <td>@{{ item.reintegros }}</td>
                                                        <td>@{{ item.vacaciones_gozadas }}</td>
                                                        <td>@{{ item.importe_hs_100 }}</td>
                                                        <td>@{{ item.vacaciones_truncas }}</td>
                                                        <td>@{{ item.cts_ley }}</td>
                                                        <td>@{{ item.gratificacion }}</td>
                                                        <td>@{{ item.movilidad_condicion }}</td>
                                                        <td>@{{ item.bonificacion_extraor }}</td>
                                                        <td>@{{ item.total_haber }}</td>
                                                        <td>@{{ item.snp }}</td>
                                                        <td>@{{ item.fondo_afp }}</td>
                                                        <td>@{{ item.comision_afp }}</td>
                                                        <td>@{{ item.seguro_afp }}</td>
                                                        <td>@{{ item.liquidacion }}</td>
                                                        <td>@{{ item.desc_movilidad_con }}</td>
                                                        <td>@{{ item.reembolso_movilidad }}</td>
                                                        <td>@{{ item.desc_venta }}</td>
                                                        <td>@{{ item.essalud }}</td>
                                                        <td>@{{ item.descuentos }}</td>
                                                        <td>@{{ item.semanal }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><H2>TOTALES</H2></td>
                                                        <td>@{{ totalesAgraria.t_semanal }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div><!-- /.row - inside box -->
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

        $('#periodo_agrario').datepicker({
            format: 'dd/mm/yyyy'
        });
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

        function print_excel_agraria() {


            $('*[data-table="1"]').table2excel({
                exclude: ".noExl",
                name: "export_personal_agraria",
                filename: "export_personal_agraria",
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
            $scope.totalesAgraria = {};
            $scope.DocAgraria = [{}];
            $scope.totales = {};
            $scope.totales_agraria=[];

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

                            $scope.Documentos = data.data;
                            $scope.totales.t_liquidacion = data.t_liquidacion;
                            $scope.totales.t_f_mes = data.t_f_mes;
                            $scope.totales.t_quincena = data.t_quincena;
                            $scope.totales.total = data.total;

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

            $scope.getDataAllAgraria = function()
            {

                var token = $('#_token').val();

                var periodo= $("#periodo_agrario").val();


                if(periodo.length > 0){
                    var ruta = "{{URL::route('getPlanillaAgrario')}}";


                    $("#btnBuscarDocAgraria").attr("disabled", true);
                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");


                    periodo = periodo.split('/');
                    periodo = periodo[2]+''+periodo[1]+''+periodo[0];

                    console.log(periodo);


                     $http.post(ruta, {_token : token, periodo:periodo })
                     .success(function(data){
                                $scope.DocAgraria = data.data;
                                $scope.totalesAgraria.t_semanal = data.t_semanal;
                                $scope.totales_agraria = data.totales;

                                 console.log(data);

                                $('#btnBuscarDocAgraria').attr("disabled", false);
                                $( "div" ).remove( ".overlay" );
                                $( "div" ).remove( ".loading-img" );
                     }).error(function(data) {
                            alert("Se encontró un error en el sistema , contacte con el área de soporte.");
                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );
                     });



                }
                else{
                    alert("Debe ingresar primero una fecha");
                }








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