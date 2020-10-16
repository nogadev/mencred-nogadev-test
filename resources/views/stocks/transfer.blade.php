@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-datepicker.style')
    @include('bootstrap-select.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
        <h3>Transferencia de artículos</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="{{route('stocks.saveTransfers')}}" autocomplete="off" id="transferForm">
                @include('stocks.form')
                <hr>
                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('bootstrap-datepicker.script')
    @include('bootstrap-select.script')
    @include('commons.autonumeric')
    @include('commons.autosize')
    @include('datatables.script')
    @include('stocks.js')
@endsection