<div class="modal fade" id="mercadoPagoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">EGRESO DE MERCADO PAGO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="mercadopagoForm" autocomplete="off" action="">
                    {{ csrf_field() }}
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-12">
                            <div class="row">
                                <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <label>SALDO DISPONIBLE:</label>
                                    <input type="number" name="mp_balance_available" id="mp_balance_available" class="form-control"
                                           value="" readonly/>
                                </div>
                                <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <label>A PAGAR:</label>
                                    <input type="number" name="mp_payment_amount" id="mp_payment_amount" class="form-control"
                                           value=""/>
                                </div>
                            </div>
                        <div class="row">
                            <label>DETALLE:</label>
                            <input type="textarea" name="mp_description" id="mp_description" class="form-control"
                                   value="" placeholder="DESCRIPCIÓN"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="usarMercadoPago">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>