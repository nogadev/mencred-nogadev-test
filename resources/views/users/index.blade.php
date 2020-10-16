@extends('layouts.app')
@section('custom_styles')
    @include('datatables.style')
@endsection
@section('content')
<div class="container">
	<h3>Usuarios</h3>
	{{-- @can('users.create') --}}
	<h5><a href="{{ route('users.create') }}" class="undecorated">Registrar nuevo usuario</a></h5>
	{{-- @endcan --}}
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<table id="table" class="display compact">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Email</th>
					{{-- @canany(['users.edit', 'users.destroy']) --}}
					<th class="no-order no-search fit"></th>
					{{-- @endcanany --}}
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					{{-- @canany(['users.edit', 'users.destroy']) --}}
					<td>
						<div id="delete-div-{{$user->id}}" style="display: inline;">
							{{-- @can('users.edit') --}}
							<form method="get" action="{{route('users.edit', $user)}}" style="display: inline;">
								<button type="submit" class="btn btn-sm btn-success">Editar</button>
							</form>
							{{-- @endcan   
							@can('users.destroy')   --}}                 
							{{-- <button type="button" class="btn btn-sm btn-danger" onclick="askConfirm({{$user->id}});">Eliminar</button> --}}
							{{-- @endcan --}}
						</div>  
						{{-- @can('users.destroy')  --}}
						<div id="confirm-div-{{$user->id}}" style="display: none;">
							<form action="{{ route('users.destroy', $user) }}" method="post" style="display: inline;">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button type="submit" class="btn btn-sm btn-danger">Si, eliminar</button>
							</form>
							<button type="button" class="btn btn-sm btn-default" onclick="cancelConfirm({{$user->id}});">Cancelar</button>
						</div>
						{{-- @endcan --}}
					</td>
					{{-- @endcanany --}}
				</tr>
			@endforeach
			</tbody>
		</table>
    </div>    
</div>
@endsection
@section('custom_scripts')
	@include('datatables.script')
    <script>
        $(document).ready(function() {
			var table = $('#table').DataTable();
		});

        function askConfirm(id){
            $("#delete-div-"+id).hide();
            $("#confirm-div-"+id).show();
        }

        function cancelConfirm(id){
            $("#delete-div-"+id).show();
            $("#confirm-div-"+id).hide();
        }
    </script>
@endsection
