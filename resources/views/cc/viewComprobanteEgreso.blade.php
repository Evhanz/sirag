@extends('layout')

@section('content')

    <div >
        <div class="content"  >
            <div class="row" style="padding-left: 15px; padding-right: 15px;">
                <!-- Box (with bar chart) -->
                <div class="box box-default" >
                    <div class="box-header">
                        <br>
                        <form action="{{route('getComprobanteDeEgresoPdf')}}" method="post" class="form">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <div class="form-group col-xs-3">
                                <label for="">Periodo</label>
                                <select class="form-control" name="periodo" id="periodo" required>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                </select>
                            </div>
                            <div class="form-group col-xs-3">
                                <label for="">Correlativo</label>
                                <input type="number" name="correlativo"  class="form-control" required>
                            </div>
                            <div class="form-group col-xs-3">
                                <label for="">&nbsp;</label><br>
                                <button class="btn btn-warning">Traer Egreso</button>
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