@extends('layouts.app')
@section('custom_styles')
    @include('datatables.style')
@endsection
@section('content')
<div class="container">
	<h3>Listado de Proveedores</h3>
    <hr>
	<div class="container">
	<a href="{{ route('suppliers.create') }}" class="btn btn-lg btn-info">Nuevo</a>
	</div>
	<hr>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<table id="table" class="compact hover nowrap row-border">
			<thead>
				<tr>
					<th>CUIT</th>
					<th>Nombre</th>
					<th>Fantasía</th>
					<th>Teléfono</th>
					<th>Email</th>
					<th class="no-order no-search fit"></th>
				</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>
    </div>    
</div>
<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Confirmar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="delForm" action="#" method="post" style="display: inline;">
					{{ method_field('DELETE') }}
					{{ csrf_field() }}
					<p>Realmente desea eliminar <span id="delName" style="display: inline;"></span>?</p>
					<button type="submit" class="btn btn-danger">Eliminar</button>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@section('custom_scripts')
	@include('datatables.script')
    @include('suppliers.jsindex')
@endsection
