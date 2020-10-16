<div class="modal fade" id="closeCashModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CERRAR CAJA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <section class="section-preview">
                        <span>DESEA CERRAR LA CAJA ACTUAL?</span>
                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success" href='{{route("cash.close")}}'>CONFIRMAR</a>
                <button type="submit" class="btn btn-danger" onclick="closeCashCancel()">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
