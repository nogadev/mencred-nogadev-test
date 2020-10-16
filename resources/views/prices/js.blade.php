<script>
    $(document).ready(function() {
        $($('#table thead tr')[0]).clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {      
            if(i!==0 && i!==7){
                //0 y 7 pertenecen a columnas sin datos para filtrar
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
            }

		} );
        var table = $('#table').DataTable( {
            "lengthMenu": [ [5,10, 25, 50, 100], [5,10, 25, 50, 100] ],
            iDisplayLength: 50,
            "serverSide": true,
            "ajax": "{{url('api/prices.articles')}}",
            rowId: 'id',
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": '',
                    "searchable": false, "targets": 0
                },
                {data:"print_name"},
                {data:"trademark"},
                {data:"model"},
                {data:"fee_quantity"},
                {data:"fee_amount",render: $.fn.dataTable.render.number( '.', ',', 2,'',' $')},
                {data:"price",render: $.fn.dataTable.render.number( '.', ',', 2,'',' $')},
                {data:"actions"}
            ],
            "order": [[1, 'asc']],
            orderCellsTop: true,
        	fixedHeader: true
        });
        function format(d) {
            var returnHtml =
                '<table id="table_'+ d.id +'" class="compact hover nowrap row-border stripe dataTable no-footer">' +
                '<thead>'+
                '<tr>'+
                '<th>PUNTO DE VENTA</th>'+
                '<th>CUOTAS</th>'+
                '<th>$ CUOTA</th>'+
                '<th>TOTAL</th>'+
                '<th></th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>'+
                '</tbody>'+
                '</table>';
            return returnHtml;
        }
        $('#table tbody').on('click', '.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child( format(row.data()) ).show();
                var _token = $('input[name="_token"]').val();
                $.post( "{{route('articleprice.article')}}",
                    {
                        article_id: row.data().id,
                        _token : _token
                    },
                    function( data ) {
                        addOrUpdateRowsToChild(data);
                    });
                tr.addClass('shown');
            }
        } );
    });
    function addOrUpdateRowsToChild(d) {
        $.each(d, function(k, v) {
            // Si existe la fila, actualizo valores de las columnas
            if($('#article_price_' + v.id).length){
                var rowEdited = $('#article_price_' + v.id);
                rowEdited.find('td:eq(1)').html(v.fee_quantity);
                rowEdited.find('td:eq(2)').html(v.fee_amount);
                rowEdited.find('td:eq(3)').html(v.price);
            }
            //Sino, agrego la fila.
            else{
                var row = $('<tr>');
                row.prop('id','article_price_' + v.id);
                row.prop('role','row');
                row.addClass('even');
                var point_of_sale = $('<td>').html(v.point_of_sales.name);
                var fee_quantity = $('<td>').html(v.fee_quantity);
                var fee_amount = $('<td>').html(v.fee_amount);
                var price = $('<td>').html(v.price);
                var actions = $('<td>');
                var btn_edit = $('<button>');
                var icon_remove = $('<i>');
                var icon_edit = $('<i>');
                icon_remove.addClass('fa fa-times');
                icon_edit.addClass('fa fa-edit');
                btn_edit.addClass('btn btn-primary btn-circle');
                btn_edit.attr('onClick', 'editPrice('+v.id+','+v.article_id+');');
                btn_edit.append(icon_edit);
                actions.append(btn_edit);
                row.append(point_of_sale);
                row.append(fee_quantity);
                row.append(fee_amount);
                row.append(price);
                row.append(actions);
                $('#table_' + v.article_id + ' tbody').append(row);
            }
        });
    }
    function updateRowToTable(d) {
        var article = d[0];
        var rowEdited = $('#table').find('tr#'+article.article_id);
        rowEdited.find('td:eq(1)').html(article.print_name);
        rowEdited.find('td:eq(4)').html(article.fee_quantity);
        rowEdited.find('td:eq(5)').html(article.fee_amount);
        rowEdited.find('td:eq(6)').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(article.price));
    }
</script>