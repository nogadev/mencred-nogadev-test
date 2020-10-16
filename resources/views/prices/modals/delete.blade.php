<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">ELIMINAR PRECIO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>¿Desea eliminar el siguiente precio?</span>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-12">
                        <label>Artículo:</label>
                        <input type="text" name="article_delete_name" id="article_delete_name"
                               class="form-control form-control-sm" value=""/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-12">
                        <table class="table table-active" id="table">
                            <thead>
                            <tr>
                                <th>PUNTO DE VENTA</th>
                                <th>PRECIO</th>
                                <th>CUOTAS</th>
                                <th>$ CUOTA</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="delete_point_of_sales">a</td>
                                <td id="delete_price">a</td>
                                <td id="delete_fee_quantity">a</td>
                                <td id="delete_fee_amount">a</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <form method="post" id="deletePriceForm" autocomplete="off"
                      action="{{route('articles.price.destroy')}}">
                    @method('delete')
                    @csrf
                    <input type="hidden" name="article_delete_id" id="article_delete_id" value="0"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="deletePrice()">ELIMINAR</button>
                <button type="button" class="btn btn-danger" onclick="cancelModal()">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
