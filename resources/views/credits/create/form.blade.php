{{ csrf_field() }}
@include('errors')
<div id="error_div" style="display:none">
    <div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    </div>
</div>
<input type="hidden" name="id" @if(isset($credit)) value="{{ $credit->id }}" @else value="0" @endif>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include('commons.asterix-sm')<label>CLIENTE</label>
        <select name="customer_id" onchange="setCustomerData();" class="form-control form-control-sm">
            @foreach($customers as $customer)
            <option value="{{$customer->id}}" @if((isset($credit) && $credit->customer_id == $customer->id) ||
                (old('customer_id') == $customer->id)) selected @endif>{{$customer->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>RECORRIDO</label>
        <input type="text" name="route_name" class="form-control form-control-sm" placeholder="RECORRIDO"
            @if(isset($buy)) value="{{ $credit->customer->route_name }}" @else value="{{ old('route_name') }}" @endif
            readonly>
    </div>

    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include('commons.asterix-sm')<label>FECHA</label>
        <input type="text" id="created_date" name="created_date" class="datepicker form-control form-control-sm"
            placeholder="dd/mm/aaaa">
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include('commons.asterix-sm')<label>VENDEDOR</label>
        <select name="seller_id" id="seller_id" class="form-control form-control-sm">
            @foreach($sellers as $seller)
            <option value="{{$seller->id}}" @if((isset($credit) && $credit->seller_id == $seller->id) ||
                (old('seller_id') == $seller->id)) selected @endif>{{$seller->name}}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include('commons.asterix-sm')<label>ENTREGA</label>
        <select name="delivery_id" class="form-control form-control-sm">
            @foreach($deliveries as $delivery)
            <option value="{{$delivery->id}}" @if((isset($credit) && $credit->delivery_id == $delivery->id) ||
                (old('delivery_id') == $delivery->id)) selected @endif>{{$delivery->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include('commons.asterix-sm')<label>DEPOSITO</label>
        <select name="store_id" id="store_id" onchange="getProducts();" class="form-control form-control-sm">
            @foreach($stores as $store)
            <option value="{{$store->id}}" @if((isset($credit) && $credit->store_id == $store->id) || $store->name == "CENTRAL" ))  selected @endif>{{$store->name}} </option>
            @endforeach
        </select>
    </div>


</div>


<div class="row">


    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include('commons.asterix-sm')<label>EMPRESA</label>
        <select name="company_id" onchange="getProducts();" id="company_id" class="form-control form-control-sm">
            @foreach($companies as $company)
            <option value="{{$company->id}}" @if((isset($credit) && $credit->company_id == $company->id) ||
                (old('company_id') == $company->id)) selected @endif>{{$company->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
        @include('commons.asterix-sm')<label>OBSERVACIONES</label>
        <input type="text" name="observation" class="form-control form-control-sm" placeholder="OBSERVACIONES"
            @if(isset($credit)) value="{{ $credit->observation }}" @else value="{{ old('observation') }}" @endif>
    </div>
</div>

<br>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card border-primary">
            <div class="card-header">

                <div class="row">
                    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        @include('commons.asterix-sm')<label>ARTICULO</label>
                        {!! Form::text('a_id', '',[ 'id' => 'a_id','disabled' => 'disabled', 'placeholder' => 'BUSCAR',
                        'autocomplete' => 'off' , 'class'=>'typeahead form-control form-control-sm']); !!}
                        {!! Form::hidden('article_id' , '', ['id' => 'article_id']) !!}
                        {!! Form::hidden('article_description' , '', ['id' => 'article_description']) !!}
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-1">
                        @include("commons.asterix-sm")<label>Nº SERIE</label><br />
                        <input id="serial_number" type="text" name="serial_number" class="form-control form-control-sm"
                            placeholder="Serie">
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        @include('commons.asterix-sm')<label>PTO VENTA</label>
                        <select id="point_of_sale_id" name="point_of_sale_id" onchange="getPriceByPointOfSale();"
                            class="form-control form-control-sm" >
                            @foreach($pointOfSale as $point)
                            <option value="{{$point->id}}" @if(isset($point) && $point->name == "GENERAL") selected @endif>{{$point->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-1">
                        @include("commons.asterix-sm")<label>PRECIO</label><br />
                        <input id="a_price" type="text" name="a_price" placeholder="0,00 $" onblur="calculate();"
                            class="form-control form-control-sm">
                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>CANT</label><br />
                        <input id="a_quantity" type="text" name="a_quantity" class="form-control form-control-sm"
                            placeholder="CANT" onblur="calculate();">
                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <label>$ SUBTOTAL</label><br />
                        <input id="a_subtotal" type="text" name="a_subtotal" class="form-control form-control-sm"
                            placeholder="0,00 $" readonly>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label></label><br />
                        <button id='addArtBtn' type="button" class="btn btn-success btn-block"
                            onclick="AddArticle();">+</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="tableArticles" class="display">
                    <thead>
                        <tr>
                            <th class="no-order fit">#</th>
                            <th>CODIGO</th>
                            <th>DESCRIPCION</th>
                            <th>Nº SERIE</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>$ SUBTOTAL</th>
                            <th class="no-order no-search fit"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>CUOTAS</label><br />
                        <input id="fee_quantity" type="text" placeholder="0" name="fee_quantity" class="form-control form-control-sm">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>$ CUOTA</label><br />
                        <input id="fee_amount" type="text" placeholder="0,00 $" name="fee_amount" class="form-control form-control-sm">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <label>P. INICIAL</label><br />
                        <input id="init_pay" type="text" placeholder="0,00 $" name="init_pay" class="form-control form-control-sm">
                    </div>

                    <div class="col-xs-12 col-sm-12 offset-md-1 col-md-1 offset-lg-6 col-lg-3">
                        <label>TOTAL</label><br />
                        <input id="total" type="text" placeholder="0,00 $" name="total_amount" class="form-control form-control-sm" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<textarea name="art_data" id="art_data" style="display: none;"></textarea>
