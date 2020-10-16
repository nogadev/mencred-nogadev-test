@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('bootstrap-datepicker.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container-fluid">
        <h3>Informe de Total General</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-11">
                <form id="creditForm" method="post" action="" autocomplete="off">
                    <hr>
                    <div class="row">
                        {{ csrf_field() }}
                        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            @include('commons.asterix-sm')<label>DESDE</label>
                            <input type="text" id="date_init" name="date_init" class="datepicker form-control form-control-sm" placeholder="dd/mm/aaaa">
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            @include('commons.asterix-sm')<label>HASTA</label>
                            <input type="text" id="date_end" name="date_end" class="datepicker form-control form-control-sm" placeholder="dd/mm/aaaa">
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            @include('commons.asterix-sm')<label>RECORRIDO</label>
                            <select name="route_id" id="route_id" class="form-control form-control-sm">
                                @foreach($routes as $route)
                                    <option value="{{$route->id}}">{{$route->name}}</option>
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
                      <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                <b><label>TOTAL</label><br/></b>
                                <input id="a_total" type="text" name="a_total" class="form-control" style="font-weight:bold" readonly="readonly">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                <b><label>COBRADO</label><br/></b>
                                <input id="a_cobrado" type="text" name="a_cobrado" class="form-control" style="font-weight:bold" readonly="readonly">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                                <b><label>SALDO</label><br/></b>
                                <input id="a_saldo" type="text" name="a_saldo" class="form-control" style="font-weight:bold" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="display " id="table">
                            <thead>
                                <tr>
                                    <th>FECHA</th>
                                    <th>CLIENTE</th>
                                    <th>RECORRIDO</th>
                                    <th>VENDEDOR</th>
                                    <th>TOTAL</th>
                                    <th>COBRADO</th>
                                    <th>SALDO</th>
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
    @include('reports.credits.total.jscreditsTotal')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <!-- Moment.js: -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment.min.js"></script>
    <!-- Locales for moment.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/locale/es.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>

@endsection
