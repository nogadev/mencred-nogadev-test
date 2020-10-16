<script type="text/javascript">
	
    var reasons = [];

	$(document).ready(function(){



	});


	function activeButton(id){
		var btn = '<button type="button" id="btnModify" name="'+id+'" class="btn_modifyFee btn btn-success btn-circle"><i class="fa fa-check"></i></button>';

		$("#action_"+id).empty();
		$("#action_"+id).append(btn);
		
	}


	$(document).on('click', '#btnModify',function(){

		var id = $(this).attr('name');

		var _token = $("input[name='_token']").val();

		var paid_amount = $("#paid_"+id).val();
		var reason_id = $("#reason_"+id).val();

		$.ajax({
            type: "POST",
            url: "{{route('credits.updateFee')}}",
            data: {
            	id:id , 
            	paid_amount:paid_amount,
            	reason_id:reason_id
            },
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function (response) {
                $("#action_"+id).empty();

				$.notify(
                    {
                        // options
                        icon: 'fas fa-success-circle',
                        message: "Cuota actualizado con éxito"
                    },{
                        // settings
                        type: "success",
                        showProgressbar: false,
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    }
                );

            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify(
                    {
                        // options
                        icon: 'fas fa-exclamation-circle',
                        message: "Se ha producido un error"
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
        });
	});

	


</script>