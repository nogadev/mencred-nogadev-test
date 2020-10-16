<script type="text/javascript">

    $(document).ready(function() {

        $('#table thead tr').clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {

            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control form-control-sm" id="search_'+title+'" placeholder="Buscar '+title+'"/>' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );

		} );

        data = @json($articles);
        table = $('#table').DataTable( {
            iDisplayLength: 50,
            columnDefs: [
                {
                "targets": 5,
                "orderable": false,
                "render": function (data, type, row) {
                    var button = "";
                    if(data.deleted_at) {
                        button = '<a href="/articles/'+data.id+'/restore" class="btn btn-sm btn-success" style="margin-left:3px;">RESTAURAR</a>';
                    } else {
                        button = '<a href="/articles/'+data.id+'/edit" class="btn btn-sm btn-primary">EDITAR</a>';
                        button += '<a href="/articles/'+data.id+'/destroy" class="btn btn-sm btn-danger" style="margin-left:3px;">ELIMINAR</a>';
                    }
                    return button;             
                }
                
            },
            ],
            "columns": [
                { "data": "id" },
                { "data": "description" },
                { "data": "article_category.name","defaultContent":"","searchable":true},
                { "data": "trademark"},
                { "data": "state" },
                { "data": null}
            ],
            data:           data,
            deferRender:    true,
            orderCellsTop: true,
        	fixedHeader: true
        } );
    });
</script>