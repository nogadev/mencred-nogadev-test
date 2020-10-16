{{ csrf_field() }}
@include('errors')
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($user)) value="{{ $user->name }}" @else value="{{ old('name') }}" @endif>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Email</label>
    <input type="email" name="email" class="form-control" placeholder="Email"
           @if(isset($user)) value="{{ $user->email }}" @else value="{{ old('email') }}" @endif>
</div>