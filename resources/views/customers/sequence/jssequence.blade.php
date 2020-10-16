<script type="text/javascript">
	var table;
	var itemNo = 0;
	var ordenSelect = 0;
	var sequenceData = [];
    var sequence = [];

    var visitdays = [];

	$(document).ready(function(){

        $.each(@json($visitdays) , function ($key, visitday){
            if(visitday.name != ""){
                visitdays.push({
                    'id' : visitday.id, 
                    'name' : visitday.name
                });
            }
        });

		var routeOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="route_id"]').selectpicker(routeOptions);

	    table = $('#tableSequence').DataTable({
            columnDefs: [{ 
                className: "dt-right", "targets": [1,2,3,4,5,6] 
            }],
            "ordering": false,
            "iDisplayLength": 100
        });

	});


    /*
    function selectVisitday(id){
        var visitday_select = $("#visitday_"+id).val();
        if(visitdays[visitday_select] == null || visitdays[visitday_select] == 'undefined'){
            $("#visitday_"+id).val('');
            $("#visitday_id_"+id).val('');
            visitday_select = null;
        }else{
            $("#visitday_"+id).val(visitdays[visitday_select]);
            $("#visitday_id_"+id).val(parseInt(visitday_select));
        }
        sequence[id].visitday_id = visitday_select;
    }
    */

    function changeSequence(customer_id){
        sequence[customer_id].sequence_order = parseInt($("#sequence_"+customer_id).val());
    }

    $(document).on('keyup', 'input', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            var name    = $(this).attr("name").split('_')[0];
            var i       = $(this).attr("name").split('_')[1];
            var id      = $(this).attr("id").split('_')[2];
            if(name == 'sequence'){
                $("input[name='visitday_"+i+"']").focus();
            }else{
                i++;
                $("input[name='sequence_"+i+"']").focus();
            }
        }
    });

	$("#sequenceForm").submit(function(e){
        e.preventDefault();

        var sequence_data = [];
        $.each(sequence, function(key, item){
            if(item != null){
                sequence_data.push(item);
            }
        });

        $("#sequence_data").html(JSON.stringify(sequence_data));
        $('#confirmModal').modal('show');
    });

    function submitForm(){
        $("#sequenceForm").submit();
    }

    function saveConfirm(){
        $('#confirmModal').modal('hide');
        
        var form = $("#sequenceForm");
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

    function saveCancel(){
        $('#confirmModal').modal('hide');
    }

	
    function getData(){
    	var route_id = $("#route_id").val();

        table.clear().draw();
        sequence = [];

    	if(route_id > 0){
            itemNo = 0;

    		$.ajax({
	            type: "GET",
	            url: "{{route('customers.sequence.data')}}",
	            data: {route_id : route_id}, // serializes the form's elements.
	            success: function(response){

	                $.each(response, function(i, customer){
                        itemNo++;
                        var visitday_text = (customer.visitday !== null)?customer.visitday.name:'';

                        table.row.add([
                            itemNo,
                            customer.name,
                            customer.seller.name || '',
                            (customer.commercial_neighborhood !== null)?customer.commercial_neighborhood.name:'',
                            customer.commercial_address,
                            '<input name="sequence_'+i+'" id="sequence_'+customer.id+'" style="width:50%; display:inline;text-align:right" onchange="changeSequence('+customer.id+','+itemNo+')" class="form-control form-control-sm enterSelect" type="text" value="'+customer.sequence_order+'" >',
                            '<div><input name="visitday_'+i+'" id="visitday_'+customer.id+'" style="width:100%;display:inline" autocomplete="off" class="form-control typeahead typeahead-fixed form-control-sm enterSelect" type="text"></div>',
                        ]).draw( false );

                        $('#visitday_'+customer.id).typeahead({
                            minLength: 1,
                            hint: true,
                            highlight: true,  
                            freeInput: false,
                            autoselect: 'first',
                            source: visitdays,
                            updater: function(item){
                                sequence[customer.id].visitday_id = item.id;
                                return item.name;
                            }
                        });

                        $('#visitday_'+customer.id).val(visitday_text);

                        sequence[customer.id] = {
                            customer_id   : customer.id,
                            sequence_order: customer.sequence_order,
                            old_sequence  : customer.sequence_order,
                            visitday_id   : customer.visitday_id
                        };
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

            $("#linkPrint").attr('href', "{{url( '/print/customers/sequence') }}/" + route_id);
    	}
    }

</script>