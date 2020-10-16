@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Nuevo</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="/kinships">
                @include('kinships.form')
                <hr>
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('kinships.index') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>
@endsection