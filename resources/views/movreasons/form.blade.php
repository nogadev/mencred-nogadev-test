{{ csrf_field() }}
@include('errors')
<input type="hidden" name="id" @if(isset($mov_reason)) value="{{ $mov_reason->id }}" @else value="0" @endif>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>TIPO</label>
        <select class="selectpicker show-tick" name="mov_type_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($mov_types as $type)
                <option value="{{$type->id}}" @if((isset($mov_reason) && $mov_reason->mov_type_id == $type->id) || (old('mov_type_id') == $type->id)) selected @endif>{{$type->description}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>DESCRIPCION</label>
        <input type="text" name="description" maxlength="35" class="form-control" placeholder="DESCRIPCION"
               @if(isset($mov_reason)) value="{{ $mov_reason->description }}" @else value="{{ old('description') }}" @endif>
    </div>
</div>