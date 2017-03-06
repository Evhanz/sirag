@extends('layout')

@section('content')

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/fileDownloader/jquery.fileDownload.js') }}"></script>

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#home">Retenciones</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Retenciones</h4>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <div class="col-md-2">
                                                <label for="">Año</label><br>
                                                <select name="" id="anio" class="form-control">
                                                    <option value="">----------</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2011">2011</option>

                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Mes</label><br>
                                                <select name="" id="mes" class="form-control">
                                                    <option value="">----------</option>
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
                                            <div class="col-md-2">
                                                <br>
                                                <button href="" class="btn btn-info" ng-click="getData()" id="btnExportar" >
                                                    <i class="fa fa-search-plus fa-lg"></i> Buscar </button>

                                            </div>

                                            <div class="col-md-5">
                                                <div class="row" style="">
                                                    <div class="col-md-2">
                                                        <label for="">Dia</label>
                                                        <input min="0" max="31" type="number" ng-model="num_dia" style="width: 50px;">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">N° vez</label>
                                                        <input type="number" ng-model="num_veces" ng-init="1" style="width: 50px;">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for=""> </label><br>
                                                        <button class="btn btn-default btn-md" id="btnExportar" ng-click="getTextRetencion()">
                                                            <i class="fa fa-download"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <br><br>

                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="table_data_op1">
                                                        <thead >
                                                        <tr>
                                                            <th>I</th>
                                                            <th>Correlarivo</th>
                                                            <th>Cuenta</th>
                                                            <th>Tipo</th>
                                                            <th>Referencia</th>
                                                            <th>Haber Ingreso</th>
                                                            <th>Fecha</th>
                                                            <th>Número</th>
                                                            <th>Proveedor</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody  ng-repeat=" item in Documentos | filter:search">
                                                        <tr id="tr_Doc_@{{ $index }}">

                                                            <td>@{{$index}}</td>
                                                            <td>@{{ item.CORRELATIVO }}</td>
                                                            <td>@{{ item.AUX_VALOR2 }}</td>
                                                            <td>@{{ item.TIPO_DOCUMENTO }}</td>
                                                            <td>@{{ item.REFERENCIA }}</td>
                                                            <td>@{{ item.HABER_INGRESO | number: 2 }}</td>
                                                            <td>@{{ item.FECHA | limitTo:10 }}</td>

                                                            <td ng-if="item.VALOR4 == '' " >
                                                                <input ng-model="item.tempNDocumento" type="text" ng-keyup = "changeNDocumentos($event,item)">
                                                            </td>
                                                            <td ng-if="item.VALOR4 != '' " >
                                                                <a class="btn btn-warning btn-xs" ng-click="updateNDocumento($index)"> <i class="fa fa-pencil-square"></i> </a> @{{ item.VALOR4 }}
                                                            </td>
                                                            <td>@{{ item.RazonSocial | limitTo:25 }}</td>

                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>



                                    </div>
                                    <!-- Tab filtro documento -->
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


        </div>


        <span id="dnw"> </span>
    </div>

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



        function imprimir()  {

            var fecha = $('input[name="daterange"]').val();

            fecha = fecha.split('-');
            var f_i = changeFormat(fecha[0]);
            var f_f = changeFormat(fecha[1]);

            $(".pvtTable").printThis({
                importCSS: true,
                loadCSS: "{{ asset('css/table_export.css')}}",
                header: "<h2>Reporte de centro de costos del :"+f_i+" al" +f_f+"  </h2>"
            });
        }




        /**/


        var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.Documentos= [{}];
            $scope.tipodocts = [{}];

            $scope.totales = {};

            var ruta = '';


            //funcioines que inician la pagina




            $scope.getData =  function ()
            {

                var token = $('#_token').val();
                var anio  = $('#anio').val();
                var mes  = $('#mes').val();

                var periodo = anio+''+mes;


                if (periodo.length == 6 ) {


                    var ruta = '{{ URL::route('getRetenciones') }}';

                    $('#btnExportar').attr("disabled", true);
                    $scope.Documentos = [];
                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");


                    $http.post(ruta,{_token : token,
                        anio:anio,
                        mes:mes
                    })
                            .success(function(data){
                                $('#btnExportar').attr("disabled", false);
                                console.log(data);
                                $scope.Documentos = data;

                            }).error(function(data) {
                        $('#btnExportar').attr("disabled", false);
                        console.log(data);
                        $("#box_maestro").remove(".overlay");
                        $("#box_maestro").remove(".loading-img");
                    });

                } else {

                    alert("Se tiene que ingresar , Año y mes");

                }
            };



            $scope.exportExcelCompras = function () {


                alert('llego');

                $('#btnExportExcel').attr("disabled", true);

                var anio  = $('#anio').val();
                var mes  = $('#mes').val();

                var periodo = anio+''+mes;

                var url = '{{ URL::route('modContabilidad') }}/excel/pdbExcelCompras/'+periodo;
                window.location = url;

                $('#btnExportExcel').attr("disabled", false);

            };

            $scope.changeNDocumentos = function (evento,item) {

                var nDocumento = item.tempNDocumento;
                var correlativo = item.CORRELATIVO;

                if(evento.keyCode == 13){

                    //si le da enter actualizar el campo

                    var r = confirm("Desea actualizar el numero de comprobante");
                    if (r == true) {

                        var token = $('#_token').val();
                        var ruta =  '{{URL::route('updateRetencion')}}';

                        $http.post(ruta,{
                            _token:token,
                            item:item
                        }).success(function (data) {

                            alert('Se cambio los valores con éxito: '+data);

                            angular.forEach($scope.Documentos, function(value, key) {

                                if(value.CORRELATIVO == correlativo){
                                    value.VALOR4 = item.tempNDocumento
                                }

                            });
                            console.log(data);
                        }).error(function (data) {
                            console.log(data);
                        });

                    } else {

                    }



                }else
                {
                    angular.forEach($scope.Documentos, function(value, key) {

                        if(value.CORRELATIVO == correlativo){
                            value.tempNDocumento = item.tempNDocumento
                        }

                    });

                }

            };

            $scope.updateNDocumento = function (index){

                var nDocumento = $scope.Documentos[index].VALOR4 ;
                var correlativo = $scope.Documentos[index].CORRELATIVO ;



                angular.forEach($scope.Documentos, function(value, key) {

                    if(value.CORRELATIVO == correlativo){
                        value.VALOR4 = '';
                        value.tempNDocumento = nDocumento;
                    }

                });


            };


            $scope.getTextRetencion = function () {


                var token = $('#_token').val();
                var anio  = $('#anio').val();
                var mes  = $('#mes').val();
                var dia = $scope.num_dia;

                var periodo = anio+'-'+mes+'-'+dia;


                if (periodo.length > 7 ) {


                    var ruta = '{{ URL::route('buildTxtRetenciones') }}';

                    $('#btnExportar').attr("disabled", true);
                    $scope.Documentos = [];
                    $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                    var num_veces = num_veces;


                    $http.post(ruta,{
                        _token : token,
                        fecha:periodo,
                        num_veces:num_veces
                    })
                            .success(function(data){
                                $('#btnExportar').attr("disabled", false);
                               // console.log(data);
                                var url = '{{ URL::route('modContabilidad') }}/txt/getTxtRetenciones/'+data.file;
                                window.location = url;

                            }).error(function(data) {
                        $('#btnExportar').attr("disabled", false);
                        console.log(data);
                        $("#box_maestro").remove(".overlay");
                        $("#box_maestro").remove(".loading-img");
                    });

                } else {

                    alert("Se tiene que ingresar , Año Mes y dia ");

                }





            };






            /*funcion helper de d/m/a  a a/M/D*/


            function changeFormat(fecha) {
                // body...

                fecha = fecha.split("/");
                fecha = fecha[2].trim()+"-"+fecha[1].trim()+"-"+fecha[0].trim();
                return fecha;

            }




        });
    </script>


@stop