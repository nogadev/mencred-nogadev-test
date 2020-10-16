<div class="modal fade" id="feesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CUOTAS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table table-striped mb-0" id="tableFees">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th>FECHA</th>
                            <th>PAGADO</th>
                            <th>IMPORTE</th>
                            <th>MOTIVO</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-3">
                        <label>TOTAL</label><br/>
                        <input id="total_modal" type="text" readonly="readonly" class="form-control">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-3">
                        <label>PAGADO</label><br/>
                        <input id="paid_modal" type="text" class="form-control"  readonly="readonly">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-3">
                        <label>SALDO</label><br/>
                        <input id="balance_modal" type="text" class="form-control font-weight-bold" readonly="readonly" >
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-3">
                        <label>EFECTIVIDAD</label><br/>
                        <input id="efectivity_modal" type="text" class="form-control font-weight-bold" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="linkPrint" target="_blank"><button type="button" class="btn btn-warning">IMPRIMIR</button></a>
                <button type="button" class="btn btn-success" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
