@extends('layouts/packing')

@section('header')
    <h1>
        Etapas de packing
        <small>Selección</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All</li>
    </ol>

@stop

@section('head_options')
@stop

@section('content')

    <!-- Row Filter-->
    <div class="row">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Etapa de Selección </h3>
                <!--
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row">

                    <form action="{{route('apiSeleccionReg')}}" method="post">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                        <div class="col-md-6 col-md-offset-3">

                            <div class="row">
                                <div class="col-xs-12">
                                    <h3>Código de Barras <i class="fa fa-barcode"></i> </h3>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-xs-12">
                                    <input class="form-control input-lg" type="text" required>
                                </div>

                                <!--
                                <div class="col-xs-2">
                                    <a class="btn bg-olive btn-flat btn-lg pull-right">
                                        <i class="fa  fa-search "></i>
                                    </a>
                                </div>
                                -->

                            </div>
                            <br>

                            <div class="row">
                                <div class="col-xs-6">
                                    <label for="uva">Uva</label>
                                    <select class="form-control" name="uva" id="uva" required>
                                        <option value="Red Globe">Red Globe</option>
                                        <option value="Crimson">Crimson</option>
                                        <option value="otro">Otro</option>
                                    </select>

                                </div>
                                <div class="col-xs-6">
                                    <label for="calibre">Calibre</label>
                                    <select class="form-control" name="calibre" id="calibre" required>
                                        <option value="12">12</option>
                                        <option value="11">11</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>

                            </div>

                            <br>

                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-block btn-success btn-lg">
                                        <i class="fa fa-save "></i> Guardar
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

            </div>
        </div>
        <!-- /.box -->

    </div>
    <!-- /.row (Row Filter) -->

    <!-- Row Data-->
    <div class="row">

    </div>
    <!-- /.row (Row Data) -->


@stop

@section('scripts')

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/select2/select2.min.css')}}">

    <!-- Select2 -->
    <script src="{{asset('templates/lte2/plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(".select2").select2();
    </script>

@stop