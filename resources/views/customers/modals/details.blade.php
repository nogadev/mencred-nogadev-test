<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETALLE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="tableArticles">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>DETALLE</th>
                            <th>SERIE</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>IMPORTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <label>OBSERVACIONES</label><br/>
                    <textarea id="observation_modal" type="text" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="setObservation();">GUARDAR</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>