@extends('layouts.app')
@section('custom_styles')
@include('datatables.style')
@endsection
@section('content')
<div class="container">
    <h5>CUOTAS</h5>
    <hr>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        {{ csrf_field() }}
        <table id="table" class="table table-striped mb-0 pointer">
            <thead>
                <tr>
                    <th>@sortablelink('number','Nº')</th>
                    <th>MONTO</th>
                    <th>RECORRIDO</th>
                    <th>FECHA PAGADO</th>
                    <th>MONTO PAGADO</th>
                    <th>MOTIVO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credit->fees as $fee)
                <tr>
                    <td>{{ $fee->number }}</td>
                    <td>{{ $fee->payment_amount }} $</td>
                    <td>{{ $credit->customer->route->name }}</td>
                    <td>{{ $fee->paid_date->format('d/m/Y')}}</td>
                    <td>
                        <input name="paid_{{$fee->id}}" id="paid_{{$fee->id}}"
                            style="width:50%; display:inline;text-align:right" onchange="activeButton({{$fee->id}})"
                            class="form-control enterSelect" type="text" value="{{number_format($fee->paid_amount, 2,',','.')}} $">
                    </td>
                    <td>
                        <select name="reason_{{$fee->id}}" id="reason_{{$fee->id}}"
                            onchange="activeButton({{$fee->id}})" class="form-control enterSelect">
                            @foreach($reasons as $reason)
                            <option value="{{$reason->id}}" @if($fee->reason_id == $reason->id) selected @endif
                                >{{$reason->reason}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td id="action_{{$fee->id}}">
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        {!! Form::close() !!}
    </div>


    @endsection
    @section('custom_scripts')
    @include('bootstrap-select.script')
    @include('credits.jsedit')
    @endsection
