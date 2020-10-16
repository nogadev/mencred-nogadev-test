<script type="text/javascript">
    var table;

    $(document).ready(function() {

        moment.locale('es');
        $.fn.dataTable.moment( 'L', 'es');

        $('#table thead tr').clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {

            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control form-control-sm" id="search_'+title+'" placeholder="Buscar '+title+'" disabled/>' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );

            var id_search= $(this)[0].children[0].id;
            if(id_search==="search_FECHA"){
                $(this)[0].children[0].className += " datepicker";
            }else if(id_search==="search_TOTAL"||id_search==="search_COBRADO"||id_search==="search_SALDO"){
                $(this)[0].children[0].setAttribute('type', 'number');
            }else{
                    $(this)[0].children[0].setAttribute('type', 'text');
            }
		} );

    	var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="route_id"]').selectpicker(customerOptions);

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        table = $('#table').DataTable( {
        	iDisplayLength: 50,
        	columnDefs: [
        		{ className: "dt-right", "targets": [3,4,5] },
        	],
            orderCellsTop: true,
        	fixedHeader: true

        } );

        $("#find").click(function(){
        	route_id 	= $("#route_id").val();
            date_init 	= $("#date_init").val();
        	date_end	= $("#date_end").val();
        	_token		= $("_token").val();
        let a_total     = 0;
        let a_cobrado   = 0;
        let a_saldo     = 0;

        	if(date_init != '' && date_end != ''){
        		table.clear().draw();

                arr = date_init.split('/');
                date_init = arr[2]+'-'+arr[1]+'-'+arr[0];
                arr = date_end.split('/');
                date_end = arr[2]+'-'+arr[1]+'-'+arr[0];

                $.ajax({
        			type: "GET",
		            url: "{{route('credits.total.route')}}",
		            data: {
		                date_init: 	date_init,
		                date_end: 	date_end,
		                route_id: 	route_id,
		            },
		            headers: {
		                'X-CSRF-TOKEN': _token
		            },
		            success: function (response) {

                        $('#table thead tr:eq(1) th').each( function (i) {

                            $(this)[0].children[0].disabled = false;

                        });
                        data = [];
                        $.each(response, function(i, item){
                            arr = item.init_date.split(' ')[0].split('-');
                            date = arr[2]+'/'+arr[1]+'/'+arr[0];
                            a_total += parseFloat(item.total_amount);
                            a_cobrado += parseFloat(item.paid);
                            a_saldo += parseFloat(item.total_amount - item.paid);
                            data.push({
                                date:      date,
                                customer:  item.customer,
                                route:     item.route,
                                seller:    item.seller,
                                total:     new Intl.NumberFormat('de-AR', { style: 'currency', currency: 'USD' }).format(item.total_amount),
                                paid:      new Intl.NumberFormat('de-AR', { style: 'currency', currency: 'USD' }).format(item.paid),
                                balance:   new Intl.NumberFormat('de-AR', { style: 'currency', currency: 'USD' }).format( parseFloat(item.total_amount - item.paid).toFixed(2)),
                            });
                        });

                            $('#a_total:text').val(new Intl.NumberFormat('de-AR', { style: 'currency', currency: 'USD' }).format(a_total));
                            $('#a_cobrado:text').val(new Intl.NumberFormat('de-AR', { style: 'currency', currency: 'USD' }).format(a_cobrado));
                            $('#a_saldo:text').val(new Intl.NumberFormat('de-AR', { style: 'currency', currency: 'USD' }).format(a_saldo));
                        table.destroy();

                        table = $('#table').DataTable( {
                            iDisplayLength: 50,
                            columnDefs: [{ className: "dt-right", "targets": [3,4,5] }],
                            "columns": [
                                { "data": "date" },
                                { "data": "customer" },
                                { "data": "route" },
                                { "data": "seller" },
                                { "data": "total" },
                                { "data": "paid"},
                                { "data": "balance" }
                            ],
                            data:           data,
                            deferRender:    true,
                            orderCellsTop: true,
        	                fixedHeader: true,
                            order: [[0,"asc"],[1,"asc"]]
                        } );

		            },
		            error: function(jqXHR, textStatus, errorThrown) {
		                $.notify(
		                    {
		                        // options
		                        icon: 'fas fa-exclamation-circle',
		                        message: "Error obteniendo los datos"
		                    },{
		                        // settings
		                        type: "warning",
		                        showProgressbar: false,
		                        mouse_over: 'pause',
		                        animate: {
		                            enter: 'animated bounceIn',
		                            exit: 'animated bounceOut'
		                        }
		                    }
		                );
		            }
        		});

        	}
        });

        $("#print").click(function(){
        	route_id    = $("#route_id").val();
            date_init   = $("#date_init").val();
            date_end    = $("#date_end").val();
        	_token		= $("_token").val();
        	search		= $('input[type="search"]').val();

            var data =[];
			$('#table thead tr:eq(1) th').each( function (i) {
                data.push({
                    name: $(this)[0].children[0].id.split('_')[1].toLowerCase(),
                    search: $(this).children().val()
                });
			});

        	if(date_init != '' && date_end != ''){
        		var url = "{{ route('print.credits.route') }}";
        		url = url + "?route_id="+route_id + "&date_init="+date_init + "&date_end="+date_end + "&search="+search ;
				data.forEach(function(search){
                    url = url + "&"+search.name+"="+search.search;
                })
                window.open(url, '_blank');
        	}
        });

        $('#date_init').datepicker('setDate', '0d');
        $('#date_end').datepicker('setDate', '0d');
    });


</script>
