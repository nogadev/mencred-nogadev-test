<script type="text/javascript">
    var table;

    $(document).ready(function() {

        moment.locale('es');
        $.fn.dataTable.moment( 'L', 'es');

    	var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="seller_id"]').selectpicker(customerOptions);

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
        		{ className: "dt-right", "targets": [5,6,8] },
        		{ className: "dt-center", "targets": [4] }
        	]

        } );

        $("#find").click(function(){
        	seller_id 	= $("#seller_id").val();
            date_init 	= $("#date_init").val();
        	date_end	= $("#date_end").val();
            _token		= $("_token").val();
            let a_comision = 0;
            let a_total = 0;

        	if(date_init != '' && date_end != '' && seller_id != ''){

                /*arr = date_init.split('/');
                date_init = arr[2]+'-'+arr[1]+'-'+arr[0];
                arr = date_end.split('/');
                date_end = arr[2]+'-'+arr[1]+'-'+arr[0];*/

                $.ajax({
        			type: "GET",
		            url: "{{route('payments.sellers.data')}}",
		            data: {
		                date_init: 	date_init,
		                date_end: 	date_end,
		                seller_id: 	seller_id,
		            },
		            headers: {
		                'X-CSRF-TOKEN': _token
		            },
		            success: function (response) {

                        data = [];
                        $.each(response, function(i, item){
                            arr = item.init_date.split(' ')[0].split('-');
                            date = arr[2]+'/'+arr[1]+'/'+arr[0];
                            a_total += parseFloat((item.quantity * item.price).toFixed(2));
                            a_comision += parseFloat(((item.quantity * item.price * item.seller_commission) / 100).toFixed(2));
                            data.push({
                                date:        date,
                                customer:    item.customer,
                                article:     item.article,
                                company:     item.company,
                                quantity:    Number(item.quantity),
                                price:       new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(item.price),
                                total:       new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(parseFloat(item.quantity * item.price).toFixed(2)),
                                percentaje:  item.seller_commission,
                                comission:   new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(parseFloat((item.quantity * item.price * item.seller_commission) / 100).toFixed(2))
                            });
                        });

                        $('#a_total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_total));
                        $('#a_comision').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_comision));

                        table.destroy();

                        table = $('#table').DataTable( {
                            iDisplayLength: 50,
                            columnDefs: [
                                { className: "dt-right", "targets": [5,6,8] },
                                { className: "dt-center", "targets": [4] }
                            ],
                            "columns": [
                                { "data": "date" },
                                { "data": "customer" },
                                { "data": "article" },
                                { "data": "company" },
                                { "data": "quantity"},
                                { "data": "price" },
                                { "data": "total" },
                                { "data": "percentaje" },
                                { "data": "comission" }
                            ],
                            data:           data,
                            deferRender:    true,
                            order: [[0,"asc"],[1,"asc"]]
                        } );
		            },
		            error: function(jqXHR, textStatus, errorThrown) {
		                $.notify(
		                    {
		                        icon: 'fas fa-exclamation-circle',
		                        message: "Error obteniendo los datos"
		                    },{
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
        	seller_id  = $("#seller_id").val();
            date_init   = $("#date_init").val();
            date_end    = $("#date_end").val();
        	_token		= $("_token").val();
        	search		= $('input[type="search"]').val();

        	if(date_init != '' && date_end != '' && seller_id != ''){
        		var url = "{{ route('print.payments.sellers') }}";
        		url = url + "?seller_id="+seller_id + "&date_init="+date_init + "&date_end="+date_end + "&search="+search ;
				window.open(url, '_blank');
        	}
        });

        $('.datepicker').datepicker('setDate', '0d');

    });


</script>
