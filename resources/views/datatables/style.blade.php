<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css">
{{-- Para quitar los iconos de JQuery --}}
<style>
    table.dataTable thead .sorting{
        background-image:none;
    }
    table.dataTable thead .sorting_asc{
        background-image:none;
    }
    table.dataTable thead .sorting_desc{
        background-image:none;
    }
    table.dataTable thead .sorting_asc_disabled{
        background-image:none;
    }
    table.dataTable thead .sorting_desc_disabled{
        background-image:none;
    }
    td.details-control {
        background: url({{url('/img/details_open.png')}}) no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url({{url('/img/details_close.png')}}) no-repeat center center;
    }
    table.dataTable.pointer{
        cursor: pointer;
    }

</style>