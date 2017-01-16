@extends('layout')

@section('content')

    <div >
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <form action="{{route('getExcelAFPNet')}}" method="post" class="form">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <div class="form-group col-xs-3">
                                <label for="" >Año</label><br>
                                <select name="anio" class="form-control" id="anio" required>
                                    <option value="">--------</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                </select>
                            </div>
                            <div class="form-group col-xs-3">
                                <label for="" >Mes</label><br>
                                <select name="mes" class="form-control" id="mes" required>
                                    <option value="">--------</option>
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
                            <div class="form-group col-xs-3">
                                <label for="">&nbsp;</label><br>
                                <button class="btn btn-success">Traer Excel</button>
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