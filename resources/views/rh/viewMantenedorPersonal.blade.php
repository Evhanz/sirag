@extends('layout')

@section('content-header')


<h2>Mantenedor de Personal</h2>

@stop

@section('content')


<div id="content" ng-app="app" ng-controller="PruebaController">
	<div class="row" style="padding-left: 15px; padding-right: 15px;margin: 0px;">
		<div class="box box-warning">
			<div class="box-header">
                <ul class="nav nav-tabs" id="tab_filtros">
                	<li class="active"><a data-toggle="tab" href="#personal">Personal</a></li>              
                    <li ><a data-toggle="tab" href="#contractual">Contractual</a></li>
                    <li ><a data-toggle="tab" href="#atributos">Atributos</a></li>
            	</ul>
            </div><!-- /.box-header -->
			<div class="box-body">

				<div class="tab-content">
					<div id="personal" class="tab-pane fade in active">
						<div class="row">
			
							<div class="col-lg-4">
								<label for="funcionario">Ficha</label>
								<input  class="form-control" name="funcionario" type="text" required="">
							</div>

							<div class="col-lg-4">
								<label for="apellidoPaterno">Apellido Paterno</label>
								<input  class="form-control" type="text" name="apellidoPaterno">
							</div>
							<div class="col-lg-4">
								<label for="apellidoMaterno">Apellido Materno</label>
								<input class="form-control" type="text" name="apellidoMaterno">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<label for="codigoLegal">DNI</label>
								<input class="form-control" type="text" name="codigoLegal">
							</div>
							<div class="col-lg-8">
							<label for="nombres">Nombres</label>
								<input class="form-control" type="text" name="nombres">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<label for="fechaNacimiento">Fecha de Nacimiento</label>
								<input class="form-control" type="text" name="fechaNacimiento">
							</div>
							<div class="col-lg-4">
								<label for="estadoCivil">Estado Civil</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in estadoCivil" value="item.DESCRIPCION">@{{item.DESCRIPCION}}</option><!-- CASADO ES "S", VIUDO ES "V" Y SOLTERO ES "S" -->
								</select>
							</div>
							<div class="col-lg-4">
								<label for="sexo">Sexo</label>
								<select class="form-control" name="sexo" id="sexo">
									<option value="Masculino">Masculino</option><!-- Cuando ingresa a BD es "M" -->
									<option value="Femenino">Femenino</option><!-- Cuando ingresa a BD es "F"-->
								</select>
							</div>
						</div>
						<hr>
						<h4><strong>DOMICILIO</strong>	</h4>
						<div class="row">
							<div class="col-lg-8">
								<label for="direccion"><strong>Dirección</strong></label>
								<input  class="form-control" name="direccion" type="text" required="">
							</div>
							<div class="col-lg-4">
								<label for="telefono"><strong>Teléfono</strong></label>
								<input  class="form-control" name="telefono" type="text" required="">
							</div>		
						</div>
						<div class="row">
							<div class="col-lg-3">
								<label for="pais">País</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in paises" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
							<div class="col-lg-3">
								<label for="departamento">Departamento</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in departamento" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
							<div class="col-lg-3">
								<label for="provincia">Provincia</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in provincia" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
							<div class="col-lg-3">
								<label for="distrito">Distrito</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in distrito" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
						</div>
						
					</div>
					<div id="contractual" class="tab-pane fade">
						<h4><strong>CONDICIONES DEL CONTRATO</strong></h4>
						<hr>
						<div class="row">
							<div class="col-lg-4">
								<label for="remuneracion">Remuneración</label>
								<input class="form-control" type="text" name="remuneracion">
							</div>
							<div class="col-lg-4">
								<label for="vigencia">Vigencia</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in vigencia" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
							<div class="col-lg-4">
								<label for="moneda">Moneda</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in moneda" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>							
						</div>
						<div class="row">
							<div class="col-lg-3">
								<label for="area">Departamento</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in area" value="item.NOMBRE">@{{item.NOMBRE}}</option>
								</select>
							</div>
							<div class="col-lg-3">
								<label for="cargo">Cargo</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in cargo" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
							<div class="col-lg-3">
								<label for="categoria">Categoria</label>
								<select name="" id="" class="form-control">
									<option value="">-------</option>
									<option ng-repeat="item in categoria" value="item.CODIGO">@{{item.CODIGO}}</option>
								</select>
							</div>
							<div class="col-lg-3">
								<label for="vacaciones">Vacaciones</label>
								<input class="form-control" type="text" name="vacaciones">
							</div>
						</div>
						<hr>
						<h4><strong>PERIODOS DE CONTRATO</strong></h4>
						<div class="row">
							<div class="col-lg-12" style="padding: 15px">
                        	<div class="table-responsive" style="overflow: auto" id="periodo_tabla">
                            	<table class="table table-bordered" id="periodo_tabla_op1">
                                	<thead >
                                    <tr>
                                    <th>*</th>
                                    <th>Remuneración</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Término</th>
                                    <th>Centro de costo</th>

                                    </tr>
                                    </thead>
                                    <tbody >
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.row - inside box -->
						</div>								
					</div>
					<div id="atributos" class="tab-pane fade">
						<h4><strong>MODALIDAD DE PAGO</strong></h4>
						<hr>
						<div class="row">
							<div class="col-lg-4">
								<label for="cuentaCorriente">Cuenta Corriente</label>
								<input class="form-control" type="text" name="cuentaCorriente">
							</div>
							<div class="col-lg-4">
								<label for="tipoCuenta">Tipo de Cuenta</label>
								<input class="form-control" type="text" name="tipoCuenta">
							</div>
							<div class="col-lg-4">
								<label for="banco">Banco</label>
								<input class="form-control" type="text" name="banco">
							</div>							
						</div>
						<h4><strong>OBSERVACIONES</strong></h4>
						<hr>
						<div class="row">
							<div class="col-lg-12">
								<label for="observaciones">Observaciones</label>
								<input class="form-control" type="text" name="observaciones">
							</div>
						</div>
						<h4><strong>ATRIBUTO DE PERSONAL</strong></h4>
						<hr>
						<div class="row">
							<div class="col-lg-12" style="padding: 15px">
                        	<div class="table-responsive" style="overflow: auto" id="atributo_tabla">
                            	<table class="table table-bordered" id="atributo_tabla_op1">
                                	<thead >
                                    <tr>
                                    <th>*</th>
                                    <th>Atributo</th>
                                    <th>Valor</th>
                                    </tr>
                                    </thead>
                                    <tbody >
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.row - inside box -->	
					</div>
				</div>


				
			</div>

			

		</div>
	</div>
