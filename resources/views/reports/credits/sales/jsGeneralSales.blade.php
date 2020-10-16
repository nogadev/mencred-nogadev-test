<script type="text/javascript">
    var table;
    var details = [];

    $(document).ready(function () {
        $('#table thead tr').clone(true).appendTo( '#table thead' );
		$('#table thead tr:eq(1) th').each( function (i) {
            if (i!==0){
                var title = $(this).text();
                $(this).html( '<input id="search_'+title+'" class="form-control form-control-sm" placeholder="'+title+'" disabled/>' );
        
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
                }else if(id_search==="search_CREDITO"||id_search==="search_CANTIDAD"||id_search==="search_PRECIO"||id_search==="search_TOTAL"){
                    $(this)[0].children[0].setAttribute('type', 'number');
                }else{
                     $(this)[0].children[0].setAttribute('type', 'text');
                }   

            }else{
                $(this)[0].innerHTML="";
            }
			
		} );

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        table = $('#table').DataTable({
            iDisplayLength: 50,
            columnDefs: [
                {
                    className: "dt-right",
                    "targets": [5, 6]
                },
                {
                    className: "dt-center",
                    "targets": [4, 7]
                },
                {
                    "targets": [ 10 ],
                    "visible": false
                }
            ],
            orderCellsTop: true,
        	fixedHeader: true

        });

        $("#find").click(function () {
            date_init = $("#date_init").val();
            date_end = $("#date_end").val();
            _token = $("_token").val();

            if (date_init != '' && date_end != '') {

                $.ajax({
                    type: "GET",
                    url: "{{route('sales.general.data')}}",
                    data: {
                        date_init: date_init,
                        date_end: date_end
                    },
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    success: function (response) {
                        $('#table thead tr:eq(1) th').each( function (i) {
                            if (i!==0){
                                $(this)[0].children[0].disabled = false;
                            }
                        });

                        data = [];
                        $.each(response, function (i, item) {
                            arr = item.init_date.split(' ')[0].split('-');
                            date = arr[2] + '/' + arr[1] + '/' + arr[0];
                            data.push({
                                date: date,
                                customer: item.customer + " - DNI: " + item.document,
                                article: item.article,
                                company: item.company,
                                quantity: item.quantity,
                                point_of_sale: item.point_of_sale,
                                price: new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(item.price),
                                total: new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(parseFloat(item.quantity * item.price).toFixed(2)),
                                billed: item.billed,
                                credit_id: item.credit_id,
                                article_credit_id: item.article_credit_id
                            });
                            details = data;
                        });

                        table.destroy();

                        table = $('#table').DataTable({
                            iDisplayLength: 50,
                            columnDefs: [{
                                    className: "dt-right",
                                    "targets": [5, 6]
                                },
                                {
                                    className: "dt-center",
                                    "targets": [0, 2, 4]
                                },
                                {
                                    "targets": [ 10 ],
                                    "visible": false
                                },
                                {
                                    "bSortable": false,
                                    "targets": '_all'
                                },
                                {
                                    "bSearchable": true,
                                    "targets": '_all'
                                }
                            ],
                            "columns": [
                                {
                                    "data": "billed",
                                    "render": function (data, type, row) {
                                        return (data == true) ? '<input id="invoiced" type="checkbox" checked="checked" class="checkbox_checked" onclick="markAsInvoiced(this)">' : '<input id="invoiced" type="checkbox" class="checkbox_unchecked" onclick="markAsInvoiced(this)">'
                                    }
                                },
                                {
                                    "data": "date"
                                },
                                {
                                    "data": "credit_id"
                                },
                                {
                                    "data": "customer"
                                },
                                {
                                    "data": "article"
                                },
                                {
                                    "data": "company"
                                },
                                {
                                    "data": "quantity"
                                },
                                {
                                    "data": "point_of_sale"
                                },
                                {
                                    "data": "price"
                                },
                                {
                                    "data": "total"
                                },
                                {
                                    "data": "article_credit_id"
                                }

                            ],
                            data: data,
                            deferRender: true,
                            orderCellsTop: true,
        	                fixedHeader: true
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.notify({
                            icon: 'fas fa-exclamation-circle',
                            message: "Error obteniendo los datos"
                        }, {
                            type: "warning",
                            showProgressbar: false,
                            mouse_over: 'pause',
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        });
                    }
                });
            }
        });

        $("#print").click(function () {
            date_init = $("#date_init").val();
            date_end = $("#date_end").val();
            _token = $("_token").val();
            search = $('input[type="search"]').val();

            var data =[];
			$('#table thead tr:eq(1) th').each( function (i) {
                if (i!==0){
                    data.push({
                                    name: $(this)[0].children[0].id.split('_')[1].toLowerCase(),
                                    search: $(this).children().val()
                            });
                }
			});

            if (date_init != '' && date_end != '') {
                var url = "{{ route('print.sales.general') }}";
                url = url + "?date_init=" + date_init + "&date_end=" +
                    date_end + "&search=" + search;
                data.forEach(function(search){
                    url = url + "&"+search.name+"="+search.search;
                });
                window.open(url, '_blank');
            }
        });

        $('#date_init').datepicker('setDate', '0d');
        $('#date_end').datepicker('setDate', '0d');

    });

    function markAsInvoiced(data){
        row = $('#table').DataTable().row($(data).parents('tr')).data();
        id = row.article_credit_id;
        invoiced = data.checked;
        $.ajax({
                type    : 'POST',
                url     : "{{ route('sales.general.markinvoiced') }}",
                data    : {
                    "id"       : id,
                    "invoiced" : invoiced,
                    "_token": $("meta[name='csrf-token']").attr("content"),
                },
                dataType: 'json',
                encode  : true,
                success: function(response){
                    $.notify(
                        {
                            icon: 'fas fa-exclamation-circle',
                            message: 'Actualizado'
                        },{
                            type: "success",
                            showProgressbar: false,
                            mouse_over: 'pause',
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        }
                    );
                },
                error: function(jqXHR, textStatus, errorThrown) {
                $.notify(
                    {
                        icon: 'fas fa-exclamation-circle',
                        message: "Se ha producido un error"
                    },
                    {
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

</script>
