{{ csrf_field() }}
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
        @include('commons.asterix-sm')<label>Fecha</label>
        <input type="text" id="date" name="date" class="form-control" placeholder="dd/mm/aaaa">
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                @include('commons.asterix-sm')<label>Empresa</label>
                <select name="origin_company_id" onchange="fillOriginArticles();">
                    @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>

                @include('commons.asterix-sm')<label>Depósito</label>
                <select name="origin_store_id" onchange="fillOriginArticles();">
                    @foreach($stores as $store)
                        <option value="{{$store->id}}">{{$store->name}}</option>
                    @endforeach
                </select>

                <div class="form-group">
                    <label>Emisor</label>
                    <input type="text" name="sender" class="form-control" placeholder="Emisor">
                </div>
            </div>
            <div class="card-body">
                <table id="originArticles" class="compact hover row-border">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th>Stock</th>
                            <th class="no-order no-search fit"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                @include('commons.asterix-sm')<label>Empresa</label>
                <select name="destination_company_id" onchange="fillOriginArticles();">
                    @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>

                @include('commons.asterix-sm')<label>Depósito</label>
                <select name="destination_store_id" onchange="fillOriginArticles();">
                    @foreach($stores as $store)
                        <option value="{{$store->id}}">{{$store->name}}</option>
                    @endforeach
                </select>
                <div class="form-group">
                    <label>Receptor</label>
                    <input type="text" name="receiver" class="form-control" placeholder="Receptor">
                </div>
            </div>
            <div class="card-body">
                <table id="destinationArticles" class="compact hover row-border">
                    <thead>
                        <tr>
                            <th>Artículo</th>
                            <th>Cant.</th>
                            <th class="no-order no-search fit"></th>
                        </tr>
                    </thead>
                    <tbody>                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <label>Comentarios</label>
        <textarea id="autosize" name="details" class="form-control" rows="1" style="resize: vertical; min-height: 40px;" placeholder="Comentarios"></textarea>
    </div>
</div>
<textarea name="art_data" id="art_data" style="display: none;"></textarea>
