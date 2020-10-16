<script type="text/javascript">
    var table;
    var a_quantity;
    var point_of_sale;
    var a_price;
    var a_subtotal;
    var stock;
    var total;
    var total_tmp;
    var fee_quantity;
    var fee_amount;
    var last_fee_quantity;
    var last_fee_amount;
    var init_pay;
    var taxesJSON = [];
    var articlesJSON = [];
    var itemNo = 0;

    $(document).ready(function () {
        let isOpenCash = {!! json_encode($isOpenCash) !!};
        if(!isOpenCash) {
            //CAJA CERRADA
            $('#cashModal').modal('show');
        }

        //Autocomple Article
        var path_p = "{{ route('articleStocks.getByStoreAndCompany') }}";
        $('#a_id').typeahead({
            minLength: 3,
            hint: true,
            highlight: true,
            freeInput: false,
            autoselect: 'first',
            source: function (query, process) {
                return $.get(path_p, {
                    keyword: query,
                    company_id: $("#company_id").val(),
                    store_id: $("#store_id").val()
                }, function (data) {
                    return process(data);
                });
            },
            updater: function (item) {
                article_id = $('select[name="a_id"]').val();
                store_id = $('select[name="store_id"]').val();

                a_price.set(parseFloat(item["price"]));
                stock = parseFloat(item["stock"]);
                $('#article_id').val(item["id"]);
                $('#article_description').val(item["product"]);
                return item.product;
            }
        }).on('focusout', function (event) {
            if ($('#prod_ac').val() == '') {
                $('#prod_id').val('');
            }
        });


        var customerOptions = $.extend({}, selectBootDefaOpt);
        /*customerOptions["noneResultsText"] +=
            "<br><button type='button' class='btn btn-success' onclick='newcustomer()'>CREAR NUEVO</button>";*/
        $('select[name="customer_id"]').selectpicker(customerOptions);

        var deliveryOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="delivery_id"]').selectpicker(deliveryOptions);

        var sellerOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="seller_id"]').selectpicker(sellerOptions);

        var companyOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="company_id"]').selectpicker(companyOptions);

        var storeOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="store_id"]').selectpicker(storeOptions);

        var pointOfSaleOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="point_of_sale_id"]').selectpicker(pointOfSaleOptions);

        $('select[name="new_customer_route"]').selectpicker(selectBootDefaOpt);

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        a_quantity = new AutoNumeric("#a_quantity", decimal);
        a_price = new AutoNumeric("#a_price", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        a_subtotal = new AutoNumeric("#a_subtotal", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        total = new AutoNumeric("#total", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        total_tmp = new AutoNumeric("#total", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        fee_quantity = new AutoNumeric("#fee_quantity", integer);
        fee_amount = new AutoNumeric("#fee_amount", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        init_pay = new AutoNumeric("#init_pay", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});

        table = $('#tableArticles').DataTable({
            columnDefs: [{
                className: "dt-right",
                "targets": [2, 3, 4, 5, 6, 7]
            }]
        });

        $('#creditForm').submit(function (eventObj) {
            $("#art_data").html(JSON.stringify(articlesJSON));
            return true;
        });


        $("#fee_quantity").blur(function (e) {
            if(fee_quantity.getNumber() > 0) {
                fee_amount.set(Math.ceil((total_tmp.getNumber() - init_pay.getNumber()) / fee_quantity.getNumber()));
                total.set(fee_amount.getNumber() * fee_quantity.getNumber() );
                last_fee_quantity = fee_quantity.getNumber()
            } else {
                fee_quantity.set(last_fee_quantity)
            }
        });

        $("#fee_amount").blur(function (e) {
            if(fee_amount.getNumber() > 0) {
                fee_quantity.set(Math.ceil((total_tmp.getNumber() - init_pay.getNumber()) / fee_amount.getNumber()));
                total.set(fee_amount.getNumber() * fee_quantity.getNumber() );
                last_fee_amount = fee_amount.getNumber()
            } else {
                fee_amount.set(last_fee_amount)
            }
        });

        $('.datepicker').datepicker('setDate', '0d');
    });

    $("#creditForm").submit(function (e) {
        e.preventDefault();
        $('#confirmModal').modal('show');
    });



    function saveConfirm() {
        $('#confirmModal').modal('hide');

        var form = $("#creditForm");
        var url = form.attr('action');
        var data = form.serialize();
            
        $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    $.notify({
                        icon: 'fas fa-exclamation-circle',
                        message: response.message
                    }, {
                        type: "success",
                        showProgressbar: false,
                        mouse_over: 'pause',
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    });
                    location.reload();
                },
                error: function (response) {
                    $.notify({
                        icon: 'fas fa-exclamation-circle',
                        message: response.responseJSON.message
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

    function saveCancel() {
        $('#confirmModal').modal('hide');
    }

    function getProducts() {
        clearArticle();

        store_id = $('select[name="store_id"]').val();
        company_id = $('select[name="company_id"]').val();

        if (store_id > 0 && company_id > 0) {
            $("#a_id").prop('disabled', false);
        } else {
            $("#a_id").prop('disabled', true);
        }
    }

    function getPriceByPointOfSale() {
        article_id = $("#article_id").val();
        point_of_sale_id = $('select[name="point_of_sale_id"]').val();

        $.ajax({
            type: "GET",
            url: "{{route('articles.price.pointofsale')}}",
            data: {
                article_id: article_id,
                point_of_sale_id: point_of_sale_id
            },
            dataType: "json",
            success: function (response) {
                if ($.trim(response)) {
                    a_price.set(parseFloat(response[0].price));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.notify({
                    icon: 'fas fa-exclamation-circle',
                    message: "Se ha producido un error"
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

    function setCustomerData() {
        var _token = $('input[name="_token"]').val();
        var data = {
            'id': $('select[name="customer_id"]').val(),
            _token: _token
        };
        $.ajax({
            type: "POST",
            url: "{{route('customers.getById')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                $('input[name="route_name"]').val(response.route.name);
                $('select[name="seller_id"]').val(response.seller.id).selectpicker("refresh");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.notify({
                    icon: 'fas fa-exclamation-circle',
                    message: "Se ha producido un error"
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

    function clearArticle() {
        $("#a_id").val('');
        $("#a_price").val('');
        $("#article_id").val('');
        $("#article_description").val('');
        $("#serial_number").val('');
        a_quantity.set(1.00);
        a_subtotal.set(0.00);

    }

    function setDeliveryData() {
        var _token = $('input[name="_token"]').val();
        var data = {
            'id': $('select[name="delivery_id"]').val(),
            _token: _token
        };
        $.ajax({
            type: "POST",
            url: "{{route('deliveries.getById')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                $('input[name="delivery_name"]').val(response["name"]);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.notify({
                    icon: 'fas fa-exclamation-circle',
                    message: "Se ha producido un error"
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


    function calculate(source) {

        if (a_quantity.getNumber() <= stock) {

            var q = a_quantity.getNumber();
            s = (q * a_price.getNumber());
            a_subtotal.set(s);

        } else {
            a_quantity.set(0);
            $.notify({
                icon: 'fas fa-exclamation-circle',
                message: "No hay stock suficiente. Stock: " + stock
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
    }

    function AddArticle() {

        if ($('select[name="a_id"]').val() != "" && a_quantity.getNumber() > 0 && a_subtotal.getNumber() > 0) {
            addRow();
        } else {
            $.notify({
                icon: 'fas fa-exclamation-circle',
                message: "Completar todos los campos"
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
    }

    function addRow() {
        itemNo++;
        let button = $('<a>');
        let icon  = $('<i>');
        let actions = $('<td>')
        button.addClass('btn btn-xs btn-danger btn-circle btn-remove');
        icon.addClass('fa fa-times');
        button.attr('onClick', 'removeRow('+itemNo+');');
        button.append(icon);
        actions.append(button);
        var row = {
            item_no: itemNo,
            article_id: $('#article_id').val(),
            company_id: $('#company_id').val(),
            store_id: $('#store_id').val(),
            article: $('#article_description').val(),
            serie: $('#serial_number').val(),
            point_of_sale_id: $('#point_of_sale_id').val(),
            price: a_price.getNumber(),
            quantity: a_quantity.getNumber(),
            subtotal: a_subtotal.getNumber(),
            action: actions.html()
        }
        articlesJSON.push(row);
        total.set(total.getNumber() + a_subtotal.getNumber());
        total_tmp.set(total.getNumber());

        table.row.add([
            row["item_no"],
            row["article_id"],
            row["article"],
            row["serie"],
            a_price.getFormatted(),
            a_quantity.getFormatted(),
            a_subtotal.getFormatted(),
            row["action"]
        ]).draw(false);
        clearArticle();

        if (fee_quantity.getNumber() < 1) {
            fee_quantity.set(1);
        }
        fee_amount.set((total.getNumber() - init_pay.getNumber()) / fee_quantity.getNumber());
        last_fee_quantity = fee_quantity.getNumber();
        last_fee_amount = fee_amount.getNumber();
    }
    
    function removeRow(number) {
        let rows = $('#tableArticles tbody tr');
        let itemN = 0;

        rows.each(function (r, k) {

            let rowN = $(k).find('td:eq(0)').html();

            if(rowN == number){
                let totalRow = parseFloat($(k).find('td:eq(6)').html().replace('$','').replace('.',''));
                fee_amount.set(fee_amount.getNumber() - totalRow);
                total.set(total.getNumber() - totalRow);
                articlesJSON.splice(number-1,1);
                table.row($(k)).remove().draw();
                itemNo--;
            }
            else{
                itemN ++;
                $(k).find('td:eq(0)').html(itemN);
                let linkButton = $(k).find('td:eq(7) a');
                linkButton.remove();
                let button = $('<a>');
                let icon  = $('<i>');
                button.addClass('btn btn-xs btn-danger btn-circle btn-remove');
                icon.addClass('fa fa-times');
                button.attr('onClick', 'removeRow('+itemN+');');
                button.append(icon);
                $(k).find('td:eq(7)').append(button);
            }
        });

    }

</script>
