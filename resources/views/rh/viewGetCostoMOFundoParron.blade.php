@extends('layout')

@section('content')

    <div >
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <form id="form" action="{{route('getExcelCostoMOPorFundo')}}" method="post" class="form">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <div class="form-group col-xs-3">
                                <label for="">Fecha</label>
                                <input name="fecha" id="periodo_agrario" class="form-control datepicker" required>
                            </div>
                            <div class="form-group col-xs-2">
                                <label for="">&nbsp;</label><br>
                                <button id="send" class="btn btn-success">Traer Costo Mano de Obra</button>
                            </div>
                            <div class="form-group col-xs-1">
                                <label for="">&nbsp;</label><br>
                                <label id="refresh" class="btn btn-info">
                                    <i class="fa fa-refresh"></i>
                                </label>
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




    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- datepicker -->
    <script src="{{asset('templates/lte2/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/datepicker/datepicker3.css')}}">
    <script>

        $('#periodo_agrario').daterangepicker({
            format : "DD/MM/YYYY"
        });

        /*
        $('#periodo_agrario').datepicker({
            format: 'dd/mm/yyyy'
        });

        */

        $( "#form" ).submit(function( event ) {
           // alert( "Handler for .submit() called." );
           // event.preventDefault();
            $('#send').attr("disabled", true);
        });

        $( "#refresh" ).click(function( event ) {
            // alert( "Handler for .submit() called." );
            // event.preventDefault();
            $('#send').attr("disabled", false);
        });



    </script>


@endsection