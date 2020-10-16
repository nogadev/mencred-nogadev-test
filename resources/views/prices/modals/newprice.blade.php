
<div class="modal fade" id="newPriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">AGREGAR PRECIO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="priceForm" autocomplete="off" action="{{route('articleprice.store')}}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label>ARTICULO:</label>
                            <input type="text" name="article" id="article" style="font-weight: bold;" class="form-control form-control-sm"
                                   value=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            @include("commons.asterix-sm")<label>PUNTO DE VENTA:</label>
                            <select name="point_of_sales_id" style="font-weight: bold;" id="point_of_sales_id"
                                    class="form-control form-control-sm">
                                @foreach($point_of_sales as $point)
                                    <option style="font-weight: bold;" value="{{$point->id}}">{{$point->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            @include("commons.asterix-sm")<label>LISTA Nº:</label>
                            <input type="text" style="font-weight: bold;" name="price_update_level" id="price_update_level" class="form-control form-control-sm"
                                   placeholder="LISTA Nº"
                                   @if(isset($article)) value="{{ $article->fee_amount }}" @else value="{{ old('fee_amount') }}" @endif
                            />
                            <input type="hidden" name="article_id" id="article_id" value="0"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            @include("commons.asterix-sm")<label>CUOTAS:</label>
                            <input type="number" style="font-weight: bold;" value="1" onblur="calculateFeeAmount()" name="fee_quantity" id="fee_quantity"
                                   class="form-control form-control-sm"
                                   placeholder="CANTIDAD DE CUOTAS"
                                   value=""
                            />

                        </div>
                        <div class="form-group col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            @include("commons.asterix-sm")<label>$ CUOTA:</label>
                            <input type="number" onblur="calculateFeeAmount()" style="font-weight: bold;" name="fee_amount" id="fee_amount" class="form-control form-control-sm"
                                   placeholder="$ CUOTA"
                                   @if(isset($article)) value="{{ $article->fee_amount }}" @else value="{{ old('fee_amount') }}" @endif
                            />
                            <input type="hidden" name="article_id" id="article_id" value="0"/>
                        </div>
                        <div class="form-group col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            @include("commons.asterix-sm")<label>$ TOTAL:</label>

                            <input type="number" style="font-weight: bold;" name="price" id="price"
                                   class="form-control form-control-sm"
                                   placeholder="PRECIO FINAL"
                                   @if(isset($article)) value="{{ $article->price }}" @else value="{{ old('price') }}" @endif
                            />
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" onclick="submitForm()">GUARDAR</button>
            </div>
        </div>
    </div>
</div>