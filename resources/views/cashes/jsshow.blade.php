<script type="text/javascript">

    var reason = [];
    var tableIn; 
    var tableOut;
    var i=0;
    var e=0;
    var ingresos=0;
    var egresos=0;
    var inicial=0;
    var recorridos=0;
    var balance=0;


    $(document).ready(function() {


        ingresos = currency_format("#ingresos");
        egresos = currency_format("#egresos");
        balance = currency_format("#balance");
    	inicial = currency_format("#inicial");
        efectivo = currency_format("#efectivo");
        cheques = currency_format("#cheques");
    	ingresos.set(0);
    	egresos.set(0);
    	balance.set(0);
    	inicial.set(0);
    	efectivo.set(0);
        cheques.set(0);

        tableIn = $('#tableMovementIn').DataTable({
            columnDefs: [{ 
                className: "dt-right", "targets": [2] 
            }],
            "ordering": true,
            "iDisplayLength": 25,
            "order": [[ 0, "desc" ]]
        });
        tableOut = $('#tableMovementOut').DataTable({
            columnDefs: [{ 
                className: "dt-right", "targets": [1] 
            }],
            "ordering": true,
            "iDisplayLength": 25,
            "order": [[ 0, "desc" ]]
        });

        @foreach ($cash->movements as $movement)
            @if($movement->movementtype_id == 1)
                tableIn.row.add([
                    '{{$movement->movementreason->description}}',
                    '{{$movement->description}}',
                    new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format('{{$movement->amount}}')
                ]).draw( false );

                ingresos.set(parseFloat(ingresos.getNumber()) + parseFloat({{$movement->amount}}));
                @if($movement->method == 'CUOTA INICIAL')
                    inicial.set(parseFloat(inicial.getNumber()) + parseFloat({{$movement->amount}}));
                @endif 
                @if($movement->method == 'RENDICION COBRADOR EFECTIVO')
                    //recorridos.set(parseFloat(recorridos.getNumber()) + parseFloat({{$movement->amount}}));
                    efectivo.set(parseFloat(efectivo.getNumber()) + parseFloat({{$movement->amount}}));
                @endif  
                @if($movement->method == 'RENDICION COBRADOR CHEQUE')
                    cheques.set(parseFloat(cheques.getNumber()) + parseFloat({{$movement->amount}}));
                    //recorridos.set(parseFloat(recorridos.getNumber()) + parseFloat({{$movement->amount}}));
                @endif
                @if($movement->method == 'RENDICION COBRADOR')
                    recorridos.set(parseFloat(recorridos.getNumber()) + parseFloat({{$movement->amount}}));
                @endif  
            @else
                tableOut.row.add([
                    '{{$movement->movementreason->description}}',
                    new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format('{{$movement->amount}}'),
                ]).draw( false );

                egresos.set(parseFloat(egresos.getNumber()) + parseFloat({{$movement->amount}}));
            @endif

            balance.set( parseFloat( ingresos.getNumber() ) - parseFloat( egresos.getNumber() ) );

        @endforeach

    }); 

    $("#movementtype_id").change(function(){
        $("#movementreason_id").empty();

        $.each(reason[$(this).val()], function(key, movementreason){
            $('select[name="movementreason_id"]').append('<option value="' + movementreason.id + '">' + movementreason.description + '</option>');
        });
        $("#movementreason_id").selectpicker("refresh");
    });

    function currency_format($id_currency){
        return new AutoNumeric($id_currency, {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});;
    }
    
</script>
