<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETALLE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="paycheck_credit_id" value="" />
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>DETALLE</label>
                        <textarea type="text" id="description_check_box" class="form-control" placeholder="Detalle del cheque"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="getOutBtn" class="btn btn-success">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
