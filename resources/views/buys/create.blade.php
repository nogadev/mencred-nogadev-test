@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container-fluid">
        <h3>Cargar factura nueva de compra</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <form id="buyForm" method="post" action="/buys" autocomplete="off">
                    @include('buys.form')
                    <hr>
                    <button type="button" class="btn btn-success" onclick="confirm();">Guardar</button>
                    <a href="{{ route('buys.create') }}" class="btn btn-danger">Cancelar</a>
                    @include('buys.modals.confirm')
                </form>
            </div>
        </div>
    </div>
    @include('buys.modals.newArticle')
    @include('buys.modals.newSupplier')
    @include('buys.modals.newCompany')
    @include('buys.modals.newStore')
@endsection
@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('bootstrap-datepicker.script')
    @include('commons.autonumeric')
    @include('datatables.script')
    @include('buys.js')
@endsection
