@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
@endsection
@section('content')
    <div class="container">
        <h3>Nuevo</h3>
        <hr>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form id="attributesForm" method="post" action="/attributes">
                @include('attributes.form')
                <hr>
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="{{ route('attributes.index') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
@section('custom_scripts')
    @include('bootstrap-select.script')
    @include('attributes.jscreate')
@endsection