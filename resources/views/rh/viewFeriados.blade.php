@extends('layout')

@section('content-header')

    @if((session('status'))!=null)
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

@stop


@section('content')

    <div >
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">

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

        $("#Registrar").click(function () {

            var token = $("#_token").val();
            var fecha = $("#periodo_agrario").val();
            var ruta = "{{route('regFeriados')}}";

            $.post( ruta,
                    { _token: token,
                       fecha: fecha })
                    .done(function( data ) {
                        console.log(data);
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
        });


    </script>


@endsection