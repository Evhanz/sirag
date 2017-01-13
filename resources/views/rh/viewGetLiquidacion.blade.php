@extends('layout')

@section('content')

    <div >
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <form action="{{route('getLiquidacion')}}" method="post" class="form">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <div class="form-group col-xs-3">
                                <label for="">Fecha</label>
                                <input name="fecha" id="periodo_agrario" class="form-control datepicker" required>
                            </div>
                            <div class="form-group col-xs-3">
                                <label for="">&nbsp;</label><br>
                                <button class="btn btn-warning">Traer Liquidaciones</button>
                            </div>
                        </form>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="row" style="padding-left: 15px;">

                        </div><!-- /.row - inside box -->
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
    </script>


@endsection