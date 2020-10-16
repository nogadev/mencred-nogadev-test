@extends('layouts.app')
@section('custom_styles')
@include('datatables.style')
@endsection
@section('content')
<div class="container-fluid">
    <div class="clearfix"></div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
            <h3>Listado de Clientes</h3>
            <hr>
            <div class="row">
				<div>
				    <a href="{{ route('customers.create') }}" class="btn btn-md btn-info">NUEVO</a>
				</div>
				<div style="margin-left: 4px">
				    <a id="print" class="btn btn-md btn-warning" target="blank">IMPRIMIR</a>
				</div>
            </div>
            <hr>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div class="card border-primary">
                    <div class="card-header">
                        <table class="display" id="table">
                            <thead>
                                <tr>
									<th>NOMBRE</th>
									<th>RECORRIDO</th>
									<th>VENDEDOR</th>
									<th>LOC COM</th>
									<th>BARRIO COM</th>
									<th>DIR COM</th>
                                    <th>DOCUMENTO</th>
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
</div>
</div>

@endsection

@section('custom_scripts')
@include('datatables.script')
@include('customers.jsindex')
@endsection
