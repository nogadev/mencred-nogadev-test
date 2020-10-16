@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container-fluid">
        <h3>Lista de Precios</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="row justify-content-start mx-auto">
            <a href="#" id="print" class="btn btn-md btn-warning">IMPRIMIR</a>
        </div>
        <br/>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <div class="card border-primary">
                    <div class="card-header">
                        <table class="display" id="table">
                        <thead>
                            <tr>
                                <th>ARTICULO</th>
                                <th>MARCA</th>
                                <th>MODELO</th>
                                <th>LISTA</th>
                                <th>PRECIO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('bootstrap-datepicker.script')
    @include('datatables.script')
    @include('reports.articles.pricelist.jsPriceList')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@endsection
