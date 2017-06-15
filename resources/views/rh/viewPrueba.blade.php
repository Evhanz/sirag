@extends('layout')

@section('content-header')


<h2>Mantenedor de Personal</h2>

@stop

@section('content')


<div id="content" ng-app="app" ng-controller="PruebaController">
	<div class="row" style="padding-left: 15px; padding-right: 15px;margin: 0px;">
		<div class="box box-warning">

			<div class="box-body">
				<div class="row">
			
					<div class="col-lg-4">
						<label for="funcionario">Funcionario</label>
						<input  class="form-control" name="funcionario" type="text" required="">
					</div>

					<div class="col-lg-4">
						<label for="apellidoPaterno">Apellido Paterno</label>
						<input  class="form-control"type="text" name="apellidoPaterno">
					</div>
					<div class="col-lg-4">
						<label for="apellidoMaterno">Apelldo Materno</label>
						<input class="form-control" type="text" name="apellidoMaterno">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<label for="codigoLegal">Código Legal</label>
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
						<select class="form-control" name="estadoCivil" id="estadoCivil">
							<option value="Casado">Casado</option>
							<option value="Soltero">Soltero</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="sexo">Sexo</label>
						<select class="form-control" name="sexo" id="sexo">
							<option value="Masculino">Masculino</option>
							<option value="Femenino">Femenino</option>
						</select>
					</div>
				</div>
				<hr>
					DOMICILIO
				<hr>
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
						<select name="" id="">
							<option value="">-------</option>
						</select>
						
					</div>
					<div class="col-lg-3"></div>
					<div class="col-lg-3"></div>
					<div class="col-lg-3"></div>
				</div>
			</div>

			<div class="box-footer">
				@{{saludo}}
			</div>

		</div>
	</div>
</div>










<script>
	  var app = angular.module("app", []);
        app.controller("PruebaController", function($scope,$http,$window) {

        	$scope.saludo= 'angular funciona';

        	initData();

        	function initData() {
        		// body...
        		//primero llamamos pais
        		var ruta =  "{{route('modRH')}}/api/getUbigeo/pais";
        		console.log(ruta);
        		$http.get(ruta)
        		.success(function(data){

        			console.log(data);


                })
        		.error(function(data) {

        			alert('error');
        			console.log(data);
                  
                });

        	}


        });
</script>


@stop