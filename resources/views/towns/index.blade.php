@extends('layouts.app')
@section('custom_styles')
    @include('datatables.style')
@endsection
@section('content')
<div class="container">
	<h4>Localidades</h3>
    <hr>
	<div class="container">
		<a href="{{ route('towns.create') }}" class="btn btn-md btn-info">Nuevo</a>
	</div>
	<hr>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
    	{!! Form::open(['method' => 'GET', 'id' => 'frm_town_search' ,'url' => Request::fullUrl() , 'role' => 'search'])  !!}

    	<div class="row dataTables_wrapper dt-bootstrap4 no-footer">
    		<div class="col-sm-12 col-md-6">
    			<div class="dataTables_length" id="table_length">
    				<label>Ver 
    					<select name="perPage" aria-controls="table" id="perPage" class="custom-select custom-select-sm form-control form-control-sm">
    						<option value="15" @if(request('perPage')==15) selected @endif >15</option>
    						<option value="25" @if(request('perPage')==25) selected @endif >25</option>
    						<option value="50" @if(request('perPage')==50) selected @endif >50</option>
    						<option value="100" @if(request('perPage')==100) selected @endif >100</option>
    					</select> 
    				filas</label>
				</div>
			</div>

			<div class="col-sm-12 col-md-6">
				<div id="table_filter" class="dataTables_filter">
					<label>Buscar&nbsp;:
						<input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="" aria-controls="table">
					</label>
					<button class="btn btn" type="submit">
                        <i class="fa fa-search" aria-hidden="true">&nbsp;</i>
                    </button>
				</div>
			</div>
		</div>	
		
		<table id="table" class="table">
			<thead>
				<tr>
					<th>@sortablelink('id','Nº')</th>
					<th>@sortablelink('name','Nombre')</th>
					<th>Localidad</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($towns as $town)
					<tr>
						<td>{{ $town->id }}</td>
						<td>{{ $town->name }}</td>
						<td>{{ $town->district->name }}</td>
						<td id="div_{{$town->id}}">
						<div class="btn-group">
							<a href="{{ route('towns.edit', $town) }}" class="btn btn-sm btn-primary">Editar</a>
						</div>
					</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		{!! Form::close() !!}
    </div>
    @if(count($towns) > 0)
	    <div class="pagination-wrapper"> 
	    	{!! 
			$towns->appends([
				'sort' 		=> request('sort'), 
				'direction'	=> request('direction'),
				'perPage' 	=> request('perPage'), 
				'search' 	=> request('search'),
			])
			!!} 
		</div>
	@endif
	
</div>


@endsection
@section('custom_scripts')
    <script>
        $("#perPage").change(function(){
        	$("#frm_town_search").submit();
        });
    </script>
@endsection
