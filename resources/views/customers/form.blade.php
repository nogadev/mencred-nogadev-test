{{ csrf_field() }}
@include('errors')
<div id="error_div" style="display:none">
    <div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    </div>
</div>

<input type="hidden" name="id" @if(isset($customer)) value="{{ $customer->id }}" @else value="0" @endif>

<div class="row">
    <div class="form-group col-md-4">

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>NOMBRE</label></div>
            <div class="col-md-7">
                <input type="text" name="name" class="form-control form-control-sm" placeholder="NOMBRE"
                    @if(isset($customer)) value="{{ $customer->name }}" @else value="{{ old('name') }}" @endif>
            </div>
        </div>

        <div class="form-group row" >
            <div class="col-md-4">@include("commons.asterix-sm")<label>COMERCIO</label></div>
            <div class="col-md-7" >
                <select name="commerce_id" class="form-control form-control-sm">
                    @foreach($commerces as $commerce)
                        <option value="{{$commerce->id}}" @if((isset($customer) && $customer->commerce_id == $commerce->id) || (old('commerce_id') == $commerce->id)) selected @endif>{{$commerce->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>DIR COM</label></div>
            <div class="col-md-7">
                <input type="text" name="commercial_address" class="form-control form-control-sm" placeholder="DIRECCIÓN COMERCIAL"
                @if(isset($customer)) value="{{ $customer->commercial_address }}" @else value="{{ old('commercial_address') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>DPTO COM</label></div>
            <div class="col-md-7">
                <select name="commercial_district_id" class="form-control form-control-sm">
                    @foreach($districts as $district)
                        <option value="{{$district->id}}" @if((isset($customer) && $customer->commercial_district_id == $district->id) || (old('commercial_district_id') == $district->id)) selected @endif>{{$district->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>LOC COM</label></div>
            <div class="col-md-7">
                 <select name="commercial_town_id" class="form-control form-control-sm">
                    @foreach($towns as $town)
                        <option value="{{$town->id}}" @if((isset($customer) && $customer->commercial_town_id == $town->id) || (old('commercial_town_id') == $town->id)) selected @endif>{{$town->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>BARRIO COM</label></div>
            <div class="col-md-7" class="form-control form-control-sm">
                <select name="commercial_neighborhood_id" class="form-control form-control-sm">
                    @foreach($neighborhoods as $neighborhood)
                        <option value="{{$neighborhood->id}}" @if((isset($customer) && $customer->commercial_neighborhood_id == $neighborhood->id) || (old('commercial_neighborhood_id') == $neighborhood->id)) selected @endif>{{$neighborhood->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>E CALLES</label></div>
            <div class="col-md-7">
                <input type="text" name="commercial_between" class="form-control form-control-sm" placeholder="ENTRE CALLES"
            @if(isset($customer)) value="{{ $customer->commercial_between }}" @else value="{{ old('commercial_between') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>DIR PER</label></div>
            <div class="col-md-7">
                <input type="text" name="personal_address" class="form-control form-control-sm" placeholder="DIRECCIÓN PARTICULAR"
                @if(isset($customer)) value="{{ $customer->personal_address }}" @else value="{{ old('personal_address') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>DPTO PER</label></div>
            <div class="col-md-7">
                <select name="personal_district_id" class="form-control form-control-sm">
                    @foreach($districts as $district)
                        <option value="{{$district->id}}" @if((isset($customer) && $customer->personal_district_id == $district->id) || (old('personal_district_id') == $district->id)) selected @endif>{{$district->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>LOC PER</label></div>
            <div class="col-md-7">
                <select name="personal_town_id" class="form-control form-control-sm">
                    @foreach($towns as $town)
                        <option value="{{$town->id}}" @if((isset($customer) && $customer->personal_town_id == $town->id) || (old('personal_town_id') == $town->id)) selected @endif>{{$town->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>BARRIO PER</label></div>
            <div class="col-md-7">
                <select name="personal_neighborhood_id" class="form-control form-control-sm">
                    @foreach($neighborhoods as $neighborhood)
                        <option value="{{$neighborhood->id}}" @if((isset($customer) && $customer->personal_neighborhood_id == $neighborhood->id) || (old('personal_neighborhood_id') == $neighborhood->id)) selected @endif>{{$neighborhood->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>E CALLES</label></div>
            <div class="col-md-7">
                <input type="text" name="personal_between" class="form-control form-control-sm" placeholder="ENTRE CALLES"
            @if(isset($customer)) value="{{ $customer->personal_between }}" @else value="{{ old('personal_between') }}" @endif>
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>DNI</label></div>
            <div class="col-md-7">
                <input type="text" name="doc_number" class="form-control form-control-sm" maxlength="8" placeholder="DOCUMENTO"
                    @if(isset($customer)) value="{{ $customer->doc_number }}" @else value="{{ old('doc_number') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>FEC NAC</label></div>
            <div class="col-md-7">
                <input type="text" name="birthday" class="datepicker form-control form-control-sm" placeholder="FECHA DE NACIMIENTO" @if(isset($customer)) value="{{ $customer->birthday->format('d/m/Y') }}" @else value="{{ old('birthday') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>HORARIO</label></div>
            <div class="col-md-7">
                <input type="text" name="horary" class="form-control form-control-sm" placeholder="HORARIO COMERCIAL"
                @if(isset($customer)) value="{{ $customer->horary }}" @else value="{{ old('horary') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>E. CIVIL</label></div>
            <div class="col-md-7">
                <select name="marital_status" class="form-control form-control-sm">
                    @foreach(['SIN DATOS','SOLTERO/A','CASADO/A','DIVORCIADO/A','CONCUBINO/A','VIUDO/A'] as $marital_status)
                        <option value="{{$marital_status}}" @if((isset($customer) && $customer->marital_status == $marital_status) || (old('marital_status') == $marital_status)) selected @endif>{{$marital_status}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>CONYUGE</label></div>
            <div class="col-md-7">
                 <input type="text" name="partner" class="form-control form-control-sm" placeholder="CONYUGE" @if(isset($customer)) value="{{ $customer->partner }}" @else value="{{ old('partner') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>TEL PART</label></div>
            <div class="col-md-7">
                <input type="text" name="particular_tel" class="form-control form-control-sm" placeholder="TEL PARTICULAR"
            @if(isset($customer)) value="{{ $customer->particular_tel }}" @else value="{{ old('particular_tel') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>TEL COM</label></div>
            <div class="col-md-7">
                <input type="text" name="comercial_tel" class="form-control form-control-sm" placeholder="TEL COMERCIAL"
            @if(isset($customer)) value="{{ $customer->comercial_tel }}" @else value="{{ old('comercial_tel') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>TEL CONTACTO</label></div>
            <div class="col-md-7">
                <input type="text" name="contact_tel" class="form-control form-control-sm" placeholder="TEL CONTACTO"
                @if(isset($customer)) value="{{ $customer->contact_tel }}" @else value="{{ old('contact_tel') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>CUIT</label></div>
            <div class="col-md-7">
                <input type="text" name="cuit" class="form-control form-control-sm" maxlength="11" placeholder="CUIT" @if(isset($customer)) value="{{ $customer->cuit }}" @else value="{{ old('cuit') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>CATEGORIA</label></div>
            <div class="col-md-7">
                <select name="customer_category_id" class="form-control form-control-sm">
                    @foreach($customercategories as $category)
                        <option value="{{$category->id}}" @if((isset($customer) && $customer->customer_category_id == $category->id) || (old('commerce_id') == $category->id)) selected @endif>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>CONTACTO</label></div>
            <div class="col-md-7">
                <input type="text" name="contact" class="form-control form-control-sm" placeholder="CONTACTO"
            @if(isset($customer)) value="{{ $customer->contact }}" @else value="{{ old('contact') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>PARENTESCO</label></div>
            <div class="col-md-7">
                <select name="kinship_id" class="form-control form-control-sm">
                    @foreach($kinships as $kinship)
                        <option value="{{$kinship->id}}" @if((isset($customer) && $customer->kinship_id == $kinship->id) || (old('kinship_id') == $kinship->id)) selected @endif>{{$kinship->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>RECORRIDO</label></div>
            <div class="col-md-7">
                <select name="route_id" class="form-control form-control-sm">
                    @foreach($routes as $route)
                        <option value="{{$route->id}}" @if((isset($customer) && $customer->route_id == $route->id) || (old('route_id') == $route->id)) selected @endif>{{$route->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>ANTIGUEDAD</label></div>
            <div class="col-md-7">
                <input type="text" name="antiquity" class="datepicker form-control form-control-sm" placeholder="ANTIGÜEDAD" @if(isset($customer)) value="{{ $customer->antiquity ? $customer->antiquity->format('d/m/Y') : '' }}" @else value="{{ old('antiquity') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">@include("commons.asterix-sm")<label>VENDEDOR</label></div>
            <div class="col-md-7">
                <select name="seller_id" class="form-control form-control-sm">
                    @foreach($sellers as $seller)
                        <option value="{{$seller->id}}" @if((isset($customer) && $customer->seller_id == $seller->id) || (old('seller_id') == $seller->id)) selected @endif>{{$seller->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>EMAIL</label></div>
            <div class="col-md-7">
                <input type="text" name="email" class="form-control form-control-sm" placeholder="EMAIL" @if(isset($customer)) value="{{ $customer->email }}" @else value="{{ old('email') }}" @endif>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>EFECTIVIDAD</label></div>
            <div class="col-md-7">
                <input type="text" name="efectividad" class="form-control form-control-sm weight" placeholder="0.00" @if(isset($customer)) value="{{$customer->efectivity() }}%" @endif readonly="readonly">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>PROPIETARIO</label></div>
            <div class="col-md-7">
                <input name="owner" type="checkbox" @if(isset($customer) && $customer->owner == 1) checked="checked" @elseif(old('owner') == 1) checked="checked" @endif value="1">
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-4"><label>MOROSO</label></div>
            <div class="col-md-7">
                <input name="defaulter" type="checkbox" @if(isset($customer) && $customer->defaulter == 1) checked="checked" @elseif(old('defaulter') == 1) checked="checked" @endif value="1">
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-4"><label>SALDO</label></div>
            <div class="col-md-7">
                <input type="text" name="saldo" class="form-control form-control-sm weight" placeholder="0.00" @if(isset($customer)) value="{{ number_format($customer->saldo(), 2,',','.') }} $" @endif readonly="readonly">

            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4"><label>OBSERVACIONES</label></div>
            <div class="col-md-7">

                <textarea type="text" name="observation" class="form-control form-control-sm" placeholder="OBSERVACIONES">@if(isset($customer)){{$customer->observation}}@else{{old('observation')}}@endif</textarea>

            </div>
        </div>

    </div>
</div>
