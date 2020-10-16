@include('errors')    
<div id="error_div" style="display:none">
    <div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    </div>
</div>

<form id="expenseForm" method="post" action="storeExpense" autocomplete="off">
    {{ csrf_field() }}
    <div class="row justify-content border-primary">
        <div class="form-group col-md-4">

            <div class="form-group row">
                <div class="col-md-4">@include('commons.asterix-sm')<label>VENDEDOR</label></div>
                <div class="col-md-7">
                    <select name="seller_id" id="seller_id">
                        @foreach($sellers as $seller)
                            <option value="{{$seller->id}}" >{{$seller->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">@include('commons.asterix-sm')<label>CONCEPTO</label></div>
                <div class="col-md-7">
                    <select name="expenseconcept_id" id="expenseconcept_id">
                        @foreach($concepts as $concept)
                            <option value="{{$concept->id}}" >{{$concept->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">@include("commons.asterix-sm")<label>FECHA</label></div>
                <div class="col-md-7">
                    <input type="text" id="date" name="date" class="datepicker form-control" placeholder="dd/mm/aaaa">
               </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">@include("commons.asterix-sm")<label>MONTO</label></div>
                <div class="col-md-7">
                    <input type="text" id="amount" name="amount" class="form-control" placeholder="0,00 $"
                       value="{{ old('amount') }}">
                   </div>
            </div>

        </div>
    </div>
    <button type="submit" class="btn btn-success">GUARDAR</button>

</form>

<br>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card border-primary">

            <div class="card-body row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h5>GASTOS</h5>
                    <table id="tableExpenses" style="table-layout: fixed;" class="compact hover nowrap row-border">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>VENDEDOR</th>
                                <th>CONCEPTO</th>
                                <th>FECHA</th>
                                <th>MONTO</th>
                            </tr>
                        </thead>
                        <tbody> 

                        </tbody>
                    </table>
                </div>

            </div>
      
        </div>
    </div>
</div>
