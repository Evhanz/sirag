<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	

	<table>
		<?php $suma_parron = 0; ?>
		<!--cabecera-->
		<tr class="cabecera">
			<td colspan="3" style="color: #FFF;background-color: #F08B35 ">Fundo : {{$fundo}} </td>

			@if(isset($cci))
				@foreach ($cci as $parron)
					<td colspan="3"> CCI : {{$parron->cci}}- en fecha: {{$parron->f_ini}}  al {{$parron->f_fin}} </td>
					<?php $suma_parron +=  $parron->VALOR1;?>
				@endforeach
			@else
				@foreach ($parrones as $parron)
					<td colspan="3">{{ $parron['CODIGO'] }} - en fecha: {{$parron['startDate']}}  al {{ $parron['endDate'] }}</td>
					<?php $suma_parron +=  $parron['VALOR1'];?>
				@endforeach
			@endif



			<td colspan="2" style="color: #FFF;background-color: #FFBD00 ">TOTAL DE HAS. {{$fundo}}</td>
			<td colspan="2" style="color: #FFF;background-color: #FFBD00 ">{{$suma_parron }}  HAS </td>
		</tr>
		<tr class="cabecera">
			<td style="color: #FFF;background-color: #F0867A " rowspan="2">PROGRAMA</td>
			<td style="color: #FFF;background-color: #F0867A " rowspan="2">CODIGO</td>
			<td style="color: #FFF;background-color: #F0867A " rowspan="2">DESCRIPCION</td>
			@foreach ($parrones as $parron)
			<td style="color: #FFF;background-color: #F0867A " colspan="2">HAS:</td>
			<td style="color: #FFF;background-color: #F0867A " >{{ $parron['VALOR1'] }}</td>
			@endforeach
			<td style="color: #FFF;background-color: #FFBD00 " colspan="2" >TOTAL FUNDO</td>
			<td style="color: #FFF;background-color: #FFBD00 " colspan="2">PROMEDIO HA. FUNDO	</td>
		</tr>
		<tr class="cabecera">
			@foreach ($parrones as $parron)
			<td>CANTIDAD</td>
			<td>GTO. PARRON S/</td>
			<td>GTO. POR HA. S/</td>
			@endforeach
			<td>CANTIDAD</td>
			<td>GTO. PARRON S/</td>
			<td>GTO. POR HA. S/</td>
			<td style="color: #FFF;background-color: #FFBD00 ">CANTIDAD TOTAL</td>
			<td style="color: #FFF;background-color: #FFBD00 ">GTO. PARRON S/	</td>
			<td style="color: #FFF;background-color: #FFBD00 ">CANTIDAD</td>
			<td style="color: #FFF;background-color: #FFBD00 ">GTO. HA.</td>
		</tr>


		<!--Cuerpo de la data-->
		@foreach ($productos as $p)
		<tr class="data">
			<td>{{ $p->SUBFAMILIA }}</td>
			<td>{{ $p->PRODUCTO }}</td>
			<td>{{ $p->GLOSA }}</td>
			@foreach($p->analisis_parron as $item)
			<td>{{ isset($item->total_cantidad_consumo) ? $item->total_cantidad_consumo : 0  }}</td>
			<td>{{ isset($item->total_precio_consumo) ? $item->total_precio_consumo : 0   }}</td>
			<td>{{ $item->precio_ha }}</td>
			@endforeach
			<?php $analisis = collect($p->analisis_parron); ?>
			<td>{{ $analisis->sum('total_cantidad_consumo') }}</td>
			<td>{{ $analisis->sum('total_precio_consumo') }}</td>
			<!--cantidad por hecarea y costo por hectareas-->
			@if($fundo != 'COSTO IND. X ASIGNAR')

			<td>{{ number_format($analisis->sum('total_cantidad_consumo')/$suma_parron,2,'.',',') }}</td>
			<td>{{ number_format($analisis->sum('total_precio_consumo')/$suma_parron,2,'.',',') }}</td>
			@else
				<td>-</td>
				<td>-</td>
			@endif
		</tr>
		@endforeach


		@if(isset($otros))

		<hr>
		<tr>
			<td> </td>
		</tr>

		<tr>
			<td><h4>PARRONES NO ASIGNADOS O GENERICO {{ substr($f_otros_i,2,2) }}{{$fundo}}00</h4></td>
			<td>en fecha {{ $f_otros_i }} al {{ $f_otros_f }}</td>
		</tr>
		<tr>
			<td></td>
			<td>CODIGO</td>
			<td>DESCRIPCION</td>
			<td>CANTIDAD</td>
			<td>TOTAL</td>
		</tr>
		@foreach ($otros as $p)
		<tr class="">
			<td></td>
			<td>{{ $p->PRODUCTO }}</td>
			<td>{{ $p->DESCRIPCION }}</td>
			<td>{{ $p->cantidad }}</td>
			<td>{{ $p->total }}</td>
		</tr>
		@endforeach
		@endif
		
		
	</table>

	<style>
		
		
		table > .data > td:nth-child(3n+1){

			border-left: 200px solid #000;
		/*	background-color: #344;
			color: #333;
			*/

		};
		

	</style>

	
	
</body>
</html>