<script type="text/javascript">

    var reason = [];
    var amount;
    var tableIn;
    var tableOut;
    var ingresos=0;
    var egresos=0;
    var inicial=0;
    var recorridos=0;
    var balance=0;


    $(document).ready(function() {

        var baseOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="seller_id"]').selectpicker(baseOptions);
        $('select[name="expenseconcept_id"]').selectpicker(baseOptions);

        amount = new AutoNumeric("#amount", {currencySymbol : ' $', decimalCharacter : ',', digitGroupSeparator : '.',currencySymbolPlacement:'s'});
        
        table = $('#tableExpenses').DataTable({
            columnDefs: [{ 
                className: "dt-right", "targets": [4] 
            }],
            "ordering": true,
            "iDisplayLength": 10,
            "order": [[ 0, "desc" ]]
        });
        
        @foreach ($expenses as $expense)
            table.row.add([
                '{{$expense->id}}',
                '{{$expense->seller->name}}',
                '{{$expense->expenseconcept->name}}',
                '{{$expense->date->format('d/m/Y') }}',
                new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format('{{($expense->expenseconcept->subtract==1)? $expense->amount * 1 : $expense->amount * -1 }}'),
            ]).draw( false );
        @endforeach


        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        $('.datepicker').datepicker('setDate', '0d');

    }); 

    $("#expenseForm").submit(function(e){
        e.preventDefault();
        
        var form = $("#expenseForm");
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

                table.row.add([
                    response.gasto.id,
                    $("#seller_id option:selected").text(),
                    $("#expenseconcept_id option:selected").text(),
                    $("#date").val(),
                    new Intl.NumberFormat('de-US', { style: 'currency', currency: 'USD' }).format((response.subtract)?amount.getNumber():(amount.getNumber())*-1)
                ]).draw( false );

                clearForm();

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
    });

    function clearForm(){

        amount.set(0);
        $("#seller_id").val('default').selectpicker('refresh')
        $("#expenseconcept_id").val('default').selectpicker('refresh')

        $("#date").val('');
    }

    
</script>