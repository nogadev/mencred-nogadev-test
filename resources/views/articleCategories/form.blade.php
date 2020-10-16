{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($articleCategory)) value="{{ $articleCategory->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($articleCategory)) value="{{ $articleCategory->name }}" @else value="{{ old('name') }}" @endif>
</div>