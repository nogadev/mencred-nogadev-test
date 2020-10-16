<script type="text/javascript">
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

    $(document).ready(function(){

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

        $('#searchDate').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            language: "es",
            autoclose: true
        });

        $('#searchDate').datepicker('setDate', '0d');

        resetValues();
        setTables();
        setInit();

    });

    $(".btn-success").click(function(e){

        resetValues();
        setTables();

        let dateVal = $('#searchDate').val();
        if(dateVal == ''){
            return false;
        }

        let date = formatDate(dateVal);
        let url = "{{route('cash.date')}}";


        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            encode  : true,
            data: {'date': date},
            success: function(response){
                setInit();
                var movements = response.movements;
                var openCashRowAmount = 0;
                $.each(movements, function(i, movement) {

                    var description = '';
                    if(movement.movreasons.mov_type_id == 1){
                         // 8=>'APERTURA CAJA' 1=>'RENDICION COBRANZA' 2=>'CUOTA INICIAL'
                        if(movement.mov_reason_id===8||movement.mov_reason_id===1||movement.mov_reason_id===2){
                            description = movement.description;
                            if(movement.mov_reason_id===2){
                                if(description !== undefined && description !== null && description.length > 6){
                                    if(description.slice(0,5)==="CUOTA"){
                                        description = description.slice(6);
                                    }
                                }
                            }
                        }else{
                            description = movement.movreasons.description;
                        }
                        var mov_amount = movement.amount;
                        var type = movement.paymentmethods.name;

                        if(movement.movreasons.id == 8){ // apertura
                            description = description.substring(0, 13);
                            type = '';
                        }

                        var amountRow = tableIn.cell({row:0, column:2}).data();
                        if(type == ''){
                            openCashRowAmount = (openCashRowAmount + parseInt(mov_amount));
                        }

                        if((type != '') || ((type == '') && (amountRow == undefined)))  {
                            tableIn.row.add([
                                type,
                                description,
                                new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(mov_amount),
                                ''
                            ]).draw( false );
                        }
                        else{
                            tableIn.cell({row:0, column:2}).data(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(openCashRowAmount));
                        }

                        ingresos.set(parseFloat(ingresos.getNumber()) + parseFloat(movement.amount));
                        if(movement.movreasons.description == 'CUOTA INICIAL')
                            inicial.set(parseFloat(inicial.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name == 'EFECTIVO')
                            efectivo.set(parseFloat(efectivo.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name == 'CHEQUE')
                            cheques.set(parseFloat(cheques.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name == 'MERCADO PAGO')
                            mercadopago.set(parseFloat(mercadopago.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name == 'BANCO')
                            transferencias.set(parseFloat(transferencias.getNumber()) + parseFloat(movement.amount));

                        ins[movement.id] = movement;
                    }else{
                        data = [
                            movement.paymentmethods.name,
                            movement.movreasons.description,
                            new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(movement.amount),
                            ''
                        ];

                        tableOut.row.add(data).draw( false );

                        egresos.set(parseFloat(egresos.getNumber()) + parseFloat(movement.amount));
                        if(movement.paymentmethods.name == 'EFECTIVO')
                            efectivoOut.set(parseFloat(efectivoOut.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name ==  'CHEQUE')
                            chequesOut.set(parseFloat(chequesOut.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name ==  'MERCADO PAGO')
                            mercadopagoOut.set(parseFloat(mercadopagoOut.getNumber()) + parseFloat(movement.amount));

                        if(movement.paymentmethods.name  == 'BANCO')
                            transferenciasOut.set(parseFloat(transferenciasOut.getNumber()) + parseFloat(movement.amount));

                        outs[movement.id] = movement;
                    }

                });

                updTotals();
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
    });

    function formatDate(date) {
        var arrayDate = date.split('/');
        return arrayDate[2] + '-' + arrayDate[1] + '-' + arrayDate[0];
    }

    function setTables() {

        var tableInHTML = createTable();
        var tableOutHTML = createTable();


        tableInHTML.attr('id','tableMovementIn');
        tableOutHTML.attr('id','tableMovementOut');

        $('#card-ingresos').append(tableInHTML);
        $('#card-egresos').append(tableOutHTML);

        tableIn = $('#tableMovementIn').DataTable({
            columnDefs: [{
                className: "dt-right", "targets": [2]
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
    }

    function createTable() {
        var tableInHTML = $('<table/>');
        var tableTheadHTML = $('<thead/>');
        var tableTbodyHTML = $('<tbody/>');
        var tableTrHTML = $('<tr/>');
        var tableThTipoHTML = $('<th/>');
        var tableThDetalleHTML = $('<th/>');
        var tableThMontoHTML = $('<th/>');

        tableThTipoHTML.css('with','30%');
        tableThTipoHTML.html('TIPO');
        tableThDetalleHTML.html('DETALLE');
        tableThMontoHTML.css('with','20%');
        tableThMontoHTML.html('MONTO');

        tableTrHTML.append(tableThTipoHTML);
        tableTrHTML.append(tableThDetalleHTML);
        tableTrHTML.append(tableThMontoHTML);

        tableTheadHTML.append(tableTrHTML);

        tableInHTML.addClass('compact hover nowrap row-border fixed');
        tableInHTML.css('table-layout','fixed');

        tableInHTML.append(tableTheadHTML);
        tableInHTML.append(tableTbodyHTML);
        return tableInHTML;
    }

    function resetValues() {
        ingresos = currency_format("#ingresos");
        egresos = currency_format("#egresos");
        inicial = currency_format("#inicial");
        efectivo = currency_format("#efectivo");
        cheques = currency_format("#cheques");
        transferencias = currency_format("#transferencias");
        mercadopago = currency_format("#mercadopago");
        ingresos.set(0);
        egresos.set(0);
        inicial.set(0);
        efectivo.set(0);
        cheques.set(0);
        transferencias.set(0);
        mercadopago.set(0);

        $('#card-ingresos').html('');
        $('#card-egresos').html('');

    }

    function setInit() {
        tableIn.clear().draw();
        tableOut.clear().draw();

        ins=[];
        outs=[];
        availableCashing = 0;
        availableBank = 0;
        availableMercadopagos = 0;
        availableChecks = 0;

        ingresos.set(0);
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
    }

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
        

        $('#div-cashing-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableCashingTmp.toFixed(2)));
        $('#div-banks-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableBankTmp.toFixed(2)));
        $('#div-checks-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableChecks.toFixed(2)));
        $('#div-mercadopago-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(availableMercadopagos.toFixed(2)));

        $('#div-cash-in-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(totalCashIn.toFixed(2)));
        $('#div-cash-out-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(totalCashOut.toFixed(2)));
        $('#div-cash-total').html(new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format(totalCash.toFixed(2)));
    }

    function currency_format($id_currency){
        return new AutoNumeric($id_currency, {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});;
    }

</script>
