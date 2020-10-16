<script type="text/javascript">
$(document).ready(function() {

    data = @json($suppliers);

    table = $('#table').DataTable( {
        iDisplayLength: 50,
        order:[[1,"asc"]],
        columnDefs: [{
            "targets": 5,
            "orderable": false,
            "render": function (data, type, row) {
                var button = '<a href="/suppliers/'+data.id+'/edit" class="btn btn-sm btn-primary">Editar</a>';
                return button;
            }
        }],
        "columns": [
            { "data": "code" },
            { "data": "name" },
            { "data": "business_name" },
            { "data": "phone" },
            { "data": "email" },
            { "data": null}
        ],
        data:           data,
        deferRender:    true,
        //scrollY:        400,
        //scrollCollapse: true,
        //scroller:       true
    } );
});

</script>