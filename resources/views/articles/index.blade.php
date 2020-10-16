@extends('layouts.app')
@section('custom_styles')
    @include('datatables.style')
@endsection
@section('content')
<div class="container">
	<h4>Listado de Artículos</h4>
    <hr>
	<div class="container">
		<a href="{{ route('articles.create') }}" class="btn btn-lg btn-info">NUEVO</a>
	</div>
	<hr>
	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
	    	{!! Form::open(['method' => 'GET', 'id' => 'frm_article_search' ,'url' => Request::fullUrl() , 'role' => 'search'])  !!}

			<div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <div class="card border-primary">
                    <div class="card-header">
                        <table class="display" id="table">
							<thead>
								<tr>
									<th>CODIGO</th>
									<th>DESCRIPCION</th>
									<th>CATEGORIA</th>
									<th>MARCA</th>
									<th>ESTADO</th>
									<th class="width-article"></th>
								</tr>
							</thead>
						</table>
                    </div>
                </div>
            </div>
			{!! Form::close() !!}
	    </div>
	</div>

@endsection
@section('custom_scripts')
	@include('datatables.script')
    @include('articles.jsindex')
@endsection
