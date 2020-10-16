@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
        <h5>Modificar datos de un Cliente</h5>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" id="customerForm" autocomplete="off" action="{{route('customers.update', $customer)}}">
                {{ method_field('PUT') }}
                @include('customers.form')
                <hr>
                <button type="submit" class="btn btn-success">MODIFICAR</button>
                <a href="{{ route('customers.index') }}" class="btn btn-danger">CANCELAR</a>
            </form>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @include('customers.credits.grids')
            @include('customers.claims.claims')
            @include('customers.modals.details')
            @include('customers.modals.fees')
        </div>
@endsection

@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('bootstrap-datepicker.script')
    @include('commons.autonumeric')
    @include('datatables.script')
    @include('customers.jscreate')
    @include('customers.credits.jsgrid')
    @include('customers.claims.jsclaims')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@endsection
