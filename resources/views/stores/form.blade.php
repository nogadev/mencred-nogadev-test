{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($store)) value="{{ $store->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($store)) value="{{ $store->name }}" @else value="{{ old('name') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <label>Direccion</label>
    <input type="text" name="address" class="form-control" placeholder="Direccion"
           @if(isset($store)) value="{{ $store->address }}" @else value="{{ old('address') }}" @endif>
</div>