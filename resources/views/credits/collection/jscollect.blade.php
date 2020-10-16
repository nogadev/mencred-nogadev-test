<script type="text/javascript">
	var table;
	var itemNo = 0;
	var ordenSelect = 0;
	var feeData = [];
	var creditos = [];
	var a_meta;
    var a_cobrado;
    var a_efectividad;
    var a_meta2;
    var a_cobrado2;
    var a_efectividad2;
    var a_paid = [];
    var reasons = [];

	$(document).ready(function(){
        let isOpenCash = {!! json_encode($isOpenCash) !!};
        if(!isOpenCash) {
            //CAJA CERRADA
            $('#cashModal').modal('show');
        }

        $.each(@json($reasons) , function ($key, reason){
            reasons[reason.id] = reason.reason;
        });

		var routeOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="route_id"]').selectpicker(routeOptions);

        var customerOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="customer_id"]').selectpicker(customerOptions);

        var baseOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="paycheck_bank"]').selectpicker(baseOptions);

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            language: "es",
            autoclose: true
        });


	    a_meta 			= new AutoNumeric("#a_meta", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        a_meta2 		= new AutoNumeric("#a_meta2", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
	    a_cobrado 		= new AutoNumeric("#a_cobrado", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        a_cobrado2 		= new AutoNumeric("#a_cobrado2", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
	    a_efectividad 	= new AutoNumeric("#a_efectividad", percentage);
        a_efectividad2 	= new AutoNumeric("#a_efectividad2", percentage);

	    table = $('#tableFees').DataTable({
            columnDefs: [{
                className: "dt-right", "targets": [1,2,3,4,5,6,7,8]
            }],
            "ordering": false,
            "paging": false
        });

        $(document).on('blur', '.inputReason', function() {
            if(!$(this).val()) {
                $(this).focus()
            }
        });

        $('.datepicker').datepicker('setDate', '0d');
	});


    function selectReason(id, isHoliday){
        if(isHoliday) {
            var reason_select = reasons.indexOf('FERIADO')
            if(reason_select !== -1) {
                $("#reason_"+id).val(reasons[reason_select]);
                $("#reason_id_"+id).val(reason_select);
            }
        } else {
            var reason_select = $("#reason_"+id).val();
            if(reason_select < 8){
                $("#reason_"+id).val(reasons[reason_select]);
                $("#reason_id_"+id).val(parseInt(reason_select));
                creditos[id].reason_id = reason_select;
            } else {
                $("#reason_"+id).val('').focus();
                $("#reason_id_"+id).val('');
                reason_select = null;
            }
        }
    }

    function changeAmount(id, last_paid_amount){
        if(!last_paid_amount) {
            last_paid_amount = parseFloat(creditos[id].paid_amount);
        }
        creditos[id].paid_amount = a_paid[id].getNumber();
        if(creditos[id].paid_amount == 0){
            $("#reason_"+id).prop("disabled", false);

        }else{
            $("#reason_"+id).prop("disabled", true);
            $("#reason_"+id).val('');
            creditos[id].reason_id = null;
        }
        a_cobrado.set(a_cobrado.getNumber() - last_paid_amount + a_paid[id].getNumber());
        a_efectividad.set( parseFloat(a_cobrado.getNumber() * 100 / a_meta.getNumber()));
        a_cobrado2.set(a_cobrado.rawValue);
        a_efectividad2.set(a_efectividad.rawValue);
    }

    $(document).on('keyup', 'input', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            var name    = $(this).attr("name").split('_')[0];
            var i       = $(this).attr("name").split('_')[1];
            var id      = $(this).attr("id").split('_')[2];
            if(name == 'paid' && $("#reason_"+id).prop('disabled') == false) {
                $("#reason_"+id).focus();
                $("input[name='paid_"+i+"']")[0].style.removeProperty("font-weight");
            }else{
                if(parseFloat($("input[name='paid_"+i+"']").val().split('$')[1]) > 0){
                    $("input[name='paid_"+i+"']").css("font-weight","bold");
                }
                i++;
                $("input[name='paid_"+i+"']").focus();
            }
        }
    });

	$("#collectForm").submit(function(e){
        e.preventDefault();

        var fee_data = [];
        $.each(creditos, function(key, item){
            if(item != null){
                fee_data.push(item);
            }
        });

        $("#fee_data").html(JSON.stringify(fee_data));
        $('#methodsModal').modal('show');
    });

    function submitForm(){
        $("#collectForm").submit();
    }

    function saveConfirm(){
        $('#methodsModal').modal('hide');

        var form = $("#collectForm");
        var url  = form.attr('action');
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data, // serializes the form's elements.
            success: function(response){
                $.notify(
                    {
                        // options
                        icon: 'fas fa-exclamation-circle',
                        message: response.message
                    },{
                        // settings
                        type: "success",
                        showProgressbar: false,
                        mouse_over: 'pause',
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    }
                );
                location.reload();
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
            }
        });
    }

    function saveCancel(){
        $('#confirmModal').modal('hide');
    }

    $(".check").change(function() {
        if(this.checked) {
            $('.buttonBoolean .labor').css('visibility', 'hidden')
            $('.buttonBoolean .holidays').css('visibility', 'visible')
            holiday();
        } else {
            $('.buttonBoolean .labor').css('visibility', 'visible')
            $('.buttonBoolean .holidays').css('visibility', 'hidden')
            getData();
        }
    });

    function holiday(){
        creditos
            .filter(credito => credito)
            .forEach(credito => {
                a_paid[credito.credit_id].set(0);
                changeAmount(credito.credit_id)
                selectReason(credito.credit_id, true)
            })
    }

    function getData(){
    	var route_id = $("#route_id").val();
    	var date = $("#created_date").val();

        table.clear().draw();
        creditos = [];

    	if(route_id > 0 && date != ''){
            itemNo = 0;
            a_cobrado.set(0);
            a_meta.set(0);
            a_efectividad.set(0);
            a_cobrado2.set(0);
            a_meta2.set(0);
            a_efectividad2.set(0);

    		$.ajax({
	            type: "GET",
	            url: "{{route('credits.getCollect')}}",
	            data: {route_id : route_id , date : date}, // serializes the form's elements.
	            success: function(response){

	                $.each(response, function(i, credit){
                        itemNo++;

                        var next_number = 1;
                        if(typeof(credit.last_number_fee) != "undefined" && credit.last_number_fee !== null) {
                            next_number = credit.last_number_fee.number + 1;
                        }

                        table.row.add([
                            itemNo,
                            credit.id,
                            credit.name,
                            $("#created_date").val(),
                            next_number,
                            new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(credit.fee_amount),
                            '<input name="paid_'+i+'" id="paid_amount_'+credit.id+'" style="width:50%; display:inline;text-align:right" onchange="changeAmount('+credit.id+')" class="form-control enterSelect" type="text" >',
                            '<input name="reason_'+i+'" id="reason_'+credit.id+'" disabled="disabled" style="width:75%;display:inline" onchange="selectReason('+credit.id+')" class="form-control inputReason enterSelect" type="text"><input type="hidden" id="reason_id_'+credit.id+'" value="">',
                            '<a href="javascript:payCheckForm('+credit.id+');"><button class="btn btn-sm"><i class="fas fa-money-check-alt"></i></button> </a> ',
                            '<a href="javascript:mercadoPagoForm('+credit.id+');"><img src="https://www.mercadopago.com/org-img/Manual/ManualMP/imgs/isologoVertical.png" alt="Mercado Pago" height="30" width="30"></a> '
                        ]).draw( false );

                        a_paid[credit.id] = new AutoNumeric("#paid_amount_"+credit.id, {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
                        a_paid[credit.id].set(credit.fee_amount);

                        creditos[credit.id] = {
                            credit_id       : credit.id,
                            route_id        : credit.route_id,
                            reason_id       : null,
                            number          : next_number,
                            paid_date       : date,
                            payment_amount  : credit.fee_amount,
                            paid_amount     : credit.fee_amount
                        };

                        a_cobrado.set(a_cobrado.getNumber() + parseFloat(credit.fee_amount));
                        a_meta.set(a_meta.getNumber() + parseFloat(credit.fee_amount));
                        a_efectividad.set( parseFloat(a_cobrado.getNumber() * 100 / a_meta.getNumber()));
                        a_cobrado2.set(a_cobrado.rawValue);
                        a_meta2.set(a_meta.rawValue);
                        a_efectividad2.set(a_efectividad.rawValue);

	                });
	            },
	            error: function(response) {
	                if( response.status === 422 ) {
	                    var errors = $.parseJSON(response.responseText).errors;
	                }else{
	                    var errors=[response.message];
	                }
	                $.each(errors, function(key, value){
	                    $.notify(
	                        {
	                            // options
	                            icon: 'fas fa-exclamation-circle',
	                            message: value
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
	                });
	            }
	        });
    	}
    }

    function payCheckForm(credit_id){

        if(creditos[credit_id].paycheck){
            $("#paycheck_number").val(creditos[credit_id].paycheck.number);
            $("#paycheck_amount").val(creditos[credit_id].paycheck.amount);
            $("#paycheck_bank").val(creditos[credit_id].paycheck.bank);
            $("#paycheck_owner_name").val(creditos[credit_id].paycheck.owner_name);
            $("#paycheck_paymentdate").val(creditos[credit_id].paycheck.paymentdate);
        }else{
            $("#paycheck_number").val('');
            $("#paycheck_amount").val('');
            $("#paycheck_bank").val('');
            $("#paycheck_owner_name").val('');
            $("#paycheck_paymentdate").val('');
        }
        $("#paycheck_credit_id").val(credit_id);
        $("#paycheckModal").modal('show');
    }

    function mercadoPagoForm(credit_id){

        if(creditos[credit_id].mercadopago){
            $("#mercadopago_number").val(creditos[credit_id].mercadopago.number);
            $("#mercadopago_amount").val(creditos[credit_id].mercadopago.amount);
            $("#mercadopago_owner_name").val(creditos[credit_id].mercadopago.owner_name);
        }else{
            $("#mercadopago_number").val('');
            $("#mercadopago_amount").val('');
            $("#mercadopago_owner_name").val('');
        }
        $("#mercadopago_credit_id").val(credit_id);
        $("#mercadoPagoModal").modal('show');
    }

    function setPaycheckToFee(){
        var credit_id = $("#paycheck_credit_id").val();

        creditos[credit_id].paycheck = {
            number:     $("#paycheck_number").val(),
            amount:     parseFloat($("#paycheck_amount").val()),
            bank:       $("#paycheck_bank").val(),
            owner_name: $("#paycheck_owner_name").val(),
            paymentdate:$("#paycheck_paymentdate").val()
        };

        last_paid_amount = parseFloat(creditos[credit_id].paid_amount);
        creditos[credit_id].paid_amount = creditos[credit_id].paycheck.amount;

        a_paid[credit_id].set(creditos[credit_id].paycheck.amount);

        var amount = $('input[id="paid_amount_'+credit_id+'"]')

        amount.css({"background-color": "#ff3838", "color": "#FFFFFF", "font-size": "bold"});
        changeAmount(credit_id, last_paid_amount)
        $("#paycheckModal").modal('hide');
    }

    function setMercadoPagoToFee(){
        var credit_id = $("#mercadopago_credit_id").val();

        creditos[credit_id].mercadopago = {
            number:     $("#mercadopago_number").val(),
            amount:     parseFloat($("#mercadopago_amount").val()),
        };

        last_paid_amount = parseFloat(creditos[credit_id].paid_amount);
        creditos[credit_id].paid_amount = creditos[credit_id].mercadopago.amount;

        a_paid[credit_id].set(creditos[credit_id].mercadopago.amount);

        var amount = $('input[id="paid_amount_'+credit_id+'"]')

        amount.css({"background-color": "#009ee3", "color": "#FFFFFF", "font-size": "bold"});

        $("#mercadoPagoModal").modal('hide');
        changeAmount(credit_id, last_paid_amount)
    }

    $("#print").click(function(){
        var route_id = $("#route_id").val();
        var date = $("#created_date").val();
        if (route_id > 0){
            var url = "{{url( '/print/credit/collection/') }}";
            url = url + "?route_id=" + route_id + "&date=" + date;
            window.open(url, '_blank');
        }
    });


    $('input[name="groupOfDefaultRadios"]').click(function(){
        $('#payment_method_id').val(this.value);
    });

</script>
