<script type="text/javascript">
    var table,a_quantity,a_net,a_bonus_p,a_bonus,a_tax,a_subtotal,proffit,net_price;
    var net_1,net_2,net_3,net_4,net_5,tax_1,tax_2,tax_3,tax_4,tax_5,total;
    var taxesJSON = [];
    var articlesJSON = [];
    var itemNo = 0;
    var taxesID =  [];

    $(document).ready(function() {

        $.each(@json($taxes) , function ($key, tax){
            taxesID[tax.value] = tax.id;
        });

        var supplierOptions = $.extend( {}, selectBootDefaOpt);
        supplierOptions["noneResultsText"] += "<br><button type='button' class='btn btn-success' onclick='newSupplier()'>Crear nuevo</button>";
        $('select[name="supplier_id"]').selectpicker(supplierOptions);

        $('select[name="voucher_type_id"]').selectpicker(selectBootDefaOpt);
        
        var companyOptions = $.extend( {}, selectBootDefaOpt);
        companyOptions["noneResultsText"] += "<br><button type='button' class='btn btn-success' onclick='newCompany()'>Crear nueva</button>";
        $('select[name="company_id"]').selectpicker(companyOptions);
        
        var articleOptions = $.extend( {}, selectBootDefaOpt);
        articleOptions["noneResultsText"] += "<br><button type='button' class='btn btn-success' onclick='newArticle()'>Crear nuevo</button>";
        $('select[name="a_id"]').selectpicker(articleOptions);
        
        var storeOptions = $.extend( {}, selectBootDefaOpt);
        storeOptions["noneResultsText"] += "<br><button type='button' class='btn btn-success' onclick='newStore()'>Crear nuevo</button>";
        $('select[name="store_id"]').selectpicker(storeOptions);

        $('#date').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        $('#date').datepicker('setDate', '0d');

        a_quantity  = new AutoNumeric("#a_quantity", decimal);
        a_net       = currency_format("#a_net");
        a_bonus_p   = new AutoNumeric("#a_bonus_p", percentage);
        a_bonus     = currency_format("#a_bonus");
        a_tax       = currency_format("#a_tax");
        a_subtotal  = currency_format("#a_subtotal");

        table = $('#tableArticles').DataTable({
            columnDefs: [{ className: "dt-right", "targets": [2,3,4,5,6] }]
        });
        net_1 = currency_format("#net_1");
        net_2 = currency_format("#net_2");
        net_3 = currency_format("#net_3");
        tax_1 = currency_format("#tax_1");
        tax_2 = currency_format("#tax_2");
        tax_3 = currency_format("#tax_3");
        total = currency_format("#total");

        $('#buyForm').submit(function(eventObj) {
            $("#art_data").html(JSON.stringify(articlesJSON));
            return true;
        });
    }); 

    function newSupplier(){
        $('#newSupplierModal').modal('show');
    }

    function storeNewSupplier(){
        if ($("#new_supplier_code").val() != "" ||
            $("#new_supplier_name").val() != "") {
                var _token = $('input[name="_token"]').val();
                var data = {
                    'code' : $("#new_supplier_code").val(),
                    'name' : $("#new_supplier_name").val(),
                    'business_name' : $("#new_supplier_name").val(),
                    _token : _token
                };

                $.ajax({
                    type: "POST",
                    url: "{{route('suppliers.fastStore')}}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('select[name="supplier_id"]').append(
                            $("<option></option>")
                                .attr("value", response["id"])
                                .text(response["name"])
                        ).selectpicker('refresh');
                        $('select[name="supplier_id"]').selectpicker('val', response["id"]);
                        $('input[name="business_name"]').val(response["business_name"]);
                        $('input[name="code"]').val(response["code"]);
                        $('input[name="address"]').val(response["address"]);
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.notify(
                            {
                                // options
                                icon: 'fas fa-exclamation-circle',
                                message: "Se ha producido un error"
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
                $("#new_supplier_code").val("");
                $("#new_supplier_name").val("");
                $("#newSupplierModal").modal('hide');           
        } else {
            //Show error
        }
    }

    function setSupplierData() {
        var _token = $('input[name="_token"]').val();
        var data = {
            'id' : $('select[name="supplier_id"]').val(),
            _token : _token
        };
        $.ajax({
            type: "POST",
            url: "{{route('suppliers.getById')}}",
            data: data,
            dataType: "json",
            success: function (response) {
                $('input[name="business_name"]').val(response["business_name"]);
                $('input[name="code"]').val(response["code"]);
                $('input[name="address"]').val(response["address"]);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(
                    {
                        // options
                        icon: 'fas fa-exclamation-circle',
                        message: "Se ha producido un error"
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

    function newCompany(){
        $('#newCompanyModal').modal('show');
    }

    function storeNewCompany(){
        if ($("#new_company_name").val() != "") {
                var _token = $('input[name="_token"]').val();
                var data = {
                    'name' : $("#new_company_name").val(),
                    _token : _token
                };

                $.ajax({
                    type: "POST",
                    url: "{{route('companies.fastStore')}}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('select[name="company_id"]').append(
                            $("<option></option>")
                                .attr("value", response["id"])
                                .text(response["name"])
                        ).selectpicker('refresh');
                        $('select[name="company_id"]').selectpicker('val', response["id"]);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.notify(
                            {
                                // options
                                icon: 'fas fa-exclamation-circle',
                                message: "Se ha producido un error"
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
                $("#new_company_name").val("");
                $("#newCompanyModal").modal('hide');           
        } else {
            //Show error
        }
    }

    function clearArticle() {
        $('select[name="a_id"]').selectpicker('val', '');
        a_quantity.set(0.00);
        a_net.set(0.00);
        a_bonus_p.set(0.00);
        a_bonus.set(0.00);
        a_tax.set(0.00);
        a_subtotal.set(0.00);
    }

    function newArticle(){
        $('#newArticleModal').modal('show');
    }

    function storeNewArticle(){
        if ($("#new_article_description").val() != "" &&
            $("#new_article_price_list").val() != "") {
                var _token = $('input[name="_token"]').val();
                var data = {
                    'description' : $("#new_article_description").val(),
                    'print_name' : $("#new_article_price_list").val(),
                    _token : _token
                };

                $.ajax({
                    type: "POST",
                    url: "{{route('articles.fastStore')}}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('select[name="a_id"]').append(
                            $("<option></option>")
                                .attr("value", response["id"])
                                .text(response["description"])
                        ).selectpicker('refresh');
                        $('select[name="a_id"]').selectpicker('val', response["id"]);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.notify(
                            {
                                icon: 'fas fa-exclamation-circle',
                                message: "Se ha producido un error"
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
                $("#new_article_description").val("");
                $("#new_article_price_list").val("");
                $("#newArticleModal").modal('hide');           
        }
    }

    function calculate(source) {
        var q = a_quantity.getNumber();
        var n = a_net.getNumber();
        var b_p = a_bonus_p.getNumber();
        var b = a_bonus.getNumber();
        var t_p = $("#a_tax_p").val();
        var t = a_tax.getNumber();
        var s = a_subtotal.getNumber();

        switch (source) {
            case 'a_tax_p':
                break;
            case 'a_bonus':
                b_p = b * 100 / (q * n);
                break;
            default:
                b = q * n * b_p / 100;
                break;
        }
        t = ((q * n) - b) * t_p / 100;
        s = (q * n) - b + t;

        a_quantity.set(q);
        a_net.set(n);
        a_bonus_p.set(b_p);
        a_bonus.set(b);
        a_tax.set(t);
        a_subtotal.set(s);
    }

    function canAddArticle(){
        var can = $('select[name="a_id"]').val() != "" &&
                    a_quantity.getNumber() > 0 &&
                    a_subtotal.getNumber() > 0 &&
                    $("#a_tax_p").val() !== "";

        if (!can) {
            $.notify(
                {
                    // options
                    icon: 'fas fa-exclamation-circle',
                    message: "El artículo, cantidad precio y alícuota son obligatorios."
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
        } else {
            addRow();
        }        
    }

    function addRow(){
        itemNo++;
        var row = {
            article_id      : $('select[name="a_id"]').val(),
            item_no         : itemNo,
            quantity        : a_quantity.getNumber(),
            article         : $('select[name="a_id"] option:selected').text(),
            net             : a_net.getNumber(),
            bonus_percentage: a_bonus_p.getNumber(),
            bonus           : a_bonus.getNumber(),
            tax_percentage  : $("#a_tax_p").val(),
            tax             : a_tax.getNumber(),
            subtotal        : a_subtotal.getNumber(),
            tax_id          : taxesID[$("#a_tax_p").val()]
        }
        articlesJSON.push(row);

        var tax_idx = taxesJSON.indexOf($("#a_tax_p").val()) + 1;
        if (tax_idx == 0) {
            taxesJSON.push($("#a_tax_p").val());
            tax_idx = taxesJSON.length;
        }

        switch (tax_idx) {
            case 1:
                net_1.set(net_1.getNumber() + (a_net.getNumber() * a_quantity.getNumber()) - a_bonus.getNumber());
                tax_1.set(tax_1.getNumber() + a_tax.getNumber());
                $("#lbl_net_1").html("Neto " + $("#a_tax_p option:selected").text());
                $("#lbl_tax_1").html("Iva " + $("#a_tax_p option:selected").text());
                break;
        
            case 2:
                net_2.set(net_2.getNumber() + (a_net.getNumber() * a_quantity.getNumber()) - a_bonus.getNumber());
                tax_2.set(tax_2.getNumber() + a_tax.getNumber());
                $("#lbl_net_2").html("Neto " + $("#a_tax_p option:selected").text());
                $("#lbl_tax_2").html("Iva " + $("#a_tax_p option:selected").text());
                break;
        
            case 3:
                net_3.set(net_3.getNumber() + (a_net.getNumber() * a_quantity.getNumber()) - a_bonus.getNumber());
                tax_3.set(tax_3.getNumber() + a_tax.getNumber());
                $("#lbl_net_3").html("Neto " + $("#a_tax_p option:selected").text());
                $("#lbl_tax_3").html("Iva " + $("#a_tax_p option:selected").text());
                break;
        
            /*case 4:
                net_4.set(net_4.getNumber() + (a_net.getNumber() * a_quantity.getNumber()) - a_bonus.getNumber());
                tax_4.set(tax_4.getNumber() + a_tax.getNumber());
                $("#lbl_net_4").html("Neto " + $("#a_tax_p option:selected").text());
                $("#lbl_tax_4").html("Iva " + $("#a_tax_p option:selected").text());
                break;
        
            case 5:
                net_5.set(net_5.getNumber() + (a_net.getNumber() * a_quantity.getNumber()) - a_bonus.getNumber());
                tax_5.set(tax_5.getNumber() + a_tax.getNumber());
                $("#lbl_net_5").html("Neto " + $("#a_tax_p option:selected").text());
                $("#lbl_tax_5").html("Iva " + $("#a_tax_p option:selected").text());
                break;*/
        }

        total.set(net_1.getNumber() + tax_1.getNumber() + net_2.getNumber() + tax_2.getNumber() + net_3.getNumber() + tax_3.getNumber()); // + net_4.getNumber() + tax_4.getNumber() + net_5.getNumber() + tax_5.getNumber());
        
        table.row.add([
            row["item_no"],
            row["article"],
            a_quantity.getFormatted(),
            a_net.getFormatted(),
            a_bonus.getFormatted(),
            a_tax.getFormatted(),
            a_subtotal.getFormatted(),
            ""
            //"<td><div style='display:inline;'><button type='button'class='btn btn-sm btn-danger' onclick='deleteRow()'><i class='fas fa-trash'></i></button></div></td>"           
        ]).draw( false );
        clearArticle();
    }

    function newStore(){
        $('#newStoreModal').modal('show');
    }

    function storeNewStore(){
        if ($("#new_store_name").val() != "") {
                var _token = $('input[name="_token"]').val();
                var data = {
                    'name' : $("#new_store_name").val(),
                    _token : _token
                };

                $.ajax({
                    type: "POST",
                    url: "{{route('stores.fastStore')}}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('select[name="store_id"]').append(
                            $("<option></option>")
                                .attr("value", response["id"])
                                .text(response["name"])
                        ).selectpicker('refresh');
                        $('select[name="store_id"]').selectpicker('val', response["id"]);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $.notify(
                            {
                                // options
                                icon: 'fas fa-exclamation-circle',
                                message: "Se ha producido un error"
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
                $("#new_store_name").val("");
                $("#newStoreModal").modal('hide');           
        } else {
            //Show error
        }
    }

    function confirm() {
        $('#confirmModal').modal('show');
    }

    function currency_format($id_currency){
        return new AutoNumeric($id_currency, {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
    }
</script>