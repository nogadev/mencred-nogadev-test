{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($buy)) value="{{ $buy->id }}" @else value="0" @endif>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        @include('commons.asterix-sm')<label>Proveedor</label>
        <select name="supplier_id" onchange="setSupplierData();" class="form-control form-control-sm">
            @foreach($suppliers as $supplier)
                <option value="{{$supplier->id}}" @if((isset($buy) && $buy->supplier_id == $supplier->id) || (old('supplier_id') == $supplier->id)) selected @endif>{{$supplier->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <label>Nombre Fantasia</label>
        <input type="text" name="business_name" class="form-control form-control-sm" placeholder="Razón social"
            @if(isset($buy)) value="{{ $buy->supplier->business_name }}" @else value="{{ old('business_name') }}" @endif readonly>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <label>CUIT</label>
        <input type="text" name="code" class="form-control form-control-sm" placeholder="CUIT"
            @if(isset($buy)) value="{{ $buy->supplier->code }}" @else value="{{ old('code') }}" @endif readonly>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <label>Dirección</label>
        <input type="text" name="address" class="form-control form-control-sm" placeholder="Dirección"
            @if(isset($buy)) value="{{ $buy->supplier->address }}" @else value="{{ old('address') }}" @endif readonly>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        @include('commons.asterix-sm')<label>Fecha</label>
        <input type="text" id="date" name="date" class="form-control form-control-sm" placeholder="dd/mm/aaaa">
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        @include('commons.asterix-sm')<label>Tipo de comprobante</label>
        <select name="voucher_type_id" class="form-control form-control-sm">
            @foreach($voucherTypes as $voucherType)
                <option value="{{$voucherType->id}}" @if((isset($buy) && $buy->voucher_type_id == $voucherType->id) || (old('voucher_type_id') == $voucherType->id)) selected @endif>{{$voucherType->description}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="row">
            <div class="form-group col-xs-6 col-sm-6 col-md-5 col-lg-5">
                @include('commons.asterix-sm')<label>Pto. vta.</label>
                <input type="text" name="subsidiary_number" class="form-control form-control-sm" placeholder="Pto. Vta."
                    @if(isset($buy)) value="{{ $buy->subsidiary_number }}" @else value="{{ old('subsidiary_number') }}" @endif>
            </div>
            <div class="form-group col-xs-6 col-sm-6 col-md-7 col-lg-7">
                @include('commons.asterix-sm')<label>N°</label>
                <input type="text" name="voucher_number" class="form-control form-control-sm" placeholder="N°"
                    @if(isset($buy)) value="{{ $buy->voucher_number }}" @else value="{{ old('voucher_number') }}" @endif>
            </div>
        </div>        
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        @include('commons.asterix-sm')<label>Empresa</label>
        <select name="company_id" class="form-control form-control-sm">
            @foreach($companies as $company)
                <option value="{{$company->id}}" @if((isset($buy) && $buy->company_id == $company->id) || (old('company_id') == $company->id)) selected @endif>{{$company->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        @include('commons.asterix-sm')<label>Percepción IIBB</label>
        <input type="text" name="perception_iibb" class="form-control form-control-sm" placeholder="Percepción IIBB" @if(isset($buy)) value="{{ $buy->perception_iibb }}" @else value="{{ old('perception_iibb') }}" @endif>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card border-primary">
            <div class="card-header">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        @include('commons.asterix-sm')<label>Artículo</label>
                        <select name="a_id" class="form-control form-control-sm">
                            @foreach($articles as $article)
                            <option value="{{$article->id}}" data-subtext="Cod: {{$article->id}}; Barras: {{$article->barcode}}">{{$article->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        @include("commons.asterix-sm")<label>Cant.</label><br/>
                        <input id="a_quantity" type="text" name="a_quantity" class="form-control form-control-sm" placeholder="Cant." onblur="calculate('a_quantity');">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        @include("commons.asterix-sm")<label>$ Neto</label><br/>
                        <input id="a_net" type="text" name="a_net" class="form-control form-control-sm" placeholder="0,00 $" onblur="calculate('a_net');">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>% Desc.</label><br/>
                        <input id="a_bonus_p" type="text" name="a_bonus_p" class="form-control form-control-sm" placeholder="% Desc." onblur="calculate('a_bonus_p');">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>$ Desc.</label><br/>
                        <input id="a_bonus" type="text" name="a_bonus" class="form-control form-control-sm" placeholder="0,00 $" onblur="calculate('a_bonus');">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        @include('commons.asterix-sm')<label>% IVA</label><br/>
                        <select class="selectpicker show-tick form-control form-control-sm" id="a_tax_p" data-live-search="true"  title="Sel" data-width="100%" data-style="btn-info" onchange="calculate('a_tax_p');">
                            @foreach($taxes as $tax)
                                <option value="{{$tax->value}}">{{$tax->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>$ IVA</label><br/>
                        <input id="a_tax" type="text" name="a_tax" class="form-control form-control-sm" placeholder="$ IVA" readonly>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>$ Subt.</label><br/>
                        <input id="a_subtotal" type="text" name="a_subtotal" class="form-control form-control-sm" placeholder="$ Subt." readonly>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label></label><br/>
                        <button id='addArtBtn' type="button" class="btn btn-success btn-block" onclick="canAddArticle();">+</button>
                    </div>
                </div>            
            </div>
            <div class="card-body">
                <table id="tableArticles" class="compact hover nowrap row-border">
                    <thead>
                        <tr>
                            <th class="no-order fit">#Item</th>
                            <th>Artículo</th>
                            <th>Cantidad</th>
                            <th>$ Neto</th>
                            <th>$ Desc.</th>
                            <th>$ IVA</th>
                            <th>$ Subtotal</th>
                            <th class="no-order no-search fit"></th>
                        </tr>
                    </thead>
                    <tbody>                    
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    @for ($i = 1; $i <= 3; $i++)   
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label id="lbl_net_{{$i}}">Neto</label><br/>
                            <input id="net_{{$i}}" type="text" name="net_{{$i}}" class="form-control form-control-sm" readonly>
                        </div>                
                        <div class="col-xs-12 col-sm-12 col-md-1">
                            <label id="lbl_tax_{{$i}}">Iva</label><br/>
                            <input id="tax_{{$i}}" type="text" name="tax_{{$i}}" class="form-control form-control-sm" readonly>
                        </div>              
                    @endfor
                    <div class="col-xs-12 col-sm-12 offset-md-1 col-md-1 offset-lg-4 col-lg-2">
                        <label>Total</label><br/>
                        <input id="total" type="text" name="total" class="form-control form-control-sm" readonly>
                    </div>
                </div>                    
            </div>            
        </div>
    </div>
</div>
<textarea name="art_data" id="art_data" style="display: none;"></textarea>