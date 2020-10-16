<script type="text/javascript">
    $(document).ready(function() {
        data = @json($mov_reasons);
        table = $('#table').DataTable( {
            iDisplayLength: 50,
            order:[[0,"asc"],[1,"asc"]],
            columnDefs: [{
                "targets": 2,
                "orderable": false,
                "render": function (data, type, row) {
                    var button = '<a href="/movreasons/'+data.id+'/edit" class="btn btn-sm btn-primary">EDITAR</a>';
                    return button;
                }
            }],
            "columns": [
                { "data": "mov_types.description" },
                { "data": "description" },
                { "data": null}
            ],
            data:           data,
            deferRender:    true
        } );
    });
    </script> 