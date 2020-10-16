<script type="text/javascript">
    var table;
    var reason = [];


    $(document).ready(function() {
        moment.locale('es');
        $.fn.dataTable.moment( 'L', 'es');

    	var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="movementtype_id"]').selectpicker(customerOptions);//tipo
        $('select[name="movementreason_id"]').selectpicker(customerOptions);//motivo

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        $('.datepicker').datepicker('setDate', '0d');

        table = $('#table').DataTable( {
        	iDisplayLength: 50,
        	columnDefs: [
        		{ className: "dt-right", "targets": [4] },
        	],

        } );

        @foreach ($movementtypes as $movementtype)
            reason[{{ $movementtype->id }}] = @json($movementtype->movreasons);
        @endforeach

        $("#movementtype_id").change(function(){
             $("#movementreason_id").empty();

             var mov_type_id = $(this).val();

             $.each(reason[mov_type_id], function(key, movementreason){
                 $('select[name="movementreason_id"]').append('<option value="' + movementreason.id + '">' + movementreason.description + '</option>');
             });

             $("#movementreason_id").selectpicker("refresh");
        });

        $("#buscar").click(function(){
        	mov_reason_id 	    = $("#movementreason_id").val();
            movementtype_id     = $("#movementtype_id").val();
        	date_init 			= $("#date_init").val();
        	date_end 			= $("#date_end").val();
            _token				= $("_token").val();
            let a_efectivo = 0;
            let a_cheque = 0;
            let a_mercado_pago = 0;
            let a_banco = 0;
            let a_total = 0;

        	if(date_init != '' && date_end != ''){
        		table.clear().draw();

                arr = date_init.split('/');
                date_init = arr[2]+'-'+arr[1]+'-'+arr[0];
                arr = date_end.split('/');
                date_end = arr[2]+'-'+arr[1]+'-'+arr[0];

        		$.ajax({
        			type: "GET",
		            url: "{{route('cash.list.data')}}",
		            data: {
		                date_init: 			date_init,
		                date_end: 			date_end,
						mov_reason_id:      mov_reason_id,
                        movementtype_id
		            },
		            headers: {
		                'X-CSRF-TOKEN': _token
		            },
		            success: function (response) {
                        data = [];
                        $.each(response, function(i, item){
                            arr = item.date_of.split('-');
                            date = arr[2]+'/'+arr[1]+'/'+arr[0];

                            if (item.payment_method == 'EFECTIVO'){
                                a_efectivo += parseFloat(item.amount);
                            }
                            if (item.payment_method == 'CHEQUE'){
                                a_cheque += parseFloat(item.amount);
                            }
                            if (item.payment_method == 'MERCADO PAGO'){
                                a_mercado_pago += parseFloat(item.amount);
                            }
                            if (item.payment_method == 'BANCO'){
                                a_banco += parseFloat(item.amount);
                            }

                            // en esta variable sumarizamos todos los movimientos juntos
                            a_total += parseFloat(item.amount);

                            data.push({
                                date:      	     date,
                                mov_reason:      item.mov_reason,
                                detail:          item.description,
                                payment_method:  item.payment_method,
                                amount:          new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(item.amount)
                            });
                        });

                        $('#a_efectivo:text').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_efectivo));
                        $('#a_cheque:text').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_cheque));
                        $('#a_mercado_pago:text').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_mercado_pago));
                        $('#a_banco:text').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_banco));
                        $('#a_total:text').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(a_total));

                        table.destroy();

                        table = $('#table').DataTable({
							order: [[ 0, "desc" ],[1,"asc"]],
                            iDisplayLength: 50,
                            columnDefs: [{ className: "dt-right", "targets": [4] }],
                            "columns": [
                                { "data": "date" },
                                { "data": "mov_reason" },
                                { "data": "detail" },
                                { "data": "payment_method" },
                                { "data": "amount" }
                            ],
                            data:           data,
                            deferRender:    true
						});
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

        $("#imprimir").click(function(){
        	mov_reason_id 	= $("#movementreason_id").val();
        	date_init 			= $("#date_init").val();
        	date_end 			= $("#date_end").val();
            _token      		= $("_token").val();
        	search				= $('input[type="search"]').val();

        	if(date_init != '' && date_end != ''){
        		var url = "{{ route("print.cashes") }}";
        		url = url + "?print=1&mov_reason_id="+mov_reason_id + "&date_init="+date_init + "&date_end="+date_end + "&search="+search ;
				window.open(url, '_blank');
        	}
        });

    });

</script>
