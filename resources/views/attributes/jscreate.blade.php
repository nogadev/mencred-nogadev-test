<script type="text/javascript">
    $("#attributesForm").submit(function(e){
        e.preventDefault();
        
        var form = $("#attributesForm");
        var url  = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response){
                $.notify(
                    {
                        icon: 'fas fa-exclamation-circle',
                        message: response.message
                    },{
                        type: "success",
                        showProgressbar: false,
                        mouse_over: 'pause',
                        animate: {
                            enter: 'animated bounceIn',
                            exit: 'animated bounceOut'
                        }
                    }
                );
                window.location.href = url;
            },
            error: function(response) {
                if( response.status === 422 ) {
                    var errors = $.parseJSON(response.responseText).errors;
                }else{
                    var errors=[response.message];
                }
                $.each(errors, function(key, value){
                    $.notify({
                            icon: 'fas fa-exclamation-circle',
                            message: value
                        },{
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

</script>