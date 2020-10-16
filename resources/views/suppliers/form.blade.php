{{ csrf_field() }}
@include('errors')
<input type="hidden" name="id" @if(isset($supplier)) value="{{ $supplier->id }}" @else value="0" @endif>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include("commons.asterix-sm")<label>CUIT</label>
        <input type="text" name="code" maxlength="11" class="form-control" placeholder="CUIT"
            @if(isset($supplier)) value="{{ $supplier->code }}" @else value="{{ old('code') }}" @endif>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include("commons.asterix-sm")<label>Razón Social</label>
        <input type="text" name="name" class="form-control" placeholder="Nombre"
            @if(isset($supplier)) value="{{ $supplier->name }}" @else value="{{ old('name') }}" @endif>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Nombre de fantasía</label>
        <input type="text" name="business_name" class="form-control" placeholder="Fantasía"
            @if(isset($supplier)) value="{{ $supplier->business_name }}" @else value="{{ old('business_name') }}" @endif>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Dirección</label>
        <input type="text" name="address" class="form-control" placeholder="Dirección"
            @if(isset($supplier)) value="{{ $supplier->address }}" @else value="{{ old('address') }}" @endif>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>País</label>
        <select class="selectpicker show-tick" name="country_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($countries as $country)
                <option value="{{$country->id}}" @if((isset($supplier) && $supplier->country_id == $country->id) || $country->name == 'ARGENTINA') selected @endif>{{$country->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Provincia</label>
        <select class="selectpicker show-tick" name="province_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($provinces as $province)
                <option value="{{$province->id}}" @if((isset($supplier) && $supplier->province_id == $province->id) || (old('province_id') == $province->id)) selected @endif>{{$province->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Departamento</label>
        <select class="selectpicker show-tick" name="district_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($districts as $district)
                <option value="{{$district->id}}" @if((isset($supplier) && $supplier->district_id == $district->id) || (old('district_id') == $district->id)) selected @endif>{{$district->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Localidad</label>
        <select class="selectpicker show-tick" name="town_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($towns as $town)
                <option value="{{$town->id}}" @if((isset($supplier) && $supplier->town_id == $town->id) || (old('town_id') == $town->id)) selected @endif>{{$town->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Barrio</label>
        <select class="selectpicker show-tick" name="neighborhood_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($neighborhoods as $neighborhood)
                <option value="{{$neighborhood->id}}" @if((isset($supplier) && $supplier->neighborhood_id == $neighborhood->id) || (old('neighborhood_id') == $neighborhood->id)) selected @endif>{{$neighborhood->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Teléfono</label>
        <input type="text" name="phone" class="form-control" placeholder="Teléfono"
            @if(isset($supplier)) value="{{ $supplier->phone }}" @else value="{{ old('phone') }}" @endif>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Email</label>
        <input type="text" name="email" class="form-control" placeholder="Email"
            @if(isset($supplier)) value="{{ $supplier->email }}" @else value="{{ old('email') }}" @endif>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>Viajante</label>
        <select class="selectpicker show-tick" name="traveler_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($travelers as $traveler)
                <option value="{{$traveler->id}}" @if((isset($supplier) && $supplier->traveler_id == $traveler->id) || (old('traveler_id') == $traveler->id)) selected @endif>{{$traveler->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <label>Comentarios</label>
        <textarea id="autosize" name="comments" class="form-control" rows="1" style="resize: vertical; min-height: 40px;" placeholder="Comentarios">@if(isset($supplier)){{$supplier->comments}}@else{{old('comments')}}@endif</textarea>
    </div>
</div>
