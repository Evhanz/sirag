@extends('layout')

@section('content')


    <script type="text/javascript" src="{{ asset('js/plugins/table2excel/jquery.table2excel.min.js') }} "></script>
    <link href="{{ asset('js/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }} " />
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.js') }} "></script>

    <div ng-app="app" ng-controller="PruebaController">
        <div class="content"  >

            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#salidas">Salidas</a></li>
                            <li><a data-toggle="tab" href="#cci">CCI</a></li>
                            <li><a data-toggle="tab" href="#valorizado">Valorizado</a></li>
                           <!-- <li ><a data-toggle="tab" href="#entradas">Entradas</a></li>-->

                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">
                            <div class="col-lg-12">
                                <div class="tab-content">
                                    <!-- Tab filtro producto -->
                                    <div id="salidas" class="tab-pane fade in active">
                                        <!--Filtro Principal de productos-->
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <form class="form-inline" style="padding: 15px">

                                                <div class="col-xs-3">
                                                    <label>Rango de Fechas</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control " name="daterange" id="reservation" type="text">
                                                    </div><!-- /.input group -->
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="" >Familia </label><br>
                                                    <select class="form-control" ng-model="familiaFilter" id="f_familia" ng-init="familiaFilter='MATERIA PRIMA'">
                                                        <option value="">---------</option>
                                                        <option ng-repeat="familia in familias "
                                                                value="@{{familia.CODIGO}}">
                                                            @{{familia.CODIGO}}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-3">
                                                    <div class="form-group">
                                                        <label for="" >Sub Familia</label><br>
                                                        <select class="form-control" ng-model="subFamilia" id="f_subfamilia">
                                                            <option value="">---------</option>
                                                            <option ng-repeat="item in subfamilias | filter:familiaFilter"
                                                                    value="@{{item.CODIGO}}">
                                                                @{{item.CODIGO}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-xs-2">
                                                    <label for="">Producto</label>
                                                    <input class="form-control" type="text" ng-keyup="$event.keyCode == 13 && getProduct()" ng-model="producto_glosa">
                                                </div>

                                                

                                                <div class="col-xs-1">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a href="" class="btn btn-info" ng-click="getProduct()">
                                                       <i class="fa fa-search"></i>
                                                    </a>

                                                </div>

                                            </form>
                                        </div>
                                        <br><br>
                                        <!--./ Filro Principal-->
                                        <!-- data procesada  -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <!-- Box (with bar chart) -->
                                                <div class="box box-info" id="box_maestro">
                                                    <div class="box-header">

                                                        <div class="row">

                                                            <div class="col-xs-1  col-md-offset-11">
                                                                <button class="btn btn-success btn-xs" title="Exportar Excel" onclick="printPrincipal()">
                                                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row" style="padding: 15px;font-size: 11px;">
                                                            <div class="col-lg-12">
                                                                <table class="table table-bordered table-hover" id="table_data_op1">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>i</th>
                                                                        <th>GLOSA</th>
                                                                        <th>UNIDAD</th>
                                                                        <th>SALDO INICIAL</th>
                                                                        <th>COMPRAS</th>
                                                                        <th>CONSUMO</th>
                                                                        <th>SALDO FINAL</th>
                                                                        <th>*</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody  ng-repeat=" item in ProductosDTO | filter:search">
                                                                    <tr id="tr_Doc_@{{ $index }}">
                                                                        <td>@{{ $index + 1 }}</td>
                                                                        <td>@{{ item.producto_name }}</td>
                                                                        <td>@{{ item.unidad }}</td>
                                                                        <td>@{{ item.saldo_inicial }}</td>
                                                                        <td>@{{ item.total_entrada }}</td>
                                                                        <td>@{{ item.total_salidas }}</td>
                                                                        <td>@{{ item.saldo_final }}</td>

                                                                        <td>
                                                                            <a class="btn btn-default" ng-click="viewDetalle(item)">
                                                                                <i class="fa fa-bullseye"></i>
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
                                            <!-- ./ panel izquierdo -->

                                            <div class="col-lg-6">

                                             <!-- Box (with bar chart) -->
                                                <div class="box box-info" id="box_maestro">
                                                    <div class="box-header">
                                                         <div class="row">

                                                             <div class="col-xs-4" style="padding-left: 20px;">
                                                                 <h3>Saldo Inicial: @{{ saldo_inicial_selected | number:3 }}</h3>
                                                             </div>

                                                             <div class="col-xs-2  col-md-offset-6">
                                                                 <button class="btn btn-success btn-xs" title="Exportar Excel" onclick="printSecundario()" style="margin-left: 15px;">
                                                                     <i class="fa fa-file-excel-o" ></i>
                                                                 </button>
                                                             </div>
                                                         </div>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row" style="padding: 15px;font-size: 11px">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="table_data_op2">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>*</th>
                                                                        <th>Fecha</th>
                                                                        <th>Tipo</th>
                                                                        <th>Producto</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Saldo</th>
                                                                        <th>C.C.I.</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody  ng-repeat=" item in detalles | filter:search">
                                                                    <tr >
                                                                        <td>@{{ $index }}</td>
                                                                        <td>@{{ item.fecha   }}</td>
                                                                        <td>@{{ item.tipo }}</td>
                                                                        <td>@{{ item.glosa }}</td>
                                                                        <td>@{{ item.cantidad | number:3 }}</td>
                                                                        <td>@{{ item.saldo }}</td>
                                                                        <td>@{{ item.FUNDO_PARRON }}</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.row - inside box -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->
                            


                                                
                                            </div><!--detalle de la data -->


                                        </div>
                                        <!-- ./data procesada  -->
                                    </div>
                                    <!-- Tab filtro proveedor -->
                                    <div id="entradas" class="tab-pane fade">
                                        <!--Filtro Principal de productos-->
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <form class="form-inline" style="padding: 15px">

                                                <div class="col-xs-3">
                                                    <label>Rango de Fechas</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control " name="daterange" id="reservationEntrada" type="text">
                                                    </div><!-- /.input group -->
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="" >Familia </label><br>
                                                    <select class="form-control" ng-model="familiaFilterEntrada" id="f_familia_entrada" ng-init="familiaFilterEntrada='MATERIA PRIMA'">
                                                        <option value="">---------</option>
                                                        <option ng-repeat="familia in familias "
                                                                value="@{{familia.CODIGO}}">
                                                            @{{familia.CODIGO}}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="">Producto</label>
                                                    <input class="form-control" type="text"  ng-model="producto_glosa_entrada">
                                                </div>



                                                <div class="col-xs-2">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a href="" class="btn btn-info" ng-click="getProductEntrada()">
                                                        Buscar <i class="fa fa-search"></i>
                                                    </a>

                                                </div>


                                            </form>
                                        </div>
                                        <br><br>
                                        <!--./ Filro Principal-->
                                        <!-- data procesada  -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <!-- Box (with bar chart) -->
                                                <div class="box box-info" id="box_maestro">
                                                    <div class="box-header">

                                                        <div class="row">

                                                            <div class="col-xs-1  col-md-offset-11">
                                                                <button class="btn btn-success btn-xs" title="Exportar Excel" onclick="printExcel('1')">
                                                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row" style="padding: 15px">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover" id="table_data_op1" data-id="1">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>i</th>
                                                                        <th>GLOSA</th>
                                                                        <th>SALDO ACTUAL</th>
                                                                        <th>UNIDAD</th>
                                                                        <th>*</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody  ng-repeat=" item in ProductosDTOEntrada | filter:search">
                                                                    <tr id="tr_Doc_@{{ $index }}">
                                                                        <td>@{{ $index }}</td>
                                                                        <td>@{{ item.producto_name }}</td>
                                                                        <td>@{{ item.unidad }}</td>
                                                                        <td>@{{ item.saldo_final }}</td>
                                                                        <td>
                                                                            <a class="btn btn-default" ng-click="viewDetalleEntrada(item)">
                                                                                <i class="fa fa-bullseye"></i>
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

                                            <div class="col-lg-6">

                                                <!-- Box (with bar chart) -->
                                                <div class="box box-info" id="box_maestro">
                                                    <div class="box-header">
                                                        <div class="row">

                                                            <div class="col-xs-2  col-md-offset-10">
                                                                <button class="btn btn-success btn-xs" title="Exportar Excel" onclick="printExcel('2')" style="margin-left: 15px;">
                                                                    <i class="fa fa-file-excel-o" ></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.box-header -->
                                                    <div class="box-body ">

                                                        <div class="row" style="padding: 15px">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="table_data_op2" data-id="2">
                                                                    <thead >
                                                                    <tr>
                                                                        <th>*</th>
                                                                        <th>Num. Doc</th>
                                                                        <th>Fecha</th>
                                                                        <th>Producto</th>
                                                                        <th>Cantidad</th>
                                                                        <th>Unidad</th>
                                                                    </tr>

                                                                    </thead>
                                                                    <tbody  ng-repeat=" item in detallesEntrada | filter:search">
                                                                    <tr >
                                                                        <td>@{{ $index }}</td>
                                                                        <td>@{{ item.numero }}</td>
                                                                        <td>@{{ item.fecha   }}</td>
                                                                        <td>@{{ item.glosa }}</td>
                                                                        <td>@{{ item.cantidad | number:2}}</td>
                                                                        <td>@{{ item.unidad }}</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.row - inside box -->
                                                    </div><!-- /.box-body -->
                                                </div><!-- /.box -->




                                            </div><!--detalle de la data -->


                                        </div>
                                    </div>
                                    <div id="cci" class="tab-pane fade">
                                        <div class="row">
                                            <form id="formExcelCCI" class="form-inline" style="padding: 15px" action="{{route('excelConsumoPorCCI')}}" method="post">
                                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                                <div class="col-xs-3">
                                                    <label>Rango de Fechas</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control " name="daterange" id="reservation" type="text">
                                                    </div><!-- /.input group -->
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="" >Familia </label><br>
                                                    <select class="form-control" name="familia" ng-model="familiaFilter" id="f_familia" ng-init="familiaFilter='MATERIA PRIMA'">
                                                        <option value="">---------</option>
                                                        <option ng-repeat="familia in familias "
                                                                value="@{{familia.CODIGO}}">
                                                            @{{familia.CODIGO}}
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-xs-2">
                                                    <div class="form-group">
                                                        <label for="" >Sub Familia</label><br>
                                                        <select name="subFamilia" class="form-control" ng-model="subFamilia" id="f_subfamilia">
                                                            <option value="">---------</option>
                                                            <option ng-repeat="item in subfamilias | filter:familiaFilter"
                                                                    value="@{{item.CODIGO}}">
                                                                @{{item.CODIGO}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xs-2">
                                                    <label for="">CCI</label>
                                                    <div class="ccis" >
                                                        <input name="tags" class="form-control" type="text"  ng-model="cci" data-role="tagsinput" >
                                                    </div>
                                                </div>
                                                <div class="col-xs-1">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a id="bntExcelCCI" ng-click="getExcelCCI()" href="" class="btn btn-success">
                                                        Generar <i class="fa fa-file-excel-o"></i>
                                                    </a>

                                                </div>
                                                <div class="col-xs-1">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a href="" class="btn btn-info" ng-click="refreshCCI()">
                                                        <i class="fa fa-refresh"></i>
                                                    </a>

                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div id="valorizado" class="tab-pane fade">
                                        <div class="row">
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}" />
                                            <form class="form-inline" style="padding: 15px">

                                                <div class="col-xs-3">
                                                    <label>Rango de Fechas</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input class="form-control " name="daterange" id="fecha_valorizado" type="text">
                                                    </div><!-- /.input group -->
                                                </div>

                                                <!--
                                                <div class="col-xs-1">
                                                    <label>Periodo</label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="" id="mesPeriodo" >
                                                            <option value="01" selected>Enero</option>
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

                                                </div>

                                                <div class="col-xs-1">
                                                    <label>&nbsp;</label>
                                                    <div class="input-group">
                                                        <select class="form-control" name="" id="anioPeriodo">
                                                            <option value="2017" selected>2017</option>
                                                            <option value="2016">2016</option>
                                                            <option value="2015">2015</option>
                                                            <option value="2014">2014</option>
                                                            <option value="2013">2013</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                -->

                                                <div class="col-xs-3">
                                                    <label for="" >Familia </label><br>
                                                    <select class="form-control" ng-model="familiaFilter" id="f_familia" ng-init="familiaFilter='MATERIA PRIMA'">
                                                        <option value="">---------</option>
                                                        <option ng-repeat="familia in familias "
                                                                value="@{{familia.CODIGO}}">
                                                            @{{familia.CODIGO}}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-2">
                                                    <div class="form-group">
                                                        <label for="" >Sub Familia</label><br>
                                                        <select class="form-control" ng-model="subFamilia" id="f_subfamilia">
                                                            <option value="">---------</option>
                                                            <option ng-repeat="item in subfamilias | filter:familiaFilter"
                                                                    value="@{{item.CODIGO}}">
                                                                @{{item.CODIGO}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-xs-2">
                                                    <label for="">Producto</label>
                                                    <input class="form-control" type="text" ng-keyup="$event.keyCode == 13 && getKardexValorizado()" ng-model="producto_glosa">
                                                </div>

                                                <div class="col-xs-1">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a href="" id="btn_getKardex_valorizado" class="btn btn-info" ng-click="getKardexValorizado()">
                                                        <i class="fa fa-search"></i>
                                                        <span class="mensaje_cargando"> <i class="fa fa-spinner fa-spin  fa-fw"></i></span>
                                                    </a>
                                                </div>

                                                <div class="col-xs-1">
                                                    <label for="" style="margin-bottom: 20px"> </label><br>
                                                    <a href="" id="" class="btn btn-success" onclick="printValorizado()">
                                                        <i class="fa fa-file-excel-o"></i>
                                                    </a>
                                                </div>


                                            </form>
                                        </div>

                                        <br><br>

                                        <div class="row" >
                                            <div class="col-xs-12 table-responsive" style="font-size: 11px;">
                                                <table class="table table-bordered" id="table_kardex">
                                                    <thead >
                                                    <tr>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" rowspan="2">*</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" rowspan="2">Glosa</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" rowspan="2">Costo U.</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" colspan="2">Salida Inicial</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" colspan="2">Compras</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" colspan="2">Req. Mes Anterior</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" colspan="2">Consumo</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" colspan="2">Saldo Final</th>
                                                        <th style="background-color: #2b688c;color:white; font-size: 14px;" rowspan="2">Resultado</th>
                                                    </tr>
                                                    <tr>
                                                        <td>Q</td>
                                                        <td>S/. TOTAL</td>
                                                        <td>Q</td>
                                                        <td>S/. TOTAL</td>
                                                        <td>Q</td>
                                                        <td>S/. TOTAL</td>
                                                        <td>Q</td>
                                                        <td>S/. TOTAL</td>
                                                        <td>Q</td>
                                                        <td>S/. TOTAL</td>
                                                    </tr>

                                                    </thead>
                                                    <tbody  ng-repeat=" item in kardex | filter:search">
                                                    <tr >
                                                        <td>@{{ $index }}</td>
                                                        <td>@{{ item.producto_name }}</td>
                                                        <td style="text-align: right">@{{ item.costo }}</td>
                                                        <td style="text-align: right">@{{ item.saldo_inicial }}</td>
                                                        <td style="text-align: right">@{{ item.saldo_inicial * item.costo | number:2}}</td>
                                                        <td style="text-align: right">@{{ item.total_entrada }}</td>
                                                        <td style="text-align: right">@{{ item.total_entrada * item.costo | number:2}}</td>
                                                        <td style="text-align: right">@{{ item.requerimiento }}</td>
                                                        <td style="text-align: right">@{{ item.requerimiento * item.costo | number:2}}</td>
                                                        <td style="text-align: right">@{{ item.total_salidas }}</td>
                                                        <td style="text-align: right">@{{ item.total_salidas * item.costo | number:2}}</td>
                                                        <td style="text-align: right">@{{ item.saldo_final }}</td>
                                                        <td style="text-align: right">@{{ item.saldo_final * item.costo | number:2}}</td>
                                                        <td style="text-align: right" class="res-@{{ item.res }}">@{{ item.res_cuntificado }}</td>
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


                <div class="col-lg-12">



                </div>
            </div>




        </div>
    </div>

    <div class="cont-temp"></div>


    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <script>

        /*funciones de jquery*/

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });

        $(".mensaje_cargando").hide();


        /*----*/



        function printSecundario() {
            
            $("#table_data_op2").table2excel({
                exclude: ".noExl",
                name: "tabla_detalle",
                filename: "tabla_detalle",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });

        }

        function printPrincipal() {
            // body...

             $("#table_data_op1").table2excel({
                exclude: ".noExl",
                name: "tabla_general",
                filename: "tabla_general",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        }

        function printValorizado() {
            // body...

            $("#table_kardex").table2excel({
                exclude: ".noExl",
                name: "tabla_general",
                filename: "tabla_general",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        }



        function printExcel(id) {

            var selector = "*[data-id='"+id+"']";

           console.log(selector);


                    
             $(selector).table2excel({
                exclude: ".noExl",
                name: "tabla_general",
                filename: "tabla_general",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true
            });
        }



            
                  

        var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

            $scope.s = "a";
            //Declaraciones

            $scope.detalles             =   [];
            $scope.detallesEntrada      =   [];
            $scope.familias             =   [];
            $scope.ProductosDTO         =   [];
            $scope.ProductosDTOEntrada  =   [];
            $scope.saldo_inicial_selected = 0;

            $scope.proveedores  =   [];
            $scope.prov_active  =   {};
            $scope.prod_provee  =   [];
            $scope.kardex       =   [];




            //funcioines que inician la pagina
            getAllFamilias();

            getAllSubFamilias();
           

            //traer la data por el click

            $scope.getProduct = function () {
                var token = $('#_token').val();

                /*--- Procedimiento que se haga mientras no termine  */




                $scope.search = {};
                $scope.ProductosDTO = [];

                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                /*-----------------*/

                // console.log($scope.TipoDoct);
                if($scope.producto_glosa == null || $scope.producto_glosa.length == 0){

                    $scope.producto_glosa = '';
                }
                if($scope.familiaFilter == null || $scope.familiaFilter.length == 0){

                    $scope.familiaFilter = '';
                }


                if ( $("#reservation").val().length > 0 ) {



                    var fecha_s_format = $("#reservation").val().split('-');

                    //se cambia a este formato por que es lo que se necesita por el sql server y el hdp que hizo flexline
                    var f_i = formatDateDMYtoYDM(fecha_s_format[0],"/");
                    var f_f = formatDateDMYtoYDM(fecha_s_format[1],"/");

                    var ruta = '{{ URL::route('api_getKardex') }}';

                     $http.post(ruta,
                        {   _token : token,
                            producto: $scope.producto_glosa,
                            f_i: f_i,
                            f_f: f_f,
                            familia:$scope.familiaFilter,
                            subFamilia:$scope.subFamilia

                        })
                        .success(function(data){

                            $scope.ProductosDTO = data;

                           // console.log(data);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                            console.log(data);
                            alert("Error _>");
                            $("div").remove(".overlay");
                            $("div").remove(".loading-img");
                        });


                } else {



                    alert("El campo de fecha es obligatorio");
                }


            };


            $scope.getKardexValorizado = function () {
                var token = $('#_token').val();

                /*--- Procedimiento que se haga mientras no termine  */

                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                /*-----------------*/

                // console.log($scope.TipoDoct);
                if($scope.producto_glosa == null || $scope.producto_glosa.length == 0){

                    $scope.producto_glosa = '';
                }
                if($scope.familiaFilter == null || $scope.familiaFilter.length == 0){

                    $scope.familiaFilter = '';
                }


                /*esto se comento 06/06/2017*/

                /*
                var periodo = $("#anioPeriodo").val()+''+$("#mesPeriodo").val();
                var f_i = periodo+''+'01';
                var f_f = new Date($("#anioPeriodo").val(), $("#mesPeriodo").val(), 0);
                 f_f = periodo+''+f_f.getDate();
                */
                //---------

                /*se obtiene por dia mes anio y se necesita anio mes dia*/

                var fecha = $("#fecha_valorizado").val();
                fecha = fecha.split('-');

                var f_i = fecha[0];
                f_i = f_i.trim().split('/');
                f_i = f_i[2]+''+f_i[1]+''+f_i[0];
                var f_f = fecha[1];
                f_f = f_f.trim().split('/');
                f_f = f_f[2]+''+f_f[1]+''+f_f[0];


                console.log(f_i,f_f);
               
                var ruta = '{{ URL::route('getKardexValorizado') }}';

                $("#btn_getKardex_valorizado").prop('disabled',true);
                $(".mensaje_cargando").show();
                $http.post(ruta,
                    {   _token : token,
                        producto: $scope.producto_glosa,
                        f_i: f_i,
                        f_f: f_f,
                        familia:$scope.familiaFilter,
                        subFamilia:$scope.subFamilia
                    })
                    .success(function(data){
                        $scope.kardex = data;
                        //console.log(data);
                        $(".mensaje_cargando").hide();
                        $("#btn_getKardex_valorizado").prop('disabled',false);

                    }).error(function(data) {
                        console.log(data);
                        alert("Error _>");
                        $(".mensaje_cargando").hide();
                        $("#btn_getKardex_valorizado").prop('disabled',false);
                    });



            };




            //reutilizar esta funcion para insertar los detalles

            $scope.viewDetalle = function (item)
            {

                angular.forEach(item.detalle,function (val) {

                    val.fecha = val.fecha.split(" ");
                    val.fecha = formatDateYMDtoDMY(val.fecha[0],'-');

                });

                $scope.saldo_inicial_selected = item.saldo;
                $scope.detalles = item.detalle;


            };

            $scope.viewDetalleEntrada = function (item)
            {

                angular.forEach(item.detalle,function (val) {

                    val.fecha = val.fecha.split(" ");
                    val.fecha = formatDateYMDtoDMY(val.fecha[0],'-');

                });


                $scope.detallesEntrada = item.detalle;


            };

            $scope.getExcelCCI = function () {
                $('#bntExcelCCI').attr("disabled", true);
                $("#formExcelCCI" ).submit();
            };

            $scope.refreshCCI = function () {

                $('#bntExcelCCI').attr("disabled", false);

            };

            $scope.getProductEntrada = function () {
                var token = $('#_token').val();

                /*--- Procedimiento que se haga mientras no termine  */


                $scope.search               = {};
                $scope.ProductosDTOEntrada  = [];

                $("#box_maestro").append("<div class='overlay'></div><div class='loading-img'></div>");

                /*-----------------*/

                // console.log($scope.TipoDoct);
                if($scope.producto_glosa_entrada == null || $scope.producto_glosa_entrada.length == 0){

                    $scope.producto_glosa_entrada = '';
                }
                if($scope.familiaFilterEntrada == null || $scope.familiaFilterEntrada.length == 0){

                    $scope.familiaFilterEntrada = '';
                }


                if ( $("#reservationEntrada").val().length > 0 ) {


                    var fecha_s_format = $("#reservationEntrada").val().split('-');

                    //se cambia a este formato por que es lo que se necesita por el sql server y el hdp que hizo flexline
                    var f_i = formatDateDMYtoYDM(fecha_s_format[0],"/");
                    var f_f = formatDateDMYtoYDM(fecha_s_format[1],"/");

                    var ruta = '{{ URL::route('api_getKardexEntrada') }}';

                    $http.post(ruta,
                        {   _token : token,
                            producto: $scope.producto_glosa_entrada,
                            f_i: f_i,
                            f_f: f_f,
                            familia:$scope.familiaFilterEntrada
                        })
                        .success(function(data){

                            $scope.ProductosDTOEntrada = data;

                            //console.log(data);

                            $( "div" ).remove( ".overlay" );
                            $( "div" ).remove( ".loading-img" );


                        }).error(function(data) {
                        console.log(data);
                        alert("Error _>");
                        $("div").remove(".overlay");
                        $("div").remove(".loading-img");
                    });


                } else {



                    alert("El campo de fecha es obligatorio");
                }


            };



            function getAllFamilias(){

                var ruta = '{{ URL::route('modComercial') }}/api/getAllFamilias';

                $http.get(ruta)
                        .success(function(data){
                            $scope.familias = data;
                        }).error(function (data) {
                            console.log("error en :"+data);
                        });
            }

            function getAllSubFamilias(){

                var ruta = '{{ URL::route('getAllSubFamilias')}}';

                $http.get(ruta)
                    .success(function(data){
                        $scope.subfamilias = data;
                    }).error(function (data) {
                    console.log("error en :"+data);
                });
            }




            /*funcion helper*/


            function formatDateDMYtoMDY(fecha) {

                fecha = fecha.split('/');

                fecha = fecha[1].trim()+"-"+fecha[0].trim()+"-"+fecha[2].trim();

                return fecha;

            }

            function formatDateDMYtoYDM(fecha,separador) {

                fecha = fecha.split(separador);

                fecha = fecha[2]+"-"+fecha[0]+"-"+fecha[1];

                return fecha;

            }

            function formatDateYMDtoDMY(fecha,separador) {

                fecha = fecha.split(separador);

                fecha = fecha[2]+"-"+fecha[1]+"-"+fecha[0];

                return fecha;

            }







            //funcion para exportar en excel










        });
    </script>

    <style type="text/css">
        .bootstrap-tagsinput {
            width: 100%;
        }
        .label {
            line-height: 2 !important;
        }
        .ccis{
            background-color: white;
            padding: 5px ;
            width: 100%;
            line-height: 1.428571429;
            border: 1px solid #ccc;
        }

        .res-positivo{
            background-color: #ef404a;
            color:white;
        }

        .res-negativo{
            background-color: #3e8f3e;
            color:white;
        }

    </style>


@stop