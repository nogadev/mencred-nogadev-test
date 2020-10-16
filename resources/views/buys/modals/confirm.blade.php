<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        
                        @include('commons.asterix-sm')<label>Depósito de destino</label>
                        <select name="store_id">
                            @foreach($stores as $store)
                                <option value="{{$store->id}}" @if((isset($buy) && $buy->store_id == $store->id) || $store->name == "CENTRAL" ))  selected @endif>{{$store->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" {{-- onclick="$('#buyForm').submit();" --}}>Confirmar compra</button>
            </div>
        </div>
    </div>
</div>