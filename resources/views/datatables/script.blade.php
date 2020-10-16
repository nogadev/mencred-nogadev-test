{{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
<script>
    $.extend( 
        $.fn.dataTable.defaults, {
            "autoWidth": false,
            "language": {
                //"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                processing:     "Procesando...",
                search:         "Buscar&nbsp;:",
                lengthMenu:    "Ver _MENU_ filas",
                info:           "_START_ a _END_ de _TOTAL_",
                infoEmpty:      "Ningún dato disponible",
                infoFiltered:   "(filtro de _MAX_ totales)",
                infoPostFix:    "",
                loadingRecords: "Cargando...",
                zeroRecords:    "Ningún dato disponible",
                emptyTable:     "Ningún dato disponible",
                paginate: {
                    first:      "Primero",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Último"
                },
                aria: {
                    sortAscending:  ": Ordena ascendente",
                    sortDescending: ": Ordena descendente"
                }
            },
            "lengthMenu": [ [10, 25, 50, 100], [10, 25, 50, 100] ],
            "iDisplayLength": 50,
            "columnDefs": [
                {
                    "targets": 'no-order',
                    "orderable": false,
                },
                {
                    "targets": 'no-search',
                    "searchable": false,
                },
                { 
                    "targets": 'fit',
                    "className": 'dt-body-right' 
                }
            ]
        }
    );
</script>