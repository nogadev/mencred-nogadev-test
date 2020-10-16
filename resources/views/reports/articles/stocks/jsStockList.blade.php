<script type="text/javascript">
    var table;
    var data;

    $(document).ready(function() {

		$('#table thead tr').clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {
			var title = $(this).text();
			$(this).html( '<input type="text" id="search_'+title+'" class="form-control form-control-sm" placeholder="Buscar '+title+'" disabled />' );
	
			$( 'input', this ).on( 'keyup change', function () {
				if ( table.column(i).search() !== this.value ) {
					table
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		} );

    	var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="company_id"]').selectpicker(customerOptions);
        $('select[name="store_id"]').selectpicker(customerOptions);

        table = $('#table').DataTable( {
        	iDisplayLength: 50,
        	columnDefs: [{ className: "dt-right stock-num", "targets": [5] }],
			orderCellsTop: true,
        	fixedHeader: true
        } );

        $("#find").click(function(){
        	company_id 	= $("#company_id").val();
        	store_id 	= $("#store_id").val();
        	_token		= $("_token").val();

        	if(store_id > 0){
        		//table.clear().draw();

        		$.ajax({
        			type: "GET",
		            url: "{{route('stock.list.data')}}",
		            data: {
		                company_id: company_id,
		                store_id: 	store_id,
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
			                data.push({
			                    article: 	item.description,
			                    trademark:  item.trademark,
			                    model: 	    item.model,
			                    stock: 		Number(item.stock),
			                    company:	item.company
			                });
			            });
			            
			            table.destroy();

			            table = $('#table').DataTable( {
			            	iDisplayLength: 50,
			            	columnDefs: [{ className: "dt-right stock-num", "targets": [4] }],
				        	"columns": [
								{ "data": "article" },
								{ "data": "company" },
				                { "data": "trademark" },
				                { "data": "model" },
				                { "data": "stock"}				                
				            ],
				            data:           data,
				            deferRender:    true,
							orderCellsTop: true,
        					fixedHeader: true
				        } );
						$('.stock-num').each( function (i) {
							if(i>0){
								if (parseInt($('.stock-num')[i].innerText)>0){
									$($(this)[0].parentElement).css('font-weight','bold');
								}
							}	
						} );
						
						$(document).click(function(){
							$('.stock-num').each( function (i) {
								if(i>0){
									if (parseInt($('.stock-num')[i].innerText)>0){
										$($(this)[0].parentElement).css('font-weight','bold');
									}
								}	
							} );
						});
						$(document).keyup(function () {
							$('.stock-num').each( function (i) {
								if(i>0){
									if (parseInt($('.stock-num')[i].innerText)>0){
										$($(this)[0].parentElement).css('font-weight','bold');
									}
								}	
							} );
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

        $("#print").click(function(){
        	//company_id 	= $("#company_id").val();
        	store_id 	= $("#store_id").val();
        	_token		= $("_token").val();
        	search		= $('input[type="search"]').val();

			var data =[];
			$('#table thead tr:eq(1) th').each( function (i) {
				data.push({
								name: $(this)[0].children[0].id.split('_')[1].toLowerCase(),
								search: $(this).children().val()
						});
			});

        	if(store_id > 0){

        		var url = "{{ route('print.articles.stock.list') }}";
        		url = url + "?store_id="+store_id + "&search="+search ;
				data.forEach(function(search){
					url = url + "&"+search.name+"="+search.search;
				});
				window.open(url, '_blank');
        	}
        });

    });


</script>