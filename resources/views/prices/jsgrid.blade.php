<script>
    function setNewPrice(id) {
        $.ajax({
            type: "GET",
            url: "{{route('articles.findById')}}",
            dataType: 'json',
            encode  : true,
            data: {
                'id': id
            },
            success: function (response) {
                clearInputs();
                $('#article').val(response.print_name);
                $('#price_update_level').val(response.price_update_level);
                $('#fee_quantity').val(response.fee_quantity);
                $('#fee_amount').val(response.fee_amount);
                $('#price').val(response.price);
                $('#article_id').val(response.id);
                //$("#article").prop("readonly", true);
                $("#article").val(response.print_name);
                $("#newPriceModal").modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertError('ERROR AL CARGAR ARTICULO');
            }
        });
    }

    function clearInputs() {
        $("#price").val('');
        $("#fee_quantity").val('');
        $("#fee_amount").val('');
        $("#article_delete_name").val('');
        $("#article_delete_id").val('');
    }
    function submitForm() {
        if (validateFieldsNotEmpty()) {
            var price = $("#price").val();
            var fee_quantity = $("#fee_quantity").val();
            var fee_amount = $("#fee_amount").val();
            var article_id = $("#article_id").val();
            var print_name = $("#article").val();
            var point_of_sales_id = $("#point_of_sales_id").val();
            var point_of_sales_description = $("#point_of_sales_id option:selected").html();
            var price_update_level = $("#price_update_level").val();
            var _token = $('input[name="_token"]').val();
            var url = "{{route('articleprice.store')}}";
            if (point_of_sales_id == 1) {
                url = "{{route('articles.fastUpdatePrice')}}";
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: _token,
                    price: price,
                    fee_quantity: fee_quantity,
                    fee_amount: fee_amount,
                    article_id: article_id,
                    point_of_sales_id: point_of_sales_id,
                    price_update_level: price_update_level,
                    print_name: print_name
                },
                success: function (response) {
                    var pointOfSale = [];
                    var articlePrice = [];
                    var newPrice = [];
                    if(response['id']){
                        articlePrice['id'] = response['id'];
                    }
                    pointOfSale['name'] = point_of_sales_description;
                    articlePrice['article_id'] = article_id;
                    articlePrice['price'] = price;
                    articlePrice['fee_quantity'] = fee_quantity;
                    articlePrice['fee_amount'] = fee_amount;
                    articlePrice['point_of_sales'] = pointOfSale;
                    articlePrice['print_name'] = print_name;
                    newPrice[0] = articlePrice;
                    if (point_of_sales_id == 1) {
                        updateRowToTable(newPrice);
                    } else {
                        addOrUpdateRowsToChild(newPrice);
                    }
                    $.notify(
                        {
                            // options
                            icon: 'fas fa-success-circle',
                            message: "Precio registrado con éxito"
                        }, {
                            // settings
                            type: "success",
                            showProgressbar: false,
                            animate: {
                                enter: 'animated bounceIn',
                                exit: 'animated bounceOut'
                            }
                        }
                    );
                    $("#newPriceModal").modal('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alertError('Ocurrió un error al guardar');
                }
            });
        }
        else {
            alertError('Complete todos los datos antes de guardar');
        }
    }
    function alertError(msg) {
        $.notify({
                icon: 'fas fa-exclamation-circle',
                message: msg
            }, {
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
    function validateFieldsNotEmpty() {
        var valid = true;
        $("form#priceForm :input").each(function(){
            var input = $(this);
            if(input.val() == '') {
                input.focus();
                valid = false;
            }
        });
        return valid;
    }
</script>