{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($neighborhood)) value="{{ $neighborhood->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Localidad</label>
    <select class="selectpicker show-tick" name="town_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
        @php $district_id;@endphp
        @foreach($towns as $town)
            @if ($loop->first)
                <optgroup label="{{$town->district->name}}">
                @php 
                    $district_id = $town->district_id;
                @endphp
            @else
                @if($district_id !== $town->district_id)
                </optgroup>
                <optgroup label="{{$town->district->name}}">
                    @php 
                        $district_id = $town->district_id;
                    @endphp
                @endif
            @endif
            <option value="{{$town->id}}" @if((isset($neighborhood) && $neighborhood->town_id == $town->id) || (old('town_id') == $town->id)) selected @endif>{{$town->name}}</option>
        @endforeach
        </optgroup>
    </select>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($neighborhood)) value="{{ $neighborhood->name }}" @else value="{{ old('name') }}" @endif>
</div>