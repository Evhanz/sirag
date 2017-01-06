@extends('layout')

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
                                            <form id="frmFiltro" class="form-inline" style="padding: 15px" method="post" action="{{ URL::route('txt') }}">
                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="data_include" id="data_include" required>

                                                <div class="form-group">
                                                    <label for="" >Año</label><br>
                                                    <select name="filAnio" class="form-control" id="filAnio" required>
                                                        <option value="">--------</option>
                                                        <option value="2016">2017</option>
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
                                                <div class="form-group" ng-show="tEmpleado!='empleado'">
                                                    <label for="" >Día</label><br>
                                                    <select  name="filDia" class="form-control" id="filDia" required>
                                                        <option value="">--------</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>
                                                        <option value="19">19</option>
                                                        <option value="20">20</option>
                                                        <option value="21">21</option>
                                                        <option value="22">22</option>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                        <option value="28">28</option>
                                                        <option value="29">29</option>
                                                        <option value="30">30</option>
                                                        <option value="31">31</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tipo Empleado</label><br>
                                                    <select id="t_empleado"  name="t_empleado" ng-model="tEmpleado"  class="form-control"  required>
                                                        <option value="empleado" >Empleado</option>
                                                        <option value="operario" >Operario</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Tipo Abono</label><br>
                                                    <select  name="t_pago" id="f_tipo_pago" class="form-control"  required>
                                                        <option ng-repeat="item in tAbono" value="@{{ item.val }}">
                                                            @{{ item.text }}
                                                        </option>
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
                                                <div class="form-group">
                                                    <label for=""> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label><br>

                                                </div>
                                                <div class="form-group">
                                                    <label for=""> Monto Total</label><br>
                                                    <h4>@{{ total_abonado | number:2 }}</h4>
                                                </div>

                                                <div class="form-group">
                                                    <label for=""> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label><br>

                                                </div>

                                                <div class="form-group">
                                                    <label for="">Cantidad de Errores</label><br>
                                                   <label for="" class="label label-danger">
                                                            @{{  cant_error }}
                                                        </label>
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
                                <div class="col-lg-3">
                                    <label for="cargo">Filtrar por Cargo </label>  <br>
                                    <select  multiple class="form-control" id="select" ng-model="filcargo" >
                                        <option value="">------ Todos ------</option>
                                        <option ng-repeat="dato in cargos" value="@{{dato.CODIGO}}">
                                            @{{dato.CODIGO}}
                                        </option>
                                    </select> <br>

                                </div>

                                <div class="col-lg-2">
                                    <label for="cargo">Filtrar por Departamento </label>  <br>
                                    <select class="form-control"  ng-model="fildepartamento" >
                                        <option value="">------ Todos ------</option>
                                        <option ng-repeat="dato in departamentos" value="@{{dato.CODIGO}}">
                                            @{{dato.ALIAS}}
                                        </option>
                                    </select> <br>

                                </div>

                                <!--
                                <div class=" col-lg-2">
                                    <label for="">Seleccionar a :</label>  <br>
                                    <select class="form-control" ng-model="a" ng-change="allSelect()" >
                                        <option value="1">Todos</option>
                                        <option value="0">Nadie</option>
                                    </select>
                                </div>-->
                                <div class="col-lg-3">
                                    <label for="" >Nombre</label><br>
                                    <input name="nombre" type="text" class="form-control" id="nombre" ng-model="filtro.Nombre">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Filtrar por  :</label>  <br>
                                    <select class="form-control" ng-model="filtro.habil"  >
                                        <option value="">-------</option>
                                        <option value="1">Habil</option>

                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Filtrar por error :</label>  <br>
                                    <select class="form-control" ng-model="filtro.e"  >
                                        <option value="">-------</option>
                                        <option value="error">Si</option>

                                    </select>
                                </div>
                            </div>


                            <div class="row" style="padding: 15px">
                                <div class="table-responsive" style="overflow: auto">
                                    <table class="table table-bordered" id="table_data_op1">
                                        <thead >
                                        <tr>
                                            <th style="text-align: center"> I <br>
                                                <span class="label label-warning" style="cursor: pointer" ng-click="changeAllFilter()">
                                                    <i class="fa fa-circle-o fa-1x"></i>
                                                </span>
                                            </th>
                                            <th>T. Registro</th>
                                            <th>T. Cuenta Abono</th>
                                            <th>Cuenta de Abono</th>
                                            <th>T. Doc. de Identidad</th>
                                            <th>DNI</th>
                                            <th>Nombre</th>
                                            <th>CARGO</th>
                                            <th>T. Moneda Abono</th>
                                            <th>Monto Abono</th>
                                            <th>V. IDC del proveedor vs Cuenta</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        <tr  ng-repeat=" item in (filteredItems = ( Documentos  | filter:filterCargo | filter:filterDepartamento | filter:filtro ))  " id="tr_Doc_@{{ $index }}" data-style="@{{ item.e }}">
                                            <td>
                                                <button ng-show="item.habil == 0" class="btn btn-danger" ng-click="changeHabil(item.correlativo)"
                                                        style="padding: 3px;">
                                                    <i class="fa fa-check-circle fa-1x" aria-hidden="true"></i>
                                                </button>
                                                <button ng-show="item.habil == 1" class="btn btn-success" ng-click="changeHabil(item.correlativo)"
                                                        style="padding: 3px;">
                                                    <i class="fa fa-check-circle fa-1x" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td>@{{ item.TIPO_REGISTRO }}</td>
                                            <td>@{{ item.TIPO_CUENTA_ABONO }}</td>
                                            <td data-style="@{{ item.e_cuenta }}">@{{ item.CUENTAS_ABONO }}</td>
                                            <td>@{{ item.TIPO_DOCUMENTO }}</td>
                                            <td data-style="@{{ item.e_dni }}">@{{ item.DNI }}</td>
                                            <td>@{{ item.Nombre }}</td>
                                            <td>@{{ item.CARGO }}</td>
                                            <td>@{{ item.TIPO_MONEDA }}</td>
                                            <td>@{{ item.MONTO | number:2 }}</td>
                                            <td>@{{ item.VALIDACION_IDC }} </td>
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

    <script src="{{asset('js/plugins/angular/angular-bootstrap-multiselect.min.js')}}"></script>

    <script>




        var app = angular.module("app", ['btorfs.multiselect']);
        app.controller("PruebaController", function($scope,$http,$q, $timeout) {


            //Declaraciones


            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];
            $scope.cargos = [{}];
            $scope.a="";
            $scope.cant_error = 0;
            $scope.filcargo=[];
            $scope.fildepartamento="";
            $scope.tAbono = [];


            $scope.tEmpleado = 'empleado';

            var ruta = '';

            $scope.Options = [ ];


            //funcioines que inician la pagina

            getCargos();
            getDepartamentos();



            //traer la data por el click

            $scope.getData = function(){

                var fecha_s_format = $('#reservation').val();
                console.log(fecha_s_format.length);// 0 si es nulo
            };

            $scope.getDataAll = function()
            {

                $scope.cant_error = 0;

                var token = $('#_token').val();

                var nombre = $("#filNombre").val();

                var t_pago = $("#f_tipo_pago").val();


                if ($scope.tEmpleado == 'empleado'){

                    var mes = $("#filMes").val();
                    var anio = $("#filAnio").val();

                    var ultimoDia = new Date(anio,mes, 0);

                    //ultimoDia = ultimoDia.getDate()+'/'+(ultimoDia.getMonth()+1)+'/'+ultimoDia.getFullYear();
                    ultimoDia = ultimoDia.getFullYear()+'-'+(ultimoDia.getMonth()+1)+'-'+ultimoDia.getDate();

                }else{

                    var mes  = $("#filMes").val();
                    var anio = $("#filAnio").val();
                    var dia  = $("#filDia").val();
                    var ultimoDia = anio+'-'+mes+'-'+dia;
                }




                var bandera = validator();


                if(bandera==0){

                    //

                    $('#btnBuscarDoc').attr("disabled", true);

                    $scope.Documentos = [];

                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");
                    //


                    ruta = '{{ URL::route('getTelecredito') }}';

                    $http.post(ruta,
                            {_token : token,
                                periodo:ultimoDia,
                                nombre:nombre,
                                t_pago:t_pago,
                                tipo:$scope.tEmpleado
                            })
                            .success(function(data){

                                console.log(data);

                                $scope.Documentos = data;

                                var suma = 0;
                                angular.forEach($scope.Documentos,function (item) {

                                    suma += parseFloat( item.MONTO);
                                    item.habil = false;

                                    var bandera = reviewError(item);

                                    if(bandera.res==0){
                                        item.e="";
                                        item.e_dni="";
                                        item.e_cuenta="";
                                    }else {
                                        item.e = "error";
                                        if(bandera.dni == 1)
                                        item.e_dni="error";
                                        if(bandera.cuenta == 1)
                                        item.e_cuenta="error";
                                        $scope.cant_error ++;

                                    }
                                });
                                
                                $scope.total_abonado = suma;
                                getCargos();
                                //total_abonado
                               

                                $('#btnBuscarDoc').attr("disabled", false);

                                $( "div" ).remove( ".overlay" );
                                $( "div" ).remove( ".loading-img" );
                            }).error(function(data) {
                                alert("error");
                                console.log(data);
                                $('#btnBuscarDoc').attr("disabled", false);
                                $("div").remove(".overlay");
                                $("div").remove(".loading-img");
                    });

                }else{
                    alert("Llene los campos obligatorios");
                }


            };

            $scope.fnOptions = function () {
                return $q(function (resolve, reject) {
                    $timeout(function () {
                        resolve([$scope.searchFilter + '1', $scope.searchFilter + '2'])
                    }, 1000);
                });
            };

            function getCargos() {

                $http.get('{{ URL::route('getCargos') }}')
                        .success(function(data){

                            $scope.cargos = data;
                        }).error(function(data) {
                    console.log('Error cargos'+data);
                });

            }

            function getDepartamentos() {

                $http.get('{{ URL::route('getDepartamentos') }}')
                        .success(function(data){

                            $scope.departamentos = data;
                        }).error(function(data) {
                    console.log('Error departamentos'+data);
                });

            }

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

            $scope.allSelect = function () {

                angular.forEach($scope.Documentos,function (item,key) {

                    $scope.Documentos[key].habil = $scope.a;
                });
                /*
                if($scope.a==1){
                    //si es que es uno entonces llenamos todos los datos para el hidden y poder filtrar
                    fillHidData();
                }else{
                    $("#data_include").val();
                }
                */
                getAbonado();
            };

            $scope.changeHabil = function (index) {


                if($scope.Documentos[index].habil == 0){
                    $scope.Documentos[index].habil = 1;
                }else {
                    $scope.Documentos[index].habil = 0;
                }

                //cambio el estado
                getAbonado();
            };
            
            function fillHidData() {

                var valores ="";
                $("#data_include").val();

                angular.forEach($scope.Documentos,function (item,key) {

                    if($scope.Documentos.length == (key+1)){
                        valores += item.DNI;

                    }else{
                        valores += item.DNI+',';
                    }


                });

                $("#data_include").val(valores);
            }

            function getAbonado() {

                $scope.total_abonado = 0;
                var suma = 0;

                angular.forEach($scope.Documentos,function (item,key) {

                    if(item.habil == 1){
                        suma += parseFloat(item.MONTO);
                    }


                });


                $scope.total_abonado = suma;

            }

            $("#frmFiltro").submit(function (e) {

                e.preventDefault();
                
                var data_include = getHabilHaber();
                var data_with_error = getErrorInHabil();


                if(data_include.length >0 && data_with_error.length <1){

                    $.ajax({
                        url: "{{ URL::route('txt') }}",
                        method: "POST",
                        data: {
                            _token  : $('#_token').val(),
                            filAnio : $("#filAnio").val(),
                            filMes  : $("#filMes").val(),
                            filDia  : $("#filDia").val(),
                            t_pago  : $("#f_tipo_pago").val(),
                            nombre  : '',
                            ref_planilla : $("#ref_planilla").val(),
                            data_include: data_include,
                            tipo    :  $('#t_empleado').val()
                        },
                        success: function(res) {
                            window.location = res;
                            console.log(res);
                        },
                        error: function (res) {
                            console.log("error");
                            console.log(res);
                        }
                    });

                }else{
                    if(data_include.length <=0)
                        alert("Tiene que elegir alguno para descargar el txt");
                    if(data_with_error.length >0)
                        alert("Existe empleados con errores");
                }


            });

            function getHabilHaber() {

                var filters = [];

                angular.forEach($scope.Documentos,function (item,key) {

                  if(item.habil == 1){
                      filters.push(item.DNI);
                  }

                });

                return filters;

            }

            function getErrorInHabil() {

                var filters = [];

                angular.forEach($scope.Documentos,function (item,key) {

                    if(item.habil == 1 && item.e == "error"){
                        filters.push(item.DNI);
                    }

                });

                return filters;

            }

            //-- para los filtros

            $scope.filterCargo = function(i) {

                if ($scope.filcargo.length > 0)

                    if ($scope.filcargo[0] != "")
                        return ($scope.filcargo.indexOf(i.CARGO) != -1);
                    else
                        return true;
                else
                    return true;

            };

            $scope.filterDepartamento = function(i) {

                /*
                if ($scope.fildepartamento.length > 0)

                    if ($scope.fildepartamento[0] != "")
                        return ($scope.fildepartamento == i.DEPARTAMENTO );
                    else
                        return true;
                else
                    return true;

                    */

                if ($scope.fildepartamento == i.DEPARTAMENTO)
                    return true;
                else if($scope.fildepartamento == "")
                    return true;
                else
                    return false;


            };

            $scope.changeAllFilter = function () {

                angular.forEach($scope.filteredItems,function (item,key) {

                    $scope.changeHabil(item.correlativo);
                });

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


            function reviewError(item) {

                var bandera ={
                    res:0,
                    dni:0,
                    cuenta:0
                };

                //validamos su dni

                if( (item.TIPO_DOCUMENTO == 1 && item.DNI.length != 8) ||
                        (item.TIPO_DOCUMENTO == 3 && item.DNI.length != 9)){
                    bandera.res = 1;
                    bandera.dni = 1;
                }

                //validamos cuenta de abono

                if(item.CUENTAS_ABONO.length != 14){
                    bandera.res = 1;
                    bandera.cuenta =1 ;
                }

                return bandera;

            }


            //funciones watch
            $scope.$watch('tEmpleado', function() {
                if($scope.tEmpleado == 'empleado'){
                    var tAbono = [{val:'q',text:'Quincena'},{val:'f',text:'F. Mes'}];
                    $scope.tAbono = tAbono;
                }else{
                    var tAbono = [{val:'s',text:'Semanal'},{val:'l',text:'Liquidacion'}];
                    $scope.tAbono = tAbono;
                }
            });





        });
    </script>

    <style>
        tr[data-style|="error"] { /* data-years attribute starts with 1900 as the only value or first in a dash-separated list */
            background-color: #ff8c6a;
            color: white;
        }
        td[data-style|="error"] { /* data-years attribute starts with 1900 as the only value or first in a dash-separated list */

            color: yellow;
        }

    </style>


@stop