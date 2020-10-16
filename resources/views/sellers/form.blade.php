{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($seller)) value="{{ $seller->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>NOMBRE</label>
    <input type="text" name="name" class="form-control" placeholder="NOMBRE"
           @if(isset($seller)) value="{{ $seller->name }}" @else value="{{ old('name') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>META</label>
    <input type="text" name="goal" class="form-control" placeholder="META"
           @if(isset($seller)) value="{{ $seller->goal }}" @else value="{{ old('goal') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>COMISION</label>
    <input type="text" name="commission" class="form-control" placeholder="COMISION"
           @if(isset($seller)) value="{{ $seller->commission }}" @else value="{{ old('commission') }}" @endif>
</div>