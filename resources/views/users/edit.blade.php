@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Modificar usuario</h3>
        <h5><a href="{{ route('users.index') }}" class="undecorated">Listar usuarios</a></h5>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="{{route('users.update', $user)}}">
                {{ method_field('PUT') }}
                @include('users.form')
                <hr>
                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection