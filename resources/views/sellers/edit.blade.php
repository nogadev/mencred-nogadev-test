@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Modificar datos de vendedor</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="{{route('sellers.update', $seller)}}">
                {{ method_field('PUT') }}
                @include('sellers.form')
                <hr>
                <button type="submit" class="btn btn-success">MODIFICAR</button>
                <a href="{{ route('sellers.index') }}" class="btn btn-danger">CANCELAR</a>
            </form>
        </div>
    </div>
@endsection
