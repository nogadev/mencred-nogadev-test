<div class="row">
	<table class="table table-striped mb-0 pointer" id="table">
		<thead>
			<tr>
				<th>Nº</th>
				<th>ESTADO</th>
				<th>RECORRIDO</th>
				<th>VENDEDOR</th>
				<th>FEC ALTA</th>
				<th>CUOTAS</th>
				<th>IMPORTE</th>
				<th>TOTAL</th>
				<th class="text-center">RECLAMO</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($customer->credits as $credit)
					@if($credit->status->status == 'OPERANDO')
						<tr class="weight">
					@else
						<tr>
					@endif
					<td>{{ $credit->id }}</td>
					<td>{{ $credit->status->status }}</td>
					<td>{{ $customer->route->name }}</td>
					<td>{{ $credit->seller->name }}</td>
					<td>{{ ($credit->init_date) ? $credit->init_date->format('d/m/Y') : ''}}</td>
					<td>{{ $credit->fee_quantity }}</td>
					<td>{{ number_format($credit->fee_amount, 2,',','.') }} $</td>
					<td>{{ number_format($credit->fee_amount * $credit->fee_quantity, 2,',','.') }} $</td>
					<td>
						@if(count($credit->claims) > 0)
							<a name="{{$credit->id}}" onclick="showClaims({{$credit->id}})" class='btnClaims add btn btn-warning btn-circle' data-toggle="tooltip" data-placement="top" title="RECLAMOS"><i class='fa fa fa-exclamation-triangle' aria-hidden='true'></i></a>
						@endif
					</td>
					<td>
						<a name="{{$credit->id}}" onclick="showDetail({{$credit->id}})" class='btnDetails add btn btn-info btn-circle' data-toggle="tooltip" data-placement="top" title="DETALLE"><i class='fa fa fa-info' aria-hidden='true'></i></a>
						<a name="{{$credit->id}}" onclick="showFees({{$credit->id}})" class='btnFees add btn btn-secondary btn-circle' data-toggle="tooltip" data-placement="top" title="CUOTAS"><i class='fa fa-bars' aria-hidden='true'></i></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>




