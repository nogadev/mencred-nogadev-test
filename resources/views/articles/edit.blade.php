@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
@endsection
@section('content')
    <div class="container">
        <h3>Modificar datos de un Artículo</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form method="post" action="{{route('articles.update', $article)}}">
                {{ method_field('PUT') }}
                @include('articles.form')
                <hr>
                <button type="submit" class="btn btn-success">MODIFICAR</button>
                <a href="{{ route('articles.index') }}" class="btn btn-danger">CANCELAR</a>
            </form>
        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('articles.js')
@endsection
