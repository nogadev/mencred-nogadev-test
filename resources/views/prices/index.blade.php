@extends('layouts.app')
@section('custom_styles')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
        <h5>PRECIOS DE ARTICULOS</h5>
        <hr>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="table" class="display">
                <thead>
                <tr>
                    <th></th>
                    <th>ARTICULO</th>
                    <th>MARCA</th>
                    <th>MODELO</th>
                    <th>CUOTAS</th>
                    <th>$ CUOTA</th>
                    <th>TOTAL</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
        @include('prices.modals.newprice')
        @include('prices.modals.delete')
    </div>

@endsection
@section('custom_scripts')
    @include('datatables.script')
    @include('commons.asterix-sm')
    @include('prices.js')
    @include('prices.jsgrid')
    @include('bootstrap-select.script')
    @include('prices.modals.js')
@endsection