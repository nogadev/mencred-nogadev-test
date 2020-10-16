<script type="text/javascript">

    var reason = [];
    var payments = [];
    var paychecks= [];
    var mercadopagos=[];
    var banks=[];
    var amount;
    var paycheck_amount;
    var tableIn;
    var tableOut;
    var ingresos=0;
    var egresos=0;
    var inicial=0;
    var efectivo=0;
    var efectivoOut=0;
    var cheques=0;
    var chequesOut=0;
    var mercadopago=0;
    var mercadopagoOut=0;
    var transferencias=0;
    var transferenciasOut=0;
    var ins=[];
    var outs=[];
    var index = false;
    var availableCashing = 0;
    var availableBank = 0;
    var availableMercadopagos = 0;
    var availableChecks = 0;

    function updTotals(){
        let totalCashIn = 0;
        let totalCashOut = 0;
        let totalCash = 0;
        let availableCashingTmp = 0;
        let availableBankTmp = 0;
        let availableMercadopagosTmp = 0;
        let availableChecksTmp = 0;

        $.each(this.ins, function (i, cashIn) {
            if(cashIn){
                totalCashIn += parseFloat(cashIn.amount);
                totalCash += parseFloat(cashIn.amount);

                if(cashIn.paymentmethods.name == 'EFECTIVO' || cashIn.paymentmethods.name == 'CUOTA INICIAL'){
                    availableCashingTmp += parseFloat(cashIn.amount);
                }

                if(cashIn.paymentmethods.name == 'BANCO'){
                    availableBankTmp += parseFloat(cashIn.amount);
                }

                if(cashIn.paymentmethods.name == 'MERCADO PAGO'){
                    availableMercadopagosTmp += parseFloat(cashIn.amount);
                }

                if(cashIn.paymentmethods.name == 'CHEQUE'){
                    availableChecksTmp += parseFloat(cashIn.amount);
                }
            }
        });

        $.each(this.outs, function (i, cashOut) {
            if(cashOut){
                totalCashOut += parseFloat(cashOut.amount);
                totalCash -= parseFloat(cashOut.amount);

                if(cashOut.paymentmethods.name == 'EFECTIVO' || cashOut.paymentmethods.name == 'CUOTA INICIAL'){
                    availableCashingTmp -= parseFloat(cashOut.amount);
                }

                if(cashOut.paymentmethods.name == 'BANCO'){
                    availableBankTmp -= parseFloat(cashOut.amount);
                }

                if(cashOut.paymentmethods.name == 'MERCADO PAGO'){
                    availableMercadopagosTmp -= parseFloat(cashOut.amount);
                }

                if(cashOut.paymentmethods.name == 'CHEQUE'){
                    availableChecksTmp -= parseFloat(cashOut.amount);
                }
            }
        });

        availableMercadopagos = availableMercadopagosTmp;
        availableChecks = availableChecksTmp;
        availableCashing = availableCashingTmp;
        availableBank = availableBankTmp;

        $('#div-cashing-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableCashingTmp.toFixed(2)));
        $('#div-banks-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableBankTmp.toFixed(2)));
        $('#div-checks-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableChecks.toFixed(2)));
        $('#div-mercadopago-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableMercadopagos.toFixed(2)));

        $('#div-cash-in-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(totalCashIn.toFixed(2)));
        $('#div-cash-out-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(totalCashOut.toFixed(2)));
        $('#div-cash-total').val(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(totalCash.toFixed(2)));
    }


    $(document).ready(function() {

        @if(isset($isPrevCash) AND $isPrevCash)
        $('#modal-title').html('CAJA ANTERIOR ABIERTA');
        $('#modal-text').html('DEBE CERRAR LA CAJA ANTERIOR PARA PODER CONTINUAR');
        $('#modal-action-btn').html('CERRAR CAJA');
        $('#modal-action-btn').className = 'btn btn-danger';
        $("#modal-action-btn").attr("href", '{{ route("cash.close") }}');
        $('#cashModal').modal('show');
        @endif

        var baseOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="movementtype_id"]').selectpicker(baseOptions);
        $('select[name="mov_reason_id"]').selectpicker(baseOptions);
        $('select[name="payment_method_id"]').selectpicker(baseOptions);
        $('select[name="paycheck_bank"]').selectpicker(baseOptions);

        $('#paycheck_paymentdate').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            language: "es",
            autoclose: true
        });

        $('#paycheck_paymentdate').datepicker('setDate', '0d');

        $('.btn-cancel').click(function (e) {
            e.preventDefault();
           clearForm();
        });

        @foreach ($movementtypes as $movementtype)
            reason[{{ $movementtype->id }}] = @json($movementtype->availablesMovreasons);
        @endforeach

        @foreach ($banks as $bank)
            banks[{{ $bank->id }}] = @json($bank->name);
        @endforeach

            payments = @json($payment_methods);

        var pagado=0;

        $('#egresos').change(function () {
            $('div-cash-out-total span').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(egresos.val()));
        });

        @foreach ($paychecks as $paycheck)
            paychecks[{{$paycheck->id}}] = @json($paycheck);

            var line = "<tr id='check" + {{$paycheck->id}} +
                "'><td>{{$paycheck->number}}</td>"+
                "<td>{{$paycheck->payment_date->format('d/m/Y')}}</td>"+
                "<td>{{$paycheck->bank->name}}</td>"+
                "<td>{{$paycheck->owner_name}}</td>"+
                "<td>${{$paycheck->amount}}</td>"+
                "<td><button type='button' id='{{$paycheck->id}}' class='usarCheque btn btn-warning btn-sm'>Usar</button></td></tr>";
            $("#tablePaycheck tbody").append(line);
        @endforeach

        amount = currency_format("#amount");
        paycheck_amount = currency_format("#paycheck_amount");
        ingresos = currency_format("#ingresos");
        egresos = currency_format("#egresos");
        inicial = currency_format("#inicial");
        efectivo = currency_format("#efectivo");
        efectivoOut = currency_format("#efectivo_out");
    	cheques = currency_format("#cheques");
    	chequesOut = currency_format("#cheques_out");
    	transferencias = currency_format("#transferencias");
    	transferenciasOut = currency_format("#transferencias_out");
    	mercadopago = currency_format("#mercadopago");
    	mercadopagoOut = currency_format("#mercadopago_out");
    	ingresos.set(0);
    	amount.set(0);
        paycheck_amount.set(0);
    	egresos.set(0);
    	inicial.set(0);
    	efectivo.set(0);
    	efectivoOut.set(0);
    	cheques.set(0);
    	chequesOut.set(0);
        transferencias.set(0);
        transferenciasOut.set(0);
        mercadopago.set(0);
        mercadopagoOut.set(0);

        tableIn = $('#tableMovementIn').DataTable({
            columnDefs: [{
                className: "dt-right", "targets": [2],
                className: "dt-right", "targets": [3]
            }],
            "ordering": true,
            "iDisplayLength": 25,
            "order": [[ 0, "desc" ]],
            "select": true
        });
        tableOut = $('#tableMovementOut').DataTable({
            columnDefs: [{
                className: "dt-right", "targets": [2]
            }],
            "ordering": true,
            "iDisplayLength": 25,
            "order": [[ 0, "desc" ]],
            "select": true
        });

        var openCashRowAmount = 0;

        @foreach ($cash->movements as $movement)

            var botonesIn = '';
            var botonesOut = '';
            var description = '';

        @if($movement->method == 'MANUAL')
                botonesIn =  '<button id="{{$movement->id}}" class="eliminarIn btn btn-sm"><i class="fas fa-times"></i></button>';
                botonesOut = '<button id="{{$movement->id}}" class="eliminarOut btn btn-sm"><i class="fas fa-times"></i></button>';
            @endif


            @if($movement->movreasons->mov_type_id == 1) // ingreso
            // 8=>'APERTURA CAJA' 1=>'RENDICION COBRANZA' 2=>'CUOTA INICIAL'
                    if('{{$movement->mov_reason_id}}'==='8'||'{{$movement->mov_reason_id}}'==='1'||'{{$movement->mov_reason_id}}'==='2'){
                        description = '{{$movement->description}}';
                        if('{{$movement->mov_reason_id}}' ==='2'){
                            if(description !== undefined && description !== null && description.length > 6){
                                if(description.slice(0,5)==="CUOTA"){    
                                    description = description.slice(6);
                                }
                            }
                        }
                    }else{
                        description = '{{$movement->movreasons->description}}';
                    }
                    var mov_amount = '{{$movement->amount}}';
                    var type = '{{$movement->paymentmethods->name}}';


                    @if($movement->movreasons->id == 8) // apertura
                        description = description.substring( 0, 13);
                        type = '';
                    @endif

                var amountRow = tableIn.cell({row:0, column:2}).data();
                if(type == ''){
                    openCashRowAmount = (openCashRowAmount + parseInt(mov_amount));
                }

                if((type != '') || ((type == '') && (amountRow == undefined)))  {
                        tableIn.row.add([
                            type,
                            description,
                            new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(mov_amount),
                            botonesIn
                        ]).draw( false );
                }
                else{
                    tableIn.cell({row:0, column:2}).data(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(openCashRowAmount));
                }


                    ingresos.set(parseFloat(ingresos.getNumber()) + parseFloat({{$movement->amount}}));
                @if($movement->movreasons->description == 'CUOTA INICIAL')
                    inicial.set(parseFloat(inicial.getNumber()) + parseFloat({{$movement->amount}}));
                @endif
                @if($movement->paymentmethods->name == 'EFECTIVO')
                    efectivo.set(parseFloat(efectivo.getNumber()) + parseFloat({{$movement->amount}}));
                @endif
                @if($movement->paymentmethods->name == 'CHEQUE')
                    cheques.set(parseFloat(cheques.getNumber()) + parseFloat({{$movement->amount}}));
                @endif
                @if($movement->paymentmethods->name == 'MERCADO PAGO')
                    mercadopago.set(parseFloat(mercadopago.getNumber()) + parseFloat({{$movement->amount}}));
                @endif
                @if($movement->paymentmethods->name == 'BANCO')
                transferencias.set(parseFloat(transferencias.getNumber()) + parseFloat({{$movement->amount}}));
                 @endif

            ins[{{$movement->id}}] = @json($movement);

            @else
                tableOut.row.add([
                    '{{$movement->paymentmethods->name}}',
                    '{{$movement->movreasons->description}}',
                    new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format('{{$movement->amount}}'),
                    botonesOut
                ]).draw( false );

                egresos.set(parseFloat(egresos.getNumber()) + parseFloat({{$movement->amount}}));
            @if($movement->paymentmethods->name == 'EFECTIVO')
            efectivoOut.set(parseFloat(efectivoOut.getNumber()) + parseFloat({{$movement->amount}}));
            @endif
            @if($movement->paymentmethods->name == 'CHEQUE')
            chequesOut.set(parseFloat(chequesOut.getNumber()) + parseFloat({{$movement->amount}}));
            @endif
            @if($movement->paymentmethods->name == 'MERCADO PAGO')
            mercadopagoOut.set(parseFloat(mercadopagoOut.getNumber()) + parseFloat({{$movement->amount}}));
            @endif
            @if($movement->paymentmethods->name == 'BANCO')
            transferenciasOut.set(parseFloat(transferenciasOut.getNumber()) + parseFloat({{$movement->amount}}));
            @endif
                outs[{{$movement->id}}] = @json($movement);
            @endif

        @endforeach

        updTotals();

        $("#usarMercadoPago").click(function(e){
            if(checkAmountMP() === true){
                var mp_payment_amount = $('#mp_payment_amount').val();
                amount.set(parseFloat(mp_payment_amount));
                $("#description").val($('#mp_description').val());
                var isValid = validateEmptyFields();

                if(isValid == true) {
                    $("#mercadoPagoModal").modal('hide');
                    $("#movementForm").submit();
                }
            }
            else{
                $.notify({
                    icon: 'fas fa-exclamation-circle',
                    message: "EL MONTO A PAGAR SUPERA EL MONTO DISPONIBLE"
                }, {
                    type: "danger",
                    showProgressbar: false,
                    mouse_over: 'pause',
                    z_index: 2000,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated bounceOut'
                    }
                });
            }
        });


        $(document).on('click', '.usarCheque', function(){
            id = $(this).attr('id');

            $('#getOutBtn').attr('onclick', 'getOutCheck('+id+')');

            $('#detailModal').modal('show');
        });


        $(document).on('click','.editarIn',function(e){
            editRow($(this), ins);
        });

        $(document).on('click','.editarOut',function(e){
            editRow($(this), outs);

        });

        function editRow(row, array) {
            var id      = row.attr('id');

            $("#movementtype_id").val(array[id].movreasons.mov_type_id).selectpicker('refresh');
            $("#movementtype_id").trigger("change");

            $("#mov_reason_id").val(array[id].mov_reason_id).selectpicker('refresh');
            $("#mov_reason_id").trigger("change");

            $("#payment_method_id").val(array[id].payment_method_id).selectpicker('refresh');
            $("#description").val(array[id].description);
            $("#movement_id").val(id);
            amount.set(array[id].amount);

            $("#paymentDiv").hide('fast');

            index   = row.closest('tr').index();
        }

        $(document).on('click','.eliminarIn',function(e){

            var row     = $(this).closest('tr');
            var id      = $(this).attr('id');
            var motivo  = tableIn.row(row).data()[0];
            var monto   = parseFloat(tableIn.row(row).data()[2].replace('$',''));
            let check   = ins[id].checks;

            if(check != null){
                //Cheque entregado
                if(check.status_id == 10){
                    $.notify({
                            // options
                            icon: 'fas fa-exclamation-circle',
                            message: 'No se puede eliminar un cheque egresado'
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
                }
                else{
                    destroyCheck(check.id);
                }
            }


            $.ajax({
                type    : 'POST',
                url     : "{{ route('cashes.destroyMovement') }}",
                data    : {
                    "id"    : id,
                    "_token": $("meta[name='csrf-token']").attr("content")
                },
                dataType: 'json',
                encode  : true,
                success: function(response){

                    $.notify(
                        {
                            // options
                            icon: 'fas fa-exclamation-circle',
                            message: 'Registro eliminado exitoso'
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

                    ingresos.set(parseFloat(ingresos.getNumber()) - monto);
                    if(motivo == 'EFECTIVO'){
                        efectivo.set(parseFloat(efectivo.getNumber()) - monto);
                    }
                    if(motivo == 'CHEQUE'){
                        cheques.set(parseFloat(cheques.getNumber()) - monto);
                    }
                    if(motivo == 'BANCO'){
                        transferencias.set(parseFloat(transferencias.getNumber()) - monto);
                    }
                    if(motivo == 'MERCADO PAGO'){
                        mercadopago.set(parseFloat(mercadopago.getNumber()) - monto);
                    }

                    tableIn.row(row).remove().draw();

                    updTotals();
                },
                error: function(response) {
                    if( response.status === 422 ) {
                        var errors = $.parseJSON(response.responseText).errors;
                    }else{
                        var errors=[response.message];
                    }
                    $.each(errors, function(key, value){
                        $.notify({
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

            ins.splice(id,1);

            updTotals();

        });

        $(document).on('click','.eliminarOut',function(e){

            var row     = $(this).closest('tr');
            var id      = $(this).attr('id');
            var motivo  = tableOut.row(row).data()[0];
            var monto   = parseFloat(tableOut.row(row).data()[2].replace('$',''));
            let check   = outs[id].checks;

            if(check != null){
                check.status_id = 9;
                updateCheck(check);
                updateChecksTable(check)
            }

            $.ajax({
                type    : 'POST',
                url     : "{{ route('cashes.destroyMovement') }}",
                data    : {
                    "id"    : id,
                    "_token": $("meta[name='csrf-token']").attr("content"),
                },
                dataType: 'json',
                encode  : true,
                success: function(response){

                    $.notify(
                        {
                            // options
                            icon: 'fas fa-exclamation-circle',
                            message: 'Registro eliminado exitoso'
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

                    egresos.set(parseFloat(egresos.getNumber()) - monto);

                    if(motivo == 'EFECTIVO'){
                        efectivoOut.set(parseFloat(efectivoOut.getNumber()) - monto);
                    }
                    if(motivo == 'CHEQUE'){
                        chequesOut.set(parseFloat(chequesOut.getNumber()) - monto);
                    }
                    if(motivo == 'BANCO'){
                        transferenciasOut.set(parseFloat(transferenciasOut.getNumber()) - monto);
                    }
                    if(motivo == 'MERCADO PAGO'){
                        mercadopagoOut.set(parseFloat(mercadopagoOut.getNumber()) - monto);
                    }

                    tableOut.row(row).remove().draw();

                },
                error: function(response) {
                    if( response.status === 422 ) {
                        var errors = $.parseJSON(response.responseText).errors;
                    }else{
                        var errors=[response.message];
                    }
                    $.each(errors, function(key, value){
                        $.notify({
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

            outs.splice(id,1);
            updTotals();

        });


        $("#movementtype_id").change(function(){
            $("#mov_reason_id").empty();

            var mov_type_id = $(this).val();

            $.each(reason[mov_type_id], function(key, movementreason){
                $('select[name="mov_reason_id"]').append('<option value="' + movementreason.id + '">' + movementreason.description + '</option>');
            });

            $("#mov_reason_id").selectpicker("refresh");
        });

        $("#mov_reason_id").change(function(){

            $('select[name="payment_method_id"]').empty();

            $.each(payments, function(key, payment) {
                $('select[name="payment_method_id"]').append('<option value="' + payment.id + '">' + payment.name + '</option>');
            });

            $('#payment_method_id').val('default');
            $("#payment_method_id").selectpicker("refresh");
        });

        $("#payment_method_id").change(function(){

            if($('#movementtype_id').val() == 2){
                //hard para cuando es cheque
                if($(this).val() == 2){
                    $("#paychecksModal").modal('show');
                }
                //hard para cuando es mercado pago
                if($(this).val() == 3){
                    $("#mercadoPagoModal").modal('show');
                    var mpAvailable = getAmountAvailableMP();
                }
            }
            else{
                if($(this).val() == 2){
                    $("#paycheckModal").modal('show');
                }
            }
        });

        $("#movementForm").submit(function(e){

            e.preventDefault();

            let isValid = validateEmptyFields();

            if(isValid == true){
                isValid = validateLimitAmounts();
            }

            if(isValid == true){
                var form = $("#movementForm");
                var url  = form.attr('action');
                var data = formatData(form.serialize());
                var check = null;
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data, // serializes the form's elements.
                    success: function(response){
                        $.notify(
                            {
                                // options
                                icon: 'fas fa-exclamation-circle',
                                message: 'Registro exitoso'
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

                        if(response.checks != null){
                            check = response.checks;
                        }

                        if(response.movreasons.mov_type_id == 1){
                            data = [
                                response.paymentmethods.name,
                                response.movreasons.description,
                                new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(amount.getNumber()),
                                '<button id="'+response.id+'" class="eliminarIn btn btn-sm"><i class="fas fa-times"></i></button>'
                            ];
                            if(index !== false){

                                //borro los importes anteriores
                                old_data = tableIn.row(index).data();
                                ingresos.set(parseFloat(ingresos.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                if(old_data[0] == 'EFECTIVO'){
                                    efectivo.set(parseFloat(efectivo.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }
                                if(old_data[0] == 'CHEQUE'){
                                    cheques.set(parseFloat(cheques.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }
                                if(old_data[0] == 'MERCADO PAGO'){
                                    mercadopago.set(parseFloat(mercadopago.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }
                                if(old_data[0] == 'BANCO'){
                                    transferencias.set(parseFloat(transferencias.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }

                                tableIn.row(index).data(data).draw( false );
                            }else{
                                tableIn.row.add(data).draw( false );
                            }

                            ingresos.set(parseFloat(ingresos.getNumber()) + parseFloat(response.amount));
                            if(response.movreasons.description == 'CUOTA INICIAL')
                                inicial.set(parseFloat(inicial.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name == 'EFECTIVO')
                                efectivo.set(parseFloat(efectivo.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name == 'CHEQUE')
                                cheques.set(parseFloat(cheques.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name == 'MERCADO PAGO')
                                mercadopago.set(parseFloat(mercadopago.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name == 'BANCO')
                                transferencias.set(parseFloat(transferencias.getNumber()) + parseFloat(response.amount));

                            ins[response.id] = response;
                            if(check !== null){
                                paychecks[check.id] = check;
                                updateChecksTable(check);
                            }

                        }else{

                            //actualizo el cheque en la tabla ingresos
                            if(check !== null){

                                $.each(ins, function (i, cashIn) {
                                    if(ins[i] && cashIn.checks){
                                        if(cashIn.checks.id == check.id){
                                            ins[i].checks = check; //actualizo el estado del cheque ingresado en el array de ingresos
                                        }
                                    }

                                });
                            }

                            data = [
                                response.paymentmethods.name,
                                response.movreasons.description,
                                new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(amount.getNumber()),
                                '<button id="'+response.id+'" class="eliminarOut btn btn-sm"><i class="fas fa-times"></i></button>'
                            ];
                            if(index !== false){
                                old_data = tableIn.row(index).data();
                                egresos.set(parseFloat(egresos.getNumber()) - parseFloat(old_data[1].replace('$','')));

                                if(old_data[0] == 'EFECTIVO'){
                                    efectivoOut.set(parseFloat(efectivoOut.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }
                                if(old_data[0] == 'CHEQUE'){
                                    chequesOut.set(parseFloat(chequesOut.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }
                                if(old_data[0] == 'MERCADO PAGO'){
                                    mercadopagoOut.set(parseFloat(mercadopagoOut.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }
                                if(old_data[0] == 'BANCO'){
                                    transferenciasOut.set(parseFloat(transferenciasOut.getNumber()) - parseFloat(old_data[2].replace('$','')));
                                }

                                tableOut.row(index).data(data).draw( false );
                            }else{
                                tableOut.row.add(data).draw( false );
                            }
                            egresos.set(parseFloat(egresos.getNumber()) + parseFloat(amount.getNumber()));
                            if(response.paymentmethods.name == 'EFECTIVO')
                                efectivoOut.set(parseFloat(efectivoOut.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name ==  'CHEQUE')
                                chequesOut.set(parseFloat(chequesOut.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name ==  'MERCADO PAGO')
                                mercadopagoOut.set(parseFloat(mercadopagoOut.getNumber()) + parseFloat(response.amount));

                            if(response.paymentmethods.name  == 'BANCO')
                                transferenciasOut.set(parseFloat(transferenciasOut.getNumber()) + parseFloat(response.amount));

                            outs[response.id] = response;
                        }

                        updTotals();
                        clearForm();

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
        });

        $("#closeCashBtn").click(function() {
            $('#closeCashModal').modal('show');
        });

        $(".close").click(function(e){
            e.preventDefault();
            clearForm();
        });

    });

    function checkAmountMP(){
        var availableMP = parseInt($('#mp_balance_available').val());
        var amountMP = parseInt($('#mp_payment_amount').val());

        return availableMP >= amountMP;
    }
    function getAmountAvailableMP() {
        $.ajax({
            type    : 'GET',
            url     : "{{ route('cash.mp.available') }}",
            dataType: 'json',
            encode  : true,
            success: function(response){
                $('#mp_balance_available').val(response);
            }
        });
    }

    function closeCashCancel() {
        $('#closeCashModal').modal('hide');
    }

    function clearForm(){
        amount.set(0);
        paycheck_amount.set(0);
        index = false;

        if(!$("#paymentDiv").is(':visible')){
            $("#paymentDiv").show('fast');
        }

        $("#movementtype_id").val('default').selectpicker('refresh');

        $("#mov_reason_id").empty().selectpicker('refresh');

        $("#payment_method_id").empty().selectpicker('refresh');

        $("#paycheck_bank").empty().selectpicker('refresh');

        $("#description").val('');
        $("#payment_detail_id").val('');
        $("#payment_method_id").val('');
        $("#mov_reason_id").val('');
        $("#mp_description").val('');
        $("#mp_payment_amount").val('');

        $("#paycheck_number").val('');
        $("#paycheck_paymentdate").val('');
        $("#paycheck_owner_name").val('');
        $("#description_check").val('');
        $('#description_check_box').val('');

        $("#movement_id").val('');

        $('#reference').remove();

    }

    function validateEmptyFields() {
        var validate = true;
        if($('#mp_description').is(':visible')){
            if($('#mp_description').val().length === 0){
                $('#mp_description').focus();
                validate = false;
            }
        }else
        if($('#paycheck_number').is(':visible')){
            if(!$('#paycheck_bank').val().length > 1){
                $('#paycheck_bank').focus();
                validate = false;
            }
            if(!$('#paycheck_number').val().length === 0){
                $('#paycheck_number').focus();
                validate = false;
            }
            if(!$('#paycheck_amount').val().length === 0){
                $('#paycheck_amount').focus();
                validate = false;
            }
            if(!$('#paycheck_paymentdate').val().length === 0){
                $('#paycheck_paymentdate').focus();
                validate = false;
            }
            if(!$('#paycheck_owner_name').val().length === 0){
                $('#paycheck_owner_name').focus();
                validate = false;
            }
            if(!$('#description_check').val().length === 0){
                $('#description_check').focus();
                validate = false;
            }
        }
        else
            if ($('#description_check_box').is(':visible')){
                if(!$('#description_check_box').val().length === 0){
                    $('#description_check_box').focus();
                    validate = false;
                }
            }
        else
        if($('#description').val().length === 0){
            $('#description').focus();
            validate = false;
        }

        $('#movementForm select').each(function (i) {

            if(!$(this).val().length){
                $(this).focus();
                validate = false;
            }
        });

        if(!validate){
            $.notify({
                icon: 'fas fa-exclamation-circle',
                message: "Complete todos los campos requeridos"
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
        return validate;
    }

    function validateLimitAmounts() {
        let validate = true;
        let payment = $("#payment_method_id").find(":selected").text();
        let movement =  $("#movementtype_id").find(":selected").text();
        let available = 0;

        if(movement == 'EGRESO' && (payment == 'EFECTIVO' || payment == 'BANCO')){
            let amount = parseFloat($("#amount").val().replace('$',''));

            if(payment == 'EFECTIVO'){
                available = availableCashing;
            }
            else{
                available = availableBank;
            }

            if((available - amount) < 0) {
                validate = false;
            }


            if(!validate){
                $.notify({
                    icon: 'fas fa-exclamation-circle',
                    message: "EGRESO EN " + payment + " NO PUEDE SER MAYOR A " + new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(available)
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

        return validate;
    }

    function setPaycheck() {

        let isValid = validateEmptyFields();

        if(isValid == true){
            isValid = validateLimitAmounts();
        }

        if(isValid == true){

            let date = formatDate($('#paycheck_paymentdate').val());

            $.ajax({
                type: "POST",
                url: "{{route('payment.set.details')}}",
                encode  : true,
                data: {
                    "amount" : $('#paycheck_amount').val(),
                    "payment_date" : date ,
                    "number" : $('#paycheck_number').val() ,
                    "payment_method_id" : $('#payment_method_id').val() ,
                    "bank_id" : $('#paycheck_bank').val() ,
                    "owner_name" : $('#paycheck_owner_name').val() ,
                    "_token": $("meta[name='csrf-token']").attr("content")
                },
                success: function(response){
                    let descriptionCheck = $('#description_check').val();
                    $('#description').val(descriptionCheck);
                    amount.set(paycheck_amount.getNumber());
                    $('#paycheckModal').modal('hide');
                    let reference = $('<input>').attr({type: 'hidden', id: 'reference', name: 'reference', value: response.id});
                    $('#movementForm').append(reference);
                    $('#movementForm').submit();
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

    }

    function formatDate(date) {
        var arrayDate = date.split('/');
        return arrayDate[2] + '-' + arrayDate[1] + '-' + arrayDate[0];
    }

    function getOutCheck(id) {

        let isValid = validateEmptyFields();

        if(isValid == true){
            isValid = validateLimitAmounts();
        }

        if(isValid == true){
            amount.set(parseFloat(paychecks[id].amount));
            var movementform = $('#movementForm');
            var payment_detail_id = $('<input>', {
                type: 'hidden',
                id: 'payment_detail_id',
                name: 'payment_detail_id',
                value: id
            });
            movementform.append(payment_detail_id);
            let description = $('#description_check_box').val();
            $("#description").val(description);
            let reference = $('<input>').attr({type: 'hidden', id: 'reference', name: 'reference', value: id});
            $('#movementForm').append(reference);

            $(this).closest("tr").remove();
            $("#paychecksModal").modal('hide');
            movementform.submit();
            updateChecksTable(paychecks[id]);
            $('#detailModal').modal('hide');
        }
    }

    function destroyCheck(id) {
        $.ajax({
            type    : 'POST',
            url     : "{{ route('payment.destroy') }}",
            data    : {
                "id"    : id,
                "_token": $("meta[name='csrf-token']").attr("content")
            },
            dataType: 'json',
            encode  : true,
            success: function(response){
                updateChecksTable(paychecks[id]);
                paychecks.splice(id,1);
                if(response.status == 1){
                    $.notify(
                        {
                            // options
                            icon: 'fas fa-exclamation-circle',
                            message: 'Cheque eliminado con exito'
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
                }
            },
            error: function(response) {
                if( response.status === 422 ) {
                    var errors = $.parseJSON(response.responseText).errors;
                }else{
                    var errors=[response.message];
                }
                $.each(errors, function(key, value){
                    $.notify({
                            // options
                            icon: 'fas fa-exclamation-circle',
                            message: 'Problema al eliminar cheque'
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

    function updateCheck(check) {

        $.ajax({
            type    : 'POST',
            url     : "{{ route('payment.update.check') }}",
            data    : {
                "check"    : check,
                "_token": $("meta[name='csrf-token']").attr("content")
            },
            encode  : true
        });

        $.ajax({
            type    : 'GET',
            url     : "{{ route('cash.check') }}",
            data    : {
                "check_id"    : check.id,
                "_token": $("meta[name='csrf-token']").attr("content")
            },
            encode  : true,
            success: function(response){
                $.each(response, function( index, value ) {
                    if(typeof ins[value.id] !== "undefined"){
                        ins[value.id].checks = value.checks;
                    }
                });
            },
            error: function(response) {

            }

        });
    }

    function updateChecksTable(check) {
        if($('#check'+check.id).length){
            $('#check'+check.id).remove();
        }
        else{
            let rowCheck = $('<tr>');
            rowCheck.attr('id', 'check' + check.id);
            let numberCell = $('<td>').html(check.number);
            let formatedDate = check.payment_date.split('-');
            let dateCell = $('<td>').html(formatedDate[2].replace(' 00:00:00','') + '/' + formatedDate[1] + '/' + formatedDate[0]);
            let bankCell = $('<td>').html(banks[check.bank_id]);
            let ownCell = $('<td>').html(check.owner_name);
            let amountCell = $('<td>').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(check.amount));
            let actionCell = $('<td>');
            let button = $('<button>');
            button.attr('type', 'button');
            button.attr('id', check.id);
            button.addClass('usarCheque btn btn-warning btn-sm');
            button.html('Usar');
            actionCell.append(button);
            rowCheck.append(numberCell);
            rowCheck.append(dateCell);
            rowCheck.append(bankCell);
            rowCheck.append(ownCell);
            rowCheck.append(amountCell);
            rowCheck.append(actionCell);
            $('#tablePaycheck').append(rowCheck);
        }
    }

    function formatData(dataForm){
        let data = dataForm;
        let amountHaveCurrencySymbol = data.search("%24");
        let amountHaveComa = data.search("%2C");

        if( (amountHaveCurrencySymbol > -1) && (amountHaveComa > -1)){
            data = data.replace('%24','');
            data = data.replace('.','');
            data = data.replace('%2C','.');
        }
        return data;
    }

    function currency_format($id_currency){
        return new AutoNumeric($id_currency, {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});;
    }
    
</script>
