<div class="modal fade" id="mercadoPagoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PAGO CON MERCADO PAGO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="mercadopago_credit_id" value="" />
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>Nº</label>
                        <input type="text" id="mercadopago_number" class="form-control" placeholder="Numero">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>MONTO</label>
                        <input type="number" id="mercadopago_amount" class="form-control" placeholder="Importe">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="setMercadoPagoToFee();">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
