{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($district)) value="{{ $district->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Provincia</label>
    <select class="selectpicker show-tick" name="province_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
        @php $country_id;@endphp
        @foreach($provinces as $province)
            @if ($loop->first)
                <optgroup label="{{$province->country->name}}">
                @php 
                    $country_id = $province->country_id;
                @endphp
            @else
                @if ($country_id !== $province->country_id)
                </optgroup>
                <optgroup label="{{$province->country->name}}">
                    @php 
                        $country_id = $province->country_id;
                    @endphp
                @endif
            @endif
            <option value="{{$province->id}}" @if((isset($district) && $district->province_id == $province->id) || (old('province_id') == $province->id)) selected @endif>{{$province->name}}</option>
        @endforeach
        </optgroup>
    </select>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($district)) value="{{ $district->name }}" @else value="{{ old('name') }}" @endif>
</div>