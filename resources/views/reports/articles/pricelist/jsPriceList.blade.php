<script type="text/javascript">
    var table;

    $(document).ready(function() {
		$('#table thead tr').clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {
			var title = $(this).text();
			$(this).html( '<input type="text" id="search_'+title+'" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );
	
			$( 'input', this ).on( 'keyup change', function () {
				if ( table.column(i).search() !== this.value ) {
					table
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		} );

        table = $('#table').DataTable( {
        	iDisplayLength: 50,
        	columnDefs: [{ className: "dt-right", "targets": [4] }],
			orderCellsTop: true,
        	fixedHeader: true
        } );

			_token	= $("_token").val();

        	table.clear().draw();

        	$.ajax({
        		type: "GET",
	            url: "{{route('price.list.data')}}",
		        headers: {
	                'X-CSRF-TOKEN': _token
		        },
		        success: function (response) {
	            	data = [];
	            	$.each(response, function(i, item){
			            data.push({
			                article: 	 item.print_name,
			                trademark:   item.trademark,
			                model: 	     item.model,
		                    price_list:  item.price_list,
		                    price:		 new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(parseFloat(item.price).toFixed(2))
		                });
			        });

			        table.destroy();

			        table = $('#table').DataTable( {
			        	iDisplayLength: 50,
			        	columnDefs: [{ className: "dt-right", "targets": [4] }],
			        	"columns": [
			                { "data": "article" },
			                { "data": "trademark" },
				            { "data": "model" },
				            { "data": "price_list" },
				            { "data": "price" }
				        ],
						orderCellsTop: true,
        				fixedHeader: true,
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

        $("#print").click(function(){
        	_token		= $("_token").val();
        	search		= $('input[type="search"]').val();

			var data =[];
			$('#table thead tr:eq(1) th').each( function (i) {
				data.push({
								name: $(this)[0].children[0].id.split('_')[1].toLowerCase(),
								search: $(this).children().val()
						});
			});

        	var url = "{{ route('print.articles.price.list') }}";
        	url = url + "?search="+search ;
			data.forEach(function(search){
				url = url + "&"+search.name+"="+search.search;
			});
			window.open(url, '_blank');
        });

    });


</script>
