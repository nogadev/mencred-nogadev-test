@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
    <h5>Crear nuevo cliente</h5>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="/customers" id="customerForm" autocomplete="off" >
                @include('customers.form')
                <hr>
                <button type="submit" class="btn btn-success">GUARDAR</button>
                <a href="{{ route('customers.index') }}" class="btn btn-danger">CANCELAR</a>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('bootstrap-datepicker.script')
    @include('commons.autonumeric')
    @include('datatables.script')
    @include('customers.jscreate')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@endsection
