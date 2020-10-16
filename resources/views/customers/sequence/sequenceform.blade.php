@include('errors')    
<div id="error_div" style="display:none">
    <div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    </div>
</div>
<form id="sequenceForm" method="post" action="sequence" autocomplete="off">
    {{ csrf_field() }}
    <div class="row">

        <div class="form-group col-xl-2 col-sm-12 col-md-4 col-lg-4">
            @include('commons.asterix-sm')<label>RECORRIDO</label>
            <select name="route_id" id="route_id" onchange="getData();">
                @foreach($routes as $route)
                    <option value="{{$route->id}}" >{{$route->name}}</option>
                @endforeach
            </select>
        </div>
        <textarea name="sequence_data" id="sequence_data" style="display: none;"></textarea>
    </div>

</form>

<br>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card border-primary">

            <div class="card-body">
                <table id="tableSequence" class="compact hover nowrap row-border">
                    <thead>
                        <tr>
                            <th class="no-order fit">#ITEM</th>
                            <th>CLIENTE</th>
                            <th>VENDEDOR</th>
                            <th>Bº COMER</th>
                            <th>DIR. COMER</th>
                            <th>Nº ORDEN</th>
                            <th>VISITA</th>
                        </tr>
                    </thead>
                    <tbody>                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
