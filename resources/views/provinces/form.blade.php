{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($province)) value="{{ $province->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>País</label>
    <select class="selectpicker show-tick form-control" name="country_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
        @foreach($countries as $country)
            <option value="{{$country->id}}" @if((isset($province) && $province->country_id == $country->id) || (old('country_id') == $country->id)) selected @endif>{{$country->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($province)) value="{{ $province->name }}" @else value="{{ old('name') }}" @endif>
</div>