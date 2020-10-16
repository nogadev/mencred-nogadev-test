@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container-fluid">
        <h3>Informe de Reclamos</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <form id="claimsForm" method="post" action="" autocomplete="off">
                    <hr>
                    <div class="row">
                        {{ csrf_field() }}
                        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            @include('commons.asterix-sm')<label>ESTADO</label>
                            <select name="status_id" id="status_id" class="form-control form-control-sm">
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->status}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            <br/>
                            <a href="#" id="find" class="btn btn-md btn-success">BUSCAR</a>
                            <a href="#" id="print" class="btn btn-md btn-warning">IMPRIMIR</a>
                        </div>
                    </div>


                </form>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <div class="card border-primary">
                    <div class="card-header">
                        <table class="display " id="table">
                        <thead>
                            <tr>
                                <th>TIPO</th>
                                <th>CLIENTE</th>
                                <th>TELEFONO</th>
                                <th>RECORRIDO</th>
                                <th>VENDEDOR</th>
                                <th>CREDITO</th>
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
    @include('reports.claims.jsclaims')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@endsection
