@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container-fluid">
        <h3>Ver</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <form id="creditForm" method="post" action="/credits">
                    @include('credits.form')
                    <hr>
                    <a href="{{ route('credits.index') }}" class="btn btn-danger">Volver</a>
                </form>
            </div>
        </div>        
    </div>
@endsection
@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('bootstrap-datepicker.script')
    @include('commons.autonumeric')
    @include('datatables.script')
    @include('credits.jscreate')
@endsection