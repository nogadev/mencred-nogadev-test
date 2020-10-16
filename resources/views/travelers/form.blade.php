{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($traveler)) value="{{ $traveler->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($traveler)) value="{{ $traveler->name }}" @else value="{{ old('name') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <label>Direccion</label>
    <input type="text" name="address" class="form-control" placeholder="Direccion"
           @if(isset($traveler)) value="{{ $traveler->address }}" @else value="{{ old('address') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <label>Telefono</label>
    <input type="text" name="telephone" class="form-control" placeholder="Telefono"
           @if(isset($traveler)) value="{{ $traveler->telephone }}" @else value="{{ old('telephone') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <label>Email</label>
    <input type="text" name="email" class="form-control" placeholder="Email"
           @if(isset($traveler)) value="{{ $traveler->email }}" @else value="{{ old('email') }}" @endif>
</div>