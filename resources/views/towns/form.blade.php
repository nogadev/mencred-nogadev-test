{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($town)) value="{{ $town->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Departamento</label>
    <select class="selectpicker show-tick" name="district_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
        @php $province_id;@endphp
        @foreach($districts as $district)
            @if ($loop->first)
            <optgroup label="{{$district->province->name}}">
                @php 
                    $province_id = $district->province_id;
                @endphp
            @else
                @if($province_id !== $district->province_id)
                </optgroup>
                <optgroup label="{{$district->province->name}}">
                    @php 
                        $province_id = $district->province_id;
                    @endphp
                @endif
            @endif
            <option value="{{$district->id}}" @if((isset($town) && $town->district_id == $district->id) || (old('district_id') == $district->id)) selected @endif>{{$district->name}}</option>
        @endforeach
        </optgroup>
    </select>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($town)) value="{{ $town->name }}" @else value="{{ old('name') }}" @endif>
</div>