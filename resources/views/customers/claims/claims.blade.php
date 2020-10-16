<div class="modal fade" id="claimModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">RECLAMOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div>
                <button href="#" id="lnkNuevoReclamo" type="button" class="btn btn-md btn-info" style="margin: 2%;">NUEVO</button>
            </div>
            {{ csrf_field() }}
            <input type="hidden" id="claim_id" value=""/>
            <input type="hidden" id="credit_id" value=""/>
            <div class="modal-body table-wrapper-scroll-y my-custom-scrollbar">
                <table class="display" id="tableClaims">
                    <thead>
                        <tr>
                            <th></th>
                            <th>TIPO</th>
                            <th>INICIO</th>
                            <th>FIN</th>
                            <th>ESTADO</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
@include('customers.claims.newClaim')