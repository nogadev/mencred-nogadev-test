@extends('layouts.app')

@section('custom_styles')
@include('bootstrap-select.style')
@include('datatables.style')
@endsection

@section('content')
<div class="container">
    <h4>LISTADO DE CREDITOS</h4>
    <hr>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        {!! Form::open(['method' => 'GET', 'id' => 'frm_credit_search' ,'url' => Request::fullUrl() , 'role' =>
        'search']) !!}
        <div class="row">
            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <label>ESTADO</label>
                <select name="status_id">
                    @foreach($status as $sta)
                    <option value="{{$sta->id}}" @if(request('status_id')==$sta->id) selected @endif >{{$sta->status}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <label>RECORRIDO</label>
                <select name="route_id">
                    @foreach($routes as $route)
                    <option value="{{$route->id}}" @if(request('route_id')==$route->id) selected @endif
                        >{{$route->name}}</option>
                    @endforeach
                </select>
            </div>


        </div>

        <br>
        <div class="row dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="table_length">
                    <label>Ver
                        <select name="perPage" aria-controls="table"
                            class="custom-select custom-select-sm form-control form-control-sm">
                            <option value="50" @if(request('perPage')==50) selected @endif>50</option>
                            <option value="100" @if(request('perPage')==100) selected @endif>100</option>
                        </select>
                        filas</label>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <div id="table_filter" class="dataTables_filter">
                    <label>BUSCAR&nbsp;:
                        <input type="search" name="search" value="{{ request('search') }}"
                            class="form-control form-control-sm" placeholder="" aria-controls="table">
                    </label>
                    <button class="btn btn" type="submit">
                        <i class="fa fa-search" aria-hidden="true">&nbsp;</i>
                    </button>
                </div>
            </div>
        </div>

        <table id="table" class="table table-striped mb-0 pointer">
            <thead>
                <tr>
                    <th>@sortablelink('id','Nº')</th>
                    <th>@sortablelink('created_date','FECHA')</th>
                    <th>CLIENTE</th>
                    <th>RECORRIDO</th>
                    <th>VENDEDOR</th>
                    <th>CUOTAS</th>
                    <th>$ CUOTA</th>
                    <th>ESTADO</th>
                    <th>ENTREGA</th>
                    <th>USUARIO</th>
                    <th style="width:12%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credits as $credit)
                @if($credit->status_id == 6)
                <tr class="bg-danger text-white">
                @else
                <tr>
                @endif
                    <td>{{ $credit->id }}</td>
                    <td>{{ $credit->created_date->format('d/m/Y') }}</td>
                    <td>{{ $credit->customer->name }}</td>
                    <td>{{ $credit->customer->route->name}}</td>
                    <td>{{ $credit->seller->name }}</td>
                    <td>{{ intval($credit->fee_quantity) }}</td>
                    <td>{{ number_format($credit->fee_amount, 2,',','.') }} $</td>
                    <td id="status{{$credit->id}}">{{ $credit->status->status }}</td>
                    <td>{{ $credit->delivery->name }}</td>
                    <td>{{ $credit->user->name }}</td>
                    <td id="div_{{$credit->id}}">
                        <div class="btn-group">
                            @if($credit->status_id == 1)
                            <a onclick="approve({{$credit->id}})" class='btn btn-success btn-circle'
                                data-toggle="tooltip" data-placement="top" title="Confirmar"><i class='fa fa-check'
                                    aria-hidden='true'></i></a>
                            @endif
                        </div>

                        @if($credit->status_id == 3)
                        <div class="btn-group">
                            <a onclick="cancel({{$credit->id}})" class='btn btn-danger btn-circle' data-toggle="tooltip"
                                data-placement="top" title="Cancelar"><i class='fa fa-times' aria-hidden='true'></i></a>
                        </div>
                        @endif

                        <div class="btn-group">
                            <a id="linkPrint" target="_blank" href="{{url( '/print/credit/card') ."/" .$credit->id }}"
                                class='btn btn-warning btn-circle' data-toggle="tooltip" data-placement="top"
                                title="Imprimir"><i class='fa fa-print' aria-hidden='true'></i></a>
                        </div>
                        @if(Auth()->User()->email=='admin@mencred.com' || Auth()->User()->email=='daniel.lucero@mencred.com'
                            || Auth()->User()->email=='pablo.bustamante@mencred.com')
                        <div class="btn-group">
                            <a id="linkPrint" href="{{ route('credits.edit', $credit) }}"
                                class='btn btn-info btn-circle' data-toggle="tooltip" data-placement="top"
                                title="Modificar cuotas"><i class='fa fa-list' aria-hidden='true'></i></a>

                        </div>
                        @endif
                        <div class="btn-group">
                            @if($credit->status_id == 1 || $credit->status_id == 2)
                            <a onclick="rechazar({{$credit->id}})" class='btn btn-danger btn-circle'
                                data-toggle="tooltip" data-placement="top" title="Rechazar"><i class='fa fa-times'
                                    aria-hidden='true'></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! Form::close() !!}
    </div>
    @if(count($credits) > 0)
    <div class="pagination-wrapper">
        {!!
        $credits->appends([
        'sort' => request('sort'),
        'direction' => request('direction'),
        'perPage' => request('perPage'),
        'search' => request('search'),
        'status_id' => request('status_id'),
        'route_id' => request('route_id'),
        ])
        !!}
    </div>
    @endif
</div>
@include('credits.modals.confirm')
@include('credits.modals.rechazar')
@include('credits.modals.cancel')
@include('customers.claims.claims')

@endsection
@section('custom_scripts')
@include('bootstrap-select.script')
@include('datatables.script')
@include('customers.claims.jsclaims')
@include('credits.jsindex')
@include('cashes.modals.cash')
@endsection
