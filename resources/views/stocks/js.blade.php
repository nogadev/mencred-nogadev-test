<script type="text/javascript">
var originArticles = [];
var destinationArticles = [];
var autoNumerics = [];

$(document).ready(function() {
    $('#date').datepicker({
        format: "dd/mm/yyyy",
        maxViewMode: "decades",
        endDate: "0d",
        language: "es",
        autoclose: true
    });

    var _token = $('input[name="_token"]').val();

    $('select[name="origin_store_id"]').selectpicker(selectBootDefaOpt);
    $('select[name="origin_company_id"]').selectpicker(selectBootDefaOpt);
    $('select[name="destination_company_id"]').selectpicker(selectBootDefaOpt);
    $('select[name="destination_store_id"]').selectpicker(selectBootDefaOpt);

    
    originTable = $('#originArticles').DataTable({
        serverSide: true,
        ajax: {
            url: "{{url('api/stock.articles')}}",
            type: "POST",
            data: function(data) {
                data.store_id = $('select[name="origin_store_id"]').val();
                data.company_id = $('select[name="origin_company_id"]').val();
                _token : _token;
            }
        },
        columns: [
            {data: "article.description"},
            {data: "stock"},
            {data: "actions"}
        ],
        columnDefs: [{ className: "dt-right", "targets": [1,2] }]
    });

    $('#originArticles tbody').on('click', 'tr button', function () {
        addArticle(originTable.row( this.closest('tr') ).data());
    } );

    destinationTable = $('#destinationArticles').DataTable({
        columnDefs: [{ className: "dt-right", "targets": [1,2] }]
    });

    $('#transferForm').submit(function(eventObj) {
        if ($('input[name="date"').val() == "" ||
            $('select[name="origin_store_id"').val() == "" ||
            $('select[name="origin_company_id"').val() == "" ||
            $('select[name="destination_store_id"').val() == "" ||
            $('select[name="destination_company_id"').val() == "" ||
            destinationArticles.length == 0) {
            $.notify(
                {
                    // options
                    icon: 'fas fa-exclamation-circle',
                    message: "Complete todos los datos"
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
            return false;
        } else if (($('select[name="origin_store_id"').val() == $('select[name="destination_store_id"').val()) && $('select[name="origin_company_id"').val() == $('select[name="destination_company_id"').val() ) {
            $.notify(
                {
                    // options
                    icon: 'fas fa-exclamation-circle',
                    message: "Los depósitos de origen y destino son iguales"
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
            return false;
        } else {
            var articlesJSON = [];
            var index = 0;
            destinationArticles.forEach(element => {
                var row = {};
                row["article_id"] = element.article.id;
                row["quantity"] = autoNumerics[index].getNumber();
                articlesJSON.push(row);
                index++;
            });
            $("#art_data").html(JSON.stringify(articlesJSON));
        }
        return true;
    });

    $('#date').datepicker('setDate', '0d');

});

function fillOriginArticles() {
    destinationTable.clear().draw();
    destinationArticles.length = 0;
    originTable.draw();
}

function addArticle(object) {
    if (object.stock > 0) {
        if (!existsArticle(object.article)) {
            destinationTable.row.add([
                object.article.description,
                "<td><input id='q_" + destinationArticles.length + "'  type='text' class='form-control' /></td>",
                "<td><div style='display:inline;'><button type='button'class='btn btn-sm btn-danger' onclick='deleteArticle(" + destinationArticles.length + ")'><i class='fas fa-window-close'></i></button></div></td>"         
            ]).draw( false );
            var defaultQuantity = 1.00;
            if (defaultQuantity > object.stock) {
                defaultQuantity = object.stock;
            }
            autoNumerics.push(new AutoNumeric("#q_" + destinationArticles.length, decimal)
                                        .set(defaultQuantity)
                                        .update(
                                            {
                                                minimumValue: defaultQuantity,
                                                maximumValue: object.stock
                                            })
                                        );        
            var toSend = [];
            toSend["article"] = object.article;
            toSend["quantity"] = defaultQuantity;
            destinationArticles.push(toSend);   
        } else {
            $.notify(
                {
                    // options
                    icon: 'fas fa-exclamation-circle',
                    message: "El artículo ya se ha seleccionado"
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
    } else {
        $.notify(
            {
                // options
                icon: 'fas fa-exclamation-circle',
                message: "El artículo no tiene stock disponible para transferir"
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
}

function existsArticle(article) {
    var exists = false;
    destinationArticles.forEach(element => {
        if (element.article.id === article.id) {
            exists = true;
            return;
        }
    });
    return exists;
}

function deleteArticle(index) {
    $.notify(
        {
            // options
            icon: 'fas fa-exclamation-circle',
            message: "Funcionalidad no implementada aún"
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
</script>