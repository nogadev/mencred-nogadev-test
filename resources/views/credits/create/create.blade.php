@extends('layouts.app')
@section('custom_styles')
@include('bootstrap-select.style')
@include('bootstrap-datepicker.style')
@include('datatables.style')
@endsection
@section('content')
<div class="container-fluid">
    <div class="clearfix"></div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
            <form id="creditForm" method="post" action="/credits" autocomplete="off">
                @include('credits.create.form')
                <hr>
                <button type="submit" class="btn btn-success">GUARDAR</button>
                <a href="{{ route('credits.index') }}" class="btn btn-danger">CANCELAR</a>
            </form>
        </div>
    </div>
</div>
@include('credits.create.save')
@endsection
@section('custom_scripts')
@include('bootstrap-select.script')
@include('bootstrap-datepicker.script')
@include('commons.autonumeric')
@include('datatables.script')
@include('credits.create.jscreate')
@include('cashes.modals.cash')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@endsection
