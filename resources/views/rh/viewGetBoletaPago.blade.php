@extends('layout')

@section('content')

    <div >
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="tab_filtros">
                            <li class="active"><a data-toggle="tab" href="#agrario">Agrario</a></li>              
                            <li ><a data-toggle="tab" href="#packing">Packing</a></li>
                        </ul>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">

                        <div class="tab-content">
                            <div id="agrario" class="tab-pane fade in active">
                                <div class="row" style="padding-left: 15px;">
                                    <form action="{{route('getBoletaPago')}}" method="post" class="form">
                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

                                        <div class="form-group col-xs-2">
                                            <label for="">Ficha Agraria</label>
                                            <input name="ficha" id="ficha" class="form-control" >
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label for="">Fecha</label>
                                            <input name="periodo" id="periodo_agrario" class="form-control datepicker" required>
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label for="">&nbsp;</label><br>
                                            <button class="btn btn-warning">Traer Boleta</button>
                                        </div>
                                    </form>
                                </div><!-- /.row - inside box -->
                            </div>
                            <div id="packing" class="tab-pane fade">
                                <div class="row" style="padding-left: 15px;">
                                    <form action="{{route('getBoletaPagoPacking')}}" method="post" class="form">
                                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

                                        <div class="form-group col-xs-2">
                                            <label for="">Ficha Packing</label>
                                            <input name="ficha" id="ficha" class="form-control" >
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label for="">Fecha</label>
                                            <input name="periodo" id="periodo_packing" class="form-control datepicker" required>
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label for="">&nbsp;</label><br>
                                            <button class="btn btn-warning">Traer Boleta</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- /.box-body -->
                    <div class="box-footer">

                    </div><!-- /.box-footer -->
                </div><!-- /.box -->

            </div>
        </div><!--/. content-->
    </div>






    <!-- datepicker -->
    <script src="{{asset('templates/lte2/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/datepicker/datepicker3.css')}}">
    <script>
        $('#periodo_agrario').datepicker({
            format: 'dd/mm/yyyy'
        });
        $('#periodo_packing').datepicker({
            format: 'dd/mm/yyyy'
        });
    </script>


@endsection