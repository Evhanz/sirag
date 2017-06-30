@extends('layout')

@section('content-header')


<div class="row" style="padding-left: 15px; padding-right: 15px;margin: 0px;">
	<h2>Mantendor de Centro de Costo Interno</h2>
</div>


@stop

@section('content')

<div id="content" ng-app="app" ng-controller="PruebaController">
	<div class="row" style="padding-left: 15px; padding-right: 15px;margin: 0px;">
		<div class="box box-warning">
			<div class="box-header">
			</div>
			<div class="box-body">
				<h4><strong>FACTORES GENERALES</strong></h4>
				<hr>
				<div class="row">
					<div class="col-lg-4">
						<label for="cci">Centro Costo Interno</label>
						<input  class="form-control" name="cci" type="text" required="">
					</div>
					<div class="col-lg-4">
					</div>
					<div class="col-lg-4">
						<label for="vigente">Vigente</label>
						<input  class="form-control" name="vigente" type="text" required="">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						<label for="especie">Especie</label>
						<input  class="form-control" name="especie" type="text" required="">
					</div>
					<div class="col-lg-3">
						<label for="variedad">Variedad</label>
						<input  class="form-control" name="variedad" type="text" required="">
					</div>
					<div class="col-lg-3">
						<label for="fundo">Fundo</label>
						<input  class="form-control" name="fundo" type="text" required="">
					</div>
					<div class="col-lg-3">
						<label for="parron">Parron</label>
						<input  class="form-control" name="parron" type="text" required="">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<label for="ccosto">Centro de Costo General</label>
						<input  class="form-control" name="ccosto" type="text" required="">
					</div>
					<div class="col-lg-4">
						<label for="localidad">Localidad</label>
						<input  class="form-control" name="localidad" type="text" required="">
					</div>
					<div class="col-lg-4">
						<label for="tipoGasto">Tipo de Gasto</label>
						<input  class="form-control" name="tipoGasto" type="text" required="">
					</div>
				</div>
				<hr>
				<h4><strong>FACTORES PRODUCCION</strong></h4>
				<hr>
				<div class="row">
					<div class="col-lg-4">
						<label for="Cliente">Cliente</label>
						<input  class="form-control" name="Cliente" type="text" required="">
					</div>
					<div class="col-lg-4">
					</div>
					<div class="col-lg-4">
						<label for="campana">Campaña</label>
						<input  class="form-control" name="campana" type="text" required="">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@stop