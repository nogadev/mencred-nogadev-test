@include('errors')    
<div id="error_div" style="display:none">
    <div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    </div>
</div>
<form id="collectForm" method="post" action="storeCollect" autocomplete="off">
    {{ csrf_field() }}
    <div class="row">
        <div class="form-group col-xl-2 col-sm-12 col-md-4 col-lg-4">
            @include('commons.asterix-sm')<label>FECHA</label>
            <input type="text" id="created_date" onchange="getData();" name="created_date" class="datepicker form-control form-control-sm" placeholder="dd/mm/aaaa">
        </div>

        <div class="form-group col-xl-2 col-sm-12 col-md-4 col-lg-4">
            @include('commons.asterix-sm')<label>RECORRIDO</label>
            <select name="route_id" id="route_id" onchange="getData();" class="form-control form-control-sm">
                @foreach($routes as $route)
                    <option value="{{$route->id}}" >{{$route->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-xl-1 col-sm-12 col-md-4 col-lg-4">
            <br/>
            <a id="print" class="btn btn-md btn-warning" target="blank">IMPRIMIR</a>
        </div>

        <div class="form-group col-xl-2 col-sm-12 col-md-4 col-lg-4">
            <br/>
            <label class="label buttonBoolean">
                <div class="toggle">
                    <input class="check" type="checkbox" name="check" value="check" />
                    <b class="b switch">
                        <p class="labor">LABORAL</p>
                    </b>
                    <b class="b track">
                        <p class="holidays">FERIADO</p>
                    </b>
                </div>
            </label>
        </div>
    </div>
    <textarea name="fee_data" id="fee_data" style="display: none;"></textarea>
    <input type="hidden" id="payment_method_id"  name="payment_method_id" value="1">
</form>

<br>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card border-primary">
            <div class="card-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                        <b><label>META</label><br/></b>
                        <input id="a_meta" type="text" name="a_meta" readonly="readonly" value="0" style="font-weight:bold" class="form-control">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                        <b><label>COBRADO</label><br/></b>
                        <input id="a_cobrado" type="text" name="a_cobrado" class="form-control" value="0" style="font-weight:bold" readonly="readonly">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                        <b><label>EFECTIVIDAD</label><br/></b>
                        <input id="a_efectividad" type="text" name="a_efectividad" class="form-control" style="font-weight:bold" readonly="readonly">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="tableFees" class="compact hover nowrap row-border">
                    <thead>
                        <tr>
                            <th class="no-order fit">#ITEM</th>
                            <th>CREDITO</th>
                            <th>CLIENTE</th>
                            <th>FECHA</th>
                            <th>Nº</th>
                            <th>$ CUOTA</th>
                            <th>PAGADO</th>
                            <th>MOTIVO</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>                    
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                        <b><label>META</label><br/></b>
                        <input id="a_meta2" type="text" style="font-weight:bold" readonly="readonly" value="0" class="form-control">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                        <b><label>COBRADO</label><br/></b>
                        <input id="a_cobrado2" type="text" style="font-weight:bold" class="form-control" value="0" readonly="readonly">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-2">
                        <b><label>EFECTIVIDAD</label><br/></b>
                        <input id="a_efectividad2" type="text" style="font-weight:bold" class="form-control" readonly="readonly">
                    </div>
                </div>                  
            </div>            
        </div>
    </div>
</div>
