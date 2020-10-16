<script type="text/javascript">
    var idcredit;

    $(document).ready(function () {

        let isOpenCash = {!! json_encode($isOpenCash) !!};
        if(!isOpenCash) {
            //CAJA CERRADA
            $('#cashModal').modal('show');
        }
        var deliveryOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="delivery_id"]').selectpicker(deliveryOptions);

        var routeOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="route_id"]').selectpicker(routeOptions);

        var statusOptions = $.extend({}, selectBootDefaOpt);
        $('select[name="status_id"]').selectpicker(statusOptions);

        $('select[name="status_id"]').on('change', function () {
            $("#frm_credit_search").submit();
        });

        $('select[name="route_id"]').on('change', function () {
            $("#frm_credit_search").submit();
        });

        $('select[name="perPage"]').on('change', function () {
            $("#frm_credit_search").submit();
        });

    });

    function approve(id) {
        $('#confirmModal').modal('show');
        idcredit = id;
    }

    function rechazar(id) {
        $('#rechazarModal').modal('show');
        idcredit = id;
    }

    function approveCancel() {
        $('#confirmModal').modal('hide');
        idcredit = 0;
    }

    function rechazarCancel() {
        $('#rechazarModal').modal('hide');
        idcredit = 0;
    }


    function approveConfirm() {

        $.ajax({
            type: "GET",
            url: "{{route('credits.changeStatus')}}",
            data: {
                id: idcredit,
                status_id: 2
            },
            dataType: "json",
            success: function (response) {
                // si responde 13 (este numero corresponde al estado del credito) indica que el credito se cancelo en el pago inicial
                if (response ===13) {
                    $("#status" + idcredit).html('CONTADO');
                }else{
                    $("#status" + idcredit).html('OPERANDO');
                }
                $("#div_" + idcredit).load(window.location.href + " #div_" + idcredit);
                $.notify({
                    icon: 'fas fa-success-circle',
                    message: "Crédito confirmado con éxito"
                }, {
                    type: "success",
                    showProgressbar: false,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated bounceOut'
                    }
                });

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
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
        $('#confirmModal').modal('hide');
    }

    function rechazarConfirm() {

        $.ajax({
            type: "GET",
            url: "{{route('credits.changeStatus')}}",
            data: {
                id: idcredit,
                status_id: 6
            },
            dataType: "json",
            success: function (response) {
                $("#status" + idcredit).html('RECHAZADO');
                $($("#status" + idcredit)[0].parentNode).addClass("bg-danger text-white");
                $("#div_" + idcredit).load(window.location.href + " #div_" + idcredit);
                $.notify({
                    icon: 'fas fa-success-circle',
                    message: "Crédito rechazado con éxito"
                }, {
                    type: "success",
                    showProgressbar: false,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated bounceOut'
                    }
                });

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
        $('#rechazarModal').modal('hide');
    }

    function cancel(id) {
        $('#cancelModal').modal('show');
        idcredit = id;
    }

    function cancelCancel() {
        $('#cancelModal').modal('hide');
        idcredit = 0;
    }


    function cancelConfirm() {

        $.ajax({
            type: "GET",
            url: "{{route('credits.changeStatus')}}",
            data: {
                id: idcredit,
                status_id: 4
            },
            dataType: "json",
            success: function (response) {
                $("#status" + idcredit).html('CANCELADO');
                $("#div_" + idcredit).load(window.location.href + " #div_" + idcredit);
                $.notify({
                    icon: 'fas fa-success-circle',
                    message: "Crédito cancelado con éxito"
                }, {
                    type: "success",
                    showProgressbar: false,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated bounceOut'
                    }
                });

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
        $('#cancelModal').modal('hide');
    }

</script>
