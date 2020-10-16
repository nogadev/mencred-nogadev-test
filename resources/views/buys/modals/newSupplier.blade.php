<div class="modal fade" id="newSupplierModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        @include("commons.asterix-sm")<label>Código</label>
                        <input type="text" id="new_supplier_code" class="form-control" placeholder="Código">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>Nombre</label>
                        <input type="text" id="new_supplier_name" class="form-control" placeholder="Nombre">
                    </div>
                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="storeNewSupplier();">Guardar</button>
            </div>
        </div>
    </div>
</div>