<script>
    function calculateFeeAmount() {
        var fee_amount = 0.0;
        var fee_quantity = 1.0;
        if ($('#fee_amount').val() != '') {
            fee_amount = $('#fee_amount').val();
        }
        if ($('#fee_quantity').val() != '') {
            fee_quantity = $('#fee_quantity').val();
        }
        $('#price').val(fee_amount * fee_quantity);
    }
    function deletePrice() {
        var article_prices_id = $('#article_delete_id').val();
        var _token = $('input[name="_token"]').val();
        var _method = $('input[name="_method"]').val();
        $.ajax({
            type: "POST",
            url: "{{route('articles.price.destroy')}}",
            data: {
                _token: _token,
                _method: _method,
                id: article_prices_id
            },
            success: function (response) {
                $('#article_price_' + article_prices_id).hide('slow');
                $('#article_price_' + article_prices_id).remove();
                $.notify(
                    {
                        // options
                        icon: 'fas fa-success-circle',
                        message: "Precio eliminado con éxito"
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
                $("#deleteModal").modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertError('Ocurrió un error al eliminar');
            }
        });
    }
    function confirmDelete(articleprice_id, article_id) {
        if (articleprice_id > 0) {
            clearInputs();
            $("#article_delete_id").val(articleprice_id);
            var details = getArticlePriceDetails(articleprice_id, article_id);
            $("#article_delete_name").val(details['article_description']);
            $("#article_delete_name").prop("readonly", true);
            $('#delete_point_of_sales').html(details['articleprice']['point_of_sales_descripcion']);
            $('#delete_price').html(details['articleprice']['price']);
            $('#delete_fee_quantity').html(details['articleprice']['fee_quantity']);
            $('#delete_fee_amount').html(details['articleprice']['fee_amount']);
            $("#deleteModal").modal('show');
        }
    }
    function editPrice(articleprice_id, article_id) {
        var details = getArticlePriceDetails(articleprice_id, article_id);
        $.ajax({
            type: "GET",
            url: "{{route('articles.findById')}}",
            dataType: 'json',
            encode  : true,
            data: {
                'id': article_id
            },
            success: function (response) {
                clearInputs();
                $("#article_id").val(article_id);
                $('#article').val(details['article_description']);
                $("#article").prop("readonly", true);
                $('#point_of_sales_id option:contains("' + details['articleprice']['point_of_sales_descripcion'] + '")').prop('selected', true);
                $('#price').val(details['articleprice']['price']);
                $('#fee_quantity').val(details['articleprice']['fee_quantity']);
                $('#fee_amount').val(details['articleprice']['fee_amount']);
                $('#price_update_level').val(response.price_update_level);
                $("#newPriceModal").modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alertError('ERROR AL CARGAR ARTICULO');
            }
        });
    }
    function cancelModal() {
        $('#deleteModal').modal('hide');
    }
    function getArticlePriceDetails(articleprice_id, article_id) {
        $("#article_delete_id").val(articleprice_id);
        var article_row = $('#' + article_id);
        var article_children_row = $('#article_price_' + articleprice_id);
        var details = [];
        var articleprice = [];
        articleprice['point_of_sales_descripcion'] = article_children_row.find('td:eq(0)').html();
        articleprice['price'] = article_children_row.find('td:eq(3)').html();
        articleprice['fee_quantity'] = article_children_row.find('td:eq(1)').html();
        articleprice['fee_amount'] = article_children_row.find('td:eq(2)').html();
        details['article_id'] = articleprice_id;
        details['article_description'] = article_row.find('td:eq(1)').html();
        details['articleprice'] = articleprice;
        return details;
    }
</script>