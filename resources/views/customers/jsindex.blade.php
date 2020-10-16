<script type="text/javascript">

    $(document).ready(function() {

        data = @json($customers);

        table = $('#table').DataTable( {
            iDisplayLength: 50,
            columnDefs: [{
                "targets": 7,
                "orderable": true,
                "render": function (data, type, row) {
                    var button = '<a href="/customers/'+data.id+'/edit" class="btn btn-sm btn-primary">VER</a>';
                    return button;
                }
            }],
            "columns": [
                { "data": "name" },
                { "data": "route.name" },
                { "data": "seller.name" },
                { "data": "commercial_town.name" },
                { "data": "commercial_neighborhood.name" },
                { "data": "commercial_address" },
                { "data": "doc_number" },
                { "data": null}
            ],
            data:           data,
            deferRender:    true
        } );
    });

    $("#print").click(function(){
        search = $('input[type="search"]').val();
        var url = "{{ route('print.customers.all') }}";
        url = url + "?search="+search ;
		window.open(url, '_blank');    
    });

    

</script>