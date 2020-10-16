@extends('layouts.app')
@section('custom_styles')
    @include('bootstrap-select.style')
    @include('datatables.style')
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-11 col-lg-12">
                <h3>CAJA ACTUAL</h3>
            </div>
        </div>
        <hr>
        <div class="card">
            @if($isCloseCash)
                <div class="card-header">
                    CAJA CERRADA
                </div>
                <div class="card-body">
                    <p class="card-text">LA CAJA DEL DIA <span style="font-weight: bold">{{$date}}</span> HA SIDO CERRADA.</p>
                </div>
            @else
                <div class="card-header">
                    CAJA CORRESPONDIENTE AL: {{$date}}
                </div>
                <div class="card-body">
                    <p class="card-text">NO SE PUEDEN REGISTRAR MOVIMIENTOS DE CAJA CORRESPONDIENTES AL DIA DE HOY, YA
                        QUE AUN NO SE HA INICIADO LA CAJA.</p>
                    <a href="{{route('cash.open')}}" class="btn btn-primary">INICIAR CAJA</a>
                </div>
            @endif
        </div>
    </div>
@endsection
