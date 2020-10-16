<div class="modal fade" id="paycheckModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PAGO CON CHEQUE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="paycheck_credit_id" value="" />
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>BANCO:</label>
                        <select name="paycheck_bank" id="paycheck_bank"
                                class="form-control form-control-sm">
                            @foreach($banks as $bank)
                                @if($bank->id != 1)
                                <option value="{{$bank->id}}">{{$bank->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>Nº</label>
                        <input type="text" id="paycheck_number" class="form-control" placeholder="Numero">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>MONTO</label>
                        <input type="number" id="paycheck_amount" class="form-control" placeholder="Importe">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>FECHA COBRO</label>
                        <input type="text" id="paycheck_paymentdate" class="datepicker form-control" placeholder="Fecha de cobro">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>RAZON SOCIAL</label>
                        <input type="text" id="paycheck_owner_name" class="form-control" placeholder="Razón social">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="setPaycheckToFee();">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
