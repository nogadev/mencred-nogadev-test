@include('errors')
<div id="error_div" style="display:none">
    <div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="collectForm" method="post" action="storeMovement" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" id="movement_id" name="movement_id"/>
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                @include('commons.asterix-sm')<label>TIPO</label>
                                <select name="movementtype_id" id="movementtype_id">
                                    @foreach($movementtypes as $movementtype)
                                        <option value="{{$movementtype->id}}">{{$movementtype->description}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                @include('commons.asterix-sm')<label>MOTIVO</label>
                                <select name="mov_reason_id" id="mov_reason_id">
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                <div id="paymentDiv">
                                    @include('commons.asterix-sm')<label>METODO DE PAGO</label>
                                    <select name="payment_method_id" id="payment_method_id">
                                        @foreach($payment_methods as $payment)
                                            <option value="{{$payment->id}}">{{$payment->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                @include('commons.asterix-sm')<label>MONTO</label>
                                <input type="text" id="amount" name="amount" class="form-control" placeholder="Monto"
                                       value="{{ old('amount') }}">
                            </div>

                            <div class="form-group col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                @include('commons.asterix-sm')<label>DETALLE</label>
                                <textarea type="text" name="description" id="description" class="form-control" placeholder="Descripción"
                                          value="{{ old('description') }}"></textarea>
                            </div>

                            <input type="hidden" name="cash_id" id="cash_id" value="{{$cash->id}}"/>

                        </div>

                    </form>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="submit" class="btn btn-success">GUARDAR</button>
                    <button type="button" class="btn btn-danger btn-cancel">CANCELAR</button>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body row">
                    <div class="col">
                        <label>EFECTIVO</label><br/>
                        <input id="div-cashing-total" type="text" class="form-control" readonly="readonly">
                    </div>
                    <div class="vr"></div>
                    <div class="col">
                        <label>CHEQUES</label><br/>
                        <input id="div-checks-total" style="background-color: #ff3838;color: white" type="text" class="form-control" readonly="readonly">
                    </div>
                </div>
                <div class="card-body row" style="max-width: 18rem; margin-top: 20px">
                    <div class="col">
                        <label>BANCO</label><br/>
                        <input id="div-banks-total" style="background-color: #38c172;color: white" type="text" class="form-control" readonly="readonly">
                    </div>
                    <div class="vr"></div>
                    <div class="col">
                        <label>MERCADOPAGO</label><br/>
                        <input id="div-mercadopago-total" style="background-color: #009ee3;color: white" type="text" class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="card" style="max-width: 18rem;">
                <div class="card-body row">
                    <div class="col">
                        <label>INGRESOS</label><br/>
                        <input id="div-cash-in-total" type="text" class="form-control" readonly="readonly">
                    </div>
                    <div class="vr"></div>
                    <div class="col">
                        <label>EGRESOS</label><br/>
                        <input id="div-cash-out-total" type="text" class="form-control" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="card" style="max-width: 18rem; margin-top: 20px">
                <div class="card-body row">
                    <div class="col">
                        <label>TOTAL CAJA</label><br/>
                        <input id="div-cash-total" type="text" class="form-control" readonly="readonly">
                    </div>
                    <div class="vr"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<br>
<div class="row justify-content-center" id="ingresos-egresos">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">INGRESOS</div>

                    <table id="tableMovementIn" style="table-layout: fixed;" class="compact hover nowrap row-border fixed">
                        <thead>
                        <tr>
                            <th width="20%">TIPO</th>
                            <th>DETALLE</th>
                            <th width="15%">MONTO</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>CUOTA INICIAL</label><br/>
                                <input id="inicial" type="text" name="inicial" class="form-control" readonly="readonly">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>EFECTIVO</label><br/>
                                <input id="efectivo" type="text" name="efectivo" readonly="readonly"
                                       class="form-control">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>CHEQUES</label><br/>
                                <input id="cheques" type="text" name="cheques" readonly="readonly" class="form-control" style="background-color: #ff3838;color: white">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>BANCO</label><br/>
                                <input id="transferencias" type="text" name="tranferencias" readonly="readonly" class="form-control" style="background-color: #38c172;color: white">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>MERCADO PAGO</label><br/>
                                <input id="mercadopago" type="text" name="mercadopago" readonly="readonly" class="form-control" style="background-color: #009ee3;color: white">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>TOTAL INGRESOS</label><br/>
                                <input id="ingresos" type="text" name="ingresos" class="form-control"
                                       readonly="readonly">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">EGRESOS</div>

                    <table id="tableMovementOut" class="compact hover nowrap row-border fixed">
                        <thead>
                        <tr>
                            <th width="20%">TIPO</th>
                            <th>DETALLE</th>
                            <th width="15%">MONTO</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>EFECTIVO</label><br/>
                                <input id="efectivo_out" type="text" name="efectivo_out" readonly="readonly"
                                       class="form-control">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>CHEQUES</label><br/>
                                <input id="cheques_out" type="text" name="cheques_out" readonly="readonly" class="form-control" style="background-color: #ff3838;color: white">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>BANCO</label><br/>
                                <input id="transferencias_out" type="text" name="transferencias_out" readonly="readonly" class="form-control" style="background-color: #38c172;color: white">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>MERCADO PAGO</label><br/>
                                <input id="mercadopago_out" type="text" name="mercadopago_out" readonly="readonly" class="form-control" style="background-color: #009ee3;color: white">
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <label>TOTAL EGRESOS</label><br/>
                                <input id="egresos" type="text" name="egresos" class="form-control" readonly="readonly">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