</div>










<script>
	  var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

      
        	$scope.paises = [];
        	var ruta = "";

        	initData();

        	function initData() {
        		// body...
        		//primero llamamos pais
        		ruta =  "{{route('modRH')}}/api/getGentabcod/pais";
        		
        		$http.get(ruta).success(function(data){

        			$scope.paises=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });


                ruta =  "{{route('modRH')}}/api/getGentabcod/departamento";
        		
        		$http.get(ruta).success(function(data){

        			$scope.departamento=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/provincia";
        		
        		$http.get(ruta).success(function(data){

        			$scope.provincia=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/distrito";
        		
        		$http.get(ruta).success(function(data){

        			$scope.distrito=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/estadoCivil";
        		
        		$http.get(ruta).success(function(data){

        			$scope.estadoCivil=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/vigencia";
        		
        		$http.get(ruta).success(function(data){

        			$scope.vigencia=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/moneda";
        		
        		$http.get(ruta).success(function(data){

        			$scope.moneda=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getArea/area";
        		
        		$http.get(ruta).success(function(data){

        			$scope.area=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/cargo";
        		
        		$http.get(ruta).success(function(data){

        			$scope.cargo=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

                ruta =  "{{route('modRH')}}/api/getGentabcod/categoria";
        		
        		$http.get(ruta).success(function(data){

        			$scope.categoria=data;

                }).error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });



        	}


        });
</script>


@stop