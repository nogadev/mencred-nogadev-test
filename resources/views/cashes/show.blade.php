@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
        <h3>Ver Caja</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row justify-content-center">
                <div class="card border-primary">
                    <div class="card-body row">
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <h5>INGRESOS</h5>
                            <table id="tableMovementIn" style="table-layout: fixed;" class="compact hover nowrap row-border">
                                <thead>
                                    <tr>
                                        <th width="30%">Tipo</th>
                                        <th>Detalle</th>
                                        <th width="20%">Monto</th>
                                    </tr>
                                </thead>
                                <tbody> 

                                </tbody>
                            </table>
                        </div>

                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <h5>EGRESOS</h5>
                            <table id="tableMovementOut" style="table-layout: fixed; " class="compact hover nowrap row-border fixed">
                                <thead>
                                    <tr>
                                        <th>Motivo</th>
                                        <th width="20%">Monto</th>
                                    </tr>
                                </thead>
                                <tbody> 

                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                                <label>Cta Inicial</label><br/>
                                <input id="inicial" type="text" name="inicial" class="form-control"  readonly="readonly">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                                <label>Reccorido Efectivo</label><br/>
                                <input id="efectivo" type="text" name="efectivo" readonly="readonly" class="form-control">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                                <label>Recorrido Cheques</label><br/>
                                <input id="cheques" type="text" name="cheques" readonly="readonly" class="form-control">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                                <label>Ingresos</label><br/>
                                <input id="ingresos" type="text" name="ingresos" class="form-control" readonly="readonly" >
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                                <label>Egresos</label><br/>
                                <input id="egresos" type="text" name="egresos" class="form-control" readonly="readonly" >
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                                <label>Balance</label><br/>
                                <input id="balance" type="text" name="balance" class="form-control" readonly="readonly" >
                            </div>
                        </div>                    
                    </div>            
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    @section('custom_scripts')
    @include('commons.autonumeric')
    @include('datatables.script')
    @include('cashes.jsshow')
@endsection
@endsection