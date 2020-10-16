{{ csrf_field() }}
@include('errors')
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include("commons.asterix-sm")<label>DESCRIPCIÓN</label>
        <input type="text" name="description" maxlength="60" class="form-control" placeholder="DESCRIPCION"
               @if(isset($article)) value="{{ $article->description }}" @else value="{{ old('description') }}" @endif required>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include("commons.asterix-sm")<label>LISTA DE PRECIO</label>
        <input type="text" name="print_name" class="form-control" placeholder="LISTA DE PRECIO"
               @if(isset($article)) value="{{ $article->print_name }}" @else value="{{ old('print_name') }}" @endif required>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>DISPONIBLE</label>
        <select class="selectpicker show-tick" name="available" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            <option value="1" @if(!isset($article) || (isset($article) && $article->available == "1") || (old('available') == "1")) selected @endif>DISPONIBLE</option>
            <option value="0" @if((isset($article) && $article->available == "0") || (old('available') == "0")) selected @endif>NO DISPONIBLE</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        @include("commons.asterix-sm")<label>PROVEEDOR</label>
        <select class="selectpicker show-tick" name="supplier_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info" required>
            @foreach($suppliers as $supplier)
                <option value="{{$supplier->id}}" @if((isset($article) && $article->supplier_id == $supplier->id) || (old('supplier_id') == $supplier->id)) selected @endif>{{$supplier->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>CATEGORIA</label>
        <select class="selectpicker show-tick" name="article_category_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            @foreach($articleCategories as $articleCategory)
                <option value="{{$articleCategory->id}}" @if((isset($article) && $article->article_category_id == $articleCategory->id) || (old('article_category_id') == $articleCategory->id)) selected @endif>{{$articleCategory->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>ESTADO</label>
        <select class="selectpicker show-tick" name="state" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
            <option value="A" @if(!isset($article) || (isset($article) && $article->state == "A") || (old('state') == "A")) selected @endif>ACTIVO</option>
            <option value="D" @if((isset($article) && $article->state == "D") || (old('state') == "D")) selected @endif>DISCONTINUADO</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>MARCA</label>
        <input type="text" name="trademark" class="form-control" placeholder="MARCA"
               @if(isset($article)) value="{{ $article->trademark }}" @else value="{{ old('trademark') }}" @endif>
    </div>
    <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <label>MODELO</label>
        <input type="text" name="model" class="form-control" placeholder="MODELO"
               @if(isset($article)) value="{{ $article->model }}" @else value="{{ old('model') }}" @endif>
    </div>
</div>
<div class="row" id="attributes">
    @if(isset($article->articleCategory))
        @foreach ($article->articleCategory->attributes as $categoryAttribute)
            <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <label>{{$categoryAttribute->name}}</label>
                @php $hasAttribute = false; @endphp
                @foreach ($article->attributes as $articleAttribute)
                    @if ($articleAttribute->attribute_id == $categoryAttribute->id)
                        @php $hasAttribute = true; break;@endphp
                    @endif
                @endforeach
                <input type="hidden" name="art_attr_ids[]" class="form-control" @if($hasAttribute) value="{{$articleAttribute->id}}" @else value="0"@endif>
                <input type="hidden" name="attr_ids[]" class="form-control" value="{{$categoryAttribute->id}}">
                <input type="text" name="attr_values[]" class="form-control" placeholder="{{$categoryAttribute->name}}" @if($hasAttribute) value="{{$articleAttribute->value}}" @else value=""@endif>
            </div>
        @endforeach
    @endif
</div>
