@if ($errors->any())
<div class="alert alert-danger" style="padding-bottom: 0rem !important;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif