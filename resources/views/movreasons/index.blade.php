@extends('layouts.app')
@section('custom_styles')
    @include('datatables.style')
@endsection
@section('content')
<div class="container">
	<h3>Listado de Motivos</h3>
    <hr>
	<div class="container">
	<a href="{{ route('movreasons.create') }}" class="btn btn-lg btn-info">NUEVO</a>
	</div>
	<hr>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
            <div class="card border-primary">
                <div class="card-header">
                    <table class="display" id="table">
                        <thead>
                            <tr>
                                <th>TIPO</th>
                                <th>DESCRIPCION</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

@endsection
@section('custom_scripts')
    @include('datatables.script')
    @include('movreasons.jsindex')
@endsection
