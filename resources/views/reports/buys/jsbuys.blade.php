<script type="text/javascript">
    let table;

    $(document).ready(function() {
        var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="status_id"]').selectpicker(customerOptions);

        table = $('#table').DataTable({
            iDisplayLength: 50,
        });

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        $("#find").click(function(){
            let _token		= $("_token").val();
            const supplierId = $('#supplier_id').val();

            if(supplierId != ''){
                table.clear().draw();
                $.ajax({
                    type: "GET",
                    url: "{{route('buys.report-form.data')}}",
                    data: {
                        date_init: parseDate($('#date_init').val()),
                        date_end: parseDate($('#date_end').val()),
                        supplier_id: supplierId
                    },
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    success: function (response) {
                        const data = [];
                        $.each(response, function(i, item){
                            data.push({
                                supplier_name:  item.supplier_name,
                                voucher_type:   item.voucher_type,
                                sell_point:   item.sell_point,
                                voucher_number: 	item.voucher_number,
                                article_description: 	item.article_description,
                                by_article: 	item.cost_by_article,
                                net_total_voucher: item.net_total_by_voucher,
                                date:  item.date
                            });
                        });

                        table.destroy();

                        table = $('#table').DataTable( {
                            iDisplayLength: 10,
                            columnDefs: [{ className: "dt-right", "targets": [7] }],
                            "columns": [
                                { "data": "supplier_name" },
                                { "data": "voucher_type" },
                                { "data": "sell_point" },
                                { "data": "voucher_number" },
                                { "data": "article_description"},
                                { "data": "by_article" },
                                { "data": "net_total_voucher" },
                                { "data": "date" },
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

        $("#print-report").click(function(){
            const supplierId    = $('#supplier_id').val();
            const dateInit     = parseDate($('#date_init').val());
            const dateEnd      = parseDate($('#date_end').val());

            if(dateInit !== '' && dateEnd !== ''){
                let url = "{{ route('print.bought.articles') }}";
                url = `${url}?supplier_id=${supplierId}&date_init=${dateInit}&date_end=${dateEnd}`;
                window.open(url, '_blank');
            }
        });

        const parseDate = (rawDate) => {
            const arr = rawDate.split('/');
            return arr[2]+'-'+arr[1]+'-'+arr[0];
        }
    });
</script>
