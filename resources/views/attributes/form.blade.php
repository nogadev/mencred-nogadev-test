{{ csrf_field() }}
@include('errors')    
<input type="hidden" name="id" @if(isset($attribute)) value="{{ $attribute->id }}" @else value="0" @endif>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Categoría</label>
    <select class="selectpicker show-tick" name="article_category_id" data-live-search="true"  title="Seleccionar" data-width="100%" data-style="btn-info">
        @foreach($articleCategories as $articleCategory)
            <option value="{{$articleCategory->id}}" @if((isset($attribute) && $attribute->article_category_id == $articleCategory->id) || (old('article_category_id') == $articleCategory->id)) selected @endif>{{$articleCategory->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include("commons.asterix-sm")<label>Nombre</label>
    <input type="text" name="name" class="form-control" placeholder="Nombre"
           @if(isset($attribute)) value="{{ $attribute->name }}" @else value="{{ old('name') }}" @endif>
</div>