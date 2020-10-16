@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
        <h3>GASTOS VENDEDORES</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="storeExpense" autocomplete="off" id="expenseForm">
                @include('expenses.form')
                <hr>
            </form>
        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('bootstrap-datepicker.script')
    @include('commons.autonumeric')
    @include('datatables.script')
    @include('expenses.jscreate')
@endsection