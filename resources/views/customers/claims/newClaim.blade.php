@php
$types = ['FALTA DE PAGO','SERVICIO TECNICO','AMBOS','ARMADO DE MUEBLES','CONSTANCIAS DE PAGARE ENTREGADO','OTRO'];
@endphp
<div class="modal fade" id="newClaimModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">RECLAMO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        @include("commons.asterix-sm")<label>TIPO</label>
                        <select name="newClaimType" id="newClaimType"> 
                            @foreach($types as $type)
                                <option value="{{$type}}" >{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>FECHA</label>
                        <input type="text" name="newClaimDateInit" id="newClaimDateInit" class="datepicker form-control form-control-sm" placeholder="FECHA" value="{{date('d/m/Y')}}"/>
                    </div>
                </div>     
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include("commons.asterix-sm")<label>OBSERVACION</label>
                        <textarea class="form-control form-sm" id="newClaimObservation"></textarea>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="storeNewClaim();">GUARDAR</button>
            </div>
        </div>
    </div>
</div>