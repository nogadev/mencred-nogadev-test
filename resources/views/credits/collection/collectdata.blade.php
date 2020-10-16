<div class="modal fade" id="methodsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">METODO DE COBRANZA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <section class="section-preview">

                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="groupOfDefaultRadios" value="1"  checked>
                            <label class="custom-control-label" for="defaultGroupExample1">EFECTIVO</label>
                        </div>

                        <!-- Group of default radios - option 2 -->
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="groupOfDefaultRadios" value="4">
                            <label class="custom-control-label" for="defaultGroupExample2">BANCO</label>
                        </div>

                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="saveConfirm()">CONFIRMAR</button>
                <button type="submit" class="btn btn-danger" onclick="saveCancel()">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
