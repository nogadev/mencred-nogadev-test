@if ($deleted_at == null)
<form method="get" action="{{route('articles.edit', $id)}}" style="display: inline;">
    <button type="submit" class="btn btn-sm btn-primary">Editar</button>    
    {{-- <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmModal" onclick="setDeleteAction('{{ route('articles.destroy', $id) }}','{{$description}}');">Eliminar</button> --}}
</form>
@else
<form action="{{ route('articles.restore', $id) }}" method="post" style="display: inline;">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    <button type="submit" class="btn btn-sm btn-success">Restaurar</button>
</form>
@endif