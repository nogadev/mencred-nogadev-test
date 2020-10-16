<script type="text/javascript">
    var table;

    $(document).ready(function() {


    	var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="status_id"]').selectpicker(customerOptions);

        
        table = $('#table').DataTable( {
        	iDisplayLength: 50,
        	
        } );

        $("#find").click(function(){
        	status_id 	= $("#status_id").val();
        	_token		= $("_token").val();

        	if(status_id != ''){
        		table.clear().draw();

        		$.ajax({
        			type: "GET",
		            url: "{{route('claims.list.data')}}",
		            data: {
		                status_id : status_id
		            },
		            headers: {
		                'X-CSRF-TOKEN': _token
		            },
		            success: function (response) {
		            	data = [];
		            	$.each(response, function(i, item){
			                data.push({
			                    tipo: 		item.type,
				                cliente: 	item.customer,
				                telefono: 	item.particular_tel,
				                recorrido: 	item.route,
				                vendedor: 	item.seller,
				                credito: 	item.id
			                });
			            });
			            
			            table.destroy();

			            table = $('#table').DataTable( {
			            	iDisplayLength: 50,
			            	columnDefs: [{ className: "dt-right", "targets": [5] }],
				        	"columns": [
				                { "data": "tipo" },
				                { "data": "cliente" },
				                { "data": "telefono" },
				                { "data": "recorrido" },
				                { "data": "vendedor"},
				                { "data": "credito" }
				            ],
				            data:           data,
				            deferRender:    true
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
        	status_id  = $("#status_id").val();
            _token      = $("_token").val();
        	search		= $('input[type="search"]').val();

        	if(status_id != ''){
        		var url = "{{ route('print.claims') }}";
        		url = url + "?status_id="+status_id + "&search="+search ;
				window.open(url, '_blank');
        	}
        });

    });


</script>