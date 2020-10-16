@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Modificar datos de una entrega</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="{{route('deliveries.update', $delivery)}}">
                {{ method_field('PUT') }}
                @include('deliveries.form')
                <hr>
                <button type="submit" class="btn btn-success">Modificar</button>
                <a href="{{ route('deliveries.index') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
