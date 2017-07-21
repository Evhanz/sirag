@extends('layouts/packing')

@section('header')
    <h1>
        Registro de Etiquetas
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All</li>
    </ol>

    @if (session('status'))

        <script>
            alert('Resultado: {{ session('status') }}');
        </script>

    @endif

@stop

@section('head_options')
@stop

@section('content')

    <!-- Row Filter-->
    <div class="row" id="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Cajas</h3>
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
                    <div class="col-lg-12">
                        <form class="form-inline" action="{{route('regCodigoCaja')}}" method="post" id="form">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label for="exampleInputName2">Desde</label><br>
                                <input  id="desde" type="text" class="form-control" name="desde" value="{{$max_codigo}}"  readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Hasta</label><br>
                                <input id="hasta" type="text" class="form-control" name="hasta" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Cantidad</label><br>
                                <input id="cantidad" type="number" class="form-control" name="cantidad" required>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="exampleInputName2">Calibre</label><br>
                                <select id="calibre" class="form-control sels" name="calibre" required>
                                    <option value="">---------------</option>
                                    @foreach($calibre as $item)
                                        <option value="{{$item->CODIGO}}">{{$item->CODIGO}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">Tipo Caja</label><br>
                                <select name="tipo_caja" id="tipo_caja" class="form-control sels" required>
                                    <option value="">---------------</option>
                                    @foreach($tipo_caja as $item)
                                        <option value="{{$item->CODIGO}}">{{$item->CODIGO}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">Tipo Uva</label><br>
                                <select name="tipo_uva" id="tipo_uva" class="form-control sels" required>
                                    <option value="">---------------</option>
                                    @foreach($uva as $item)
                                        <option value="{{$item->CODIGO}}">{{$item->CODIGO}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName2">Lote</label><br>
                                <input name="lote" id="lote" class="form-control sels" required/>
                            </div>
                            <hr>

                            <div class="form-group">
                                <a id="send" class="btn btn-success">
                                    <i class="fa fa-cogs" > Registrar</i>
                                </a>
                            </div>

                            <div class="form-group">
                                <p><i>* Cuando se realiza el proceso , considerar que no se puede deshacer el mismo , y los códigos que
                                    no se utilicen, se quedaran desactivados , sin perjudicar el proceso</i></p>
                            </div>



                        </form>

                    </div>






                </div>

                <br>

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

    <style>
        .form-group{
            margin-right: 20px;
        }
        .sels{
            width: 180px !important;
        }
    </style>

    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('templates/lte2/plugins/select2/select2.min.css')}}">

    <!-- Select2 -->
    <script src="{{asset('templates/lte2/plugins/select2/select2.full.min.js')}}"></script>
    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker/daterangepicker-bs3.css')}}">
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(".select2").select2();

        $('input[name="fecha"]').daterangepicker({
            format : "DD/MM/YYYY"
        });


        $("#btnGetCodigo").click(function (e) {

            var codigo = $("#codigoEtapa").val();

            window.location.replace("{{route('modPacking')}}/etapa/viewEtapaByCodigo/"+codigo);

        });


        $("#codigoEtapa").keyup(function(e){
            var code = e.which; // recommended to use e.which, it's normalized across browsers
            if(code===13){
                e.preventDefault();
                var codigo = $("#codigoEtapa").val();

                window.location.replace("{{route('modPacking')}}/etapa/viewEtapaByCodigo/"+codigo);

            }

        });


        $("#cantidad").on("change paste keyup", function() {
           // alert($(this).val());
            var desde = $("#desde").val();

            if($("#cantidad").val() !== ''){
                var hasta = parseInt(desde)+parseInt($("#cantidad").val());
                $("#hasta").val(hasta-1);
            }else{
                $("#hasta").val(null);
            }


        });

        $("#send").click(function (e) {
            e.preventDefault();
            var res = confirm('Continuar con el proceso ? ');
            if(res){
                var bandera = validateForm();
                if(bandera === 0)  $("#form").submit();
                else alert('ingresa todos los valores');
            }

        });
        
        
        function validateForm() {

            var bandera = 0 ;

            if($('#hasta').val() === ''){
                bandera = 1;
            }
            if($('#cantidad').val() === ''|| $('#cantidad').val() <= 0){
                bandera = 1;
            }
            if($('#calibre').val() === ''){
                bandera = 1;
            }
            if($('#tipo_caja').val() === ''){
                bandera = 1;
            }
            if($('#tipo_uva').val() === ''){
                bandera = 1;
            }
            if($('#lote').val() === ''){
                bandera = 1;
            }


            return bandera;



        }



    </script>



@stop