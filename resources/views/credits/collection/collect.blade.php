@extends('layouts.app')
@section('custom_styles')
@include('bootstrap-select.style')
@include('bootstrap-datepicker.style')
@include('datatables.style')
@endsection
@section('content')
<div class="container-fluid">
    <h4>COBRANZA</h4>
    <hr>
    <div class="clearfix"></div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
            @include('credits.collection.collectdata')
            @include('credits.collection.collectform')
            <hr>
            <button type="submit" onclick="submitForm()" class="btn btn-success">CONFIRMAR</button>
            <a href="{{ route('credits.index') }}" class="btn btn-danger">CANCELAR</a>
            </form>
        </div>
    </div>
</div>
@include('credits.collection.collectsave')
@include('cashes.modals.cash')
@include('credits.collection.paycheck')
@include('credits.collection.mercadopago')
@endsection
@section('custom_scripts')
@include('bootstrap-select.script')
@include('bootstrap-datepicker.script')
@include('commons.autonumeric')
@include('datatables.script')
@include('credits.collection.jscollect')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@endsection
