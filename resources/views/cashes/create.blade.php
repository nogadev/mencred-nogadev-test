@extends('layouts.app')
@section('custom_styles')
@include('bootstrap-select.style')
@include('bootstrap-datepicker.style')
@include('datatables.style')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <h3>CAJA ACTUAL</h3>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
            <button type="button" id="closeCashBtn" class="btn btn-danger">CERRAR CAJA</button>
        </div>
    </div>
    <hr>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form method="post" action="storeMovement" autocomplete="off" id="movementForm">
            @include('cashes.form')
            <hr>
        </form>
    </div>
</div>
@include('cashes.modals.paychecks')
@include('cashes.modals.mercadopago')
@include('cashes.modals.checkdetail')
@include('cashes.modals.detail')
@include('cashes.modals.confirm')
@include('cashes.modals.cash')
@endsection
@section('custom_scripts')
@include('bootstrap-select.script')
@include('bootstrap-datepicker.script')
@include('commons.autonumeric')
@include('datatables.script')
@include('cashes.jscreate')
@endsection
