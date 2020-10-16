<script type="text/javascript">

    $(document).ready(function() {

        var baseOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="kinship_id"]').selectpicker(baseOptions);
        $('select[name="marital_status"]').selectpicker(baseOptions);
        $('select[name="seller_id"]').selectpicker(baseOptions);
        $('select[name="route_id"]').selectpicker(baseOptions);
        $('select[name="commerce_id"]').selectpicker(baseOptions);
        $('select[name="commercial_district_id"]').selectpicker(baseOptions);
        $('select[name="personal_district_id"]').selectpicker(baseOptions);
        $('select[name="commercial_town_id"]').selectpicker(baseOptions);
        $('select[name="personal_town_id"]').selectpicker(baseOptions);
        $('select[name="commercial_neighborhood_id"]').selectpicker(baseOptions);
        $('select[name="personal_neighborhood_id"]').selectpicker(baseOptions);
        $('select[name="customer_category_id"]').selectpicker(baseOptions);

        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            maxViewMode: "decades",
            endDate: "0d",
            language: "es",
            autoclose: true
        });

        if($('.datepicker').val()===""){
            $('.datepicker').datepicker('setDate', '0d');
        }

        if($("input[name='defaulter").prop('checked')){
            $('main').addClass('bg-warning');
        };
    });

    $("#customerForm").submit(function(e){
        e.preventDefault();
        var form = $("#customerForm");
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
                window.location.href = '/customers';
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

$('select[name="commercial_district_id"]').on('change', function(){
        var district_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="commercial_town_id"]').empty();
        $('select[name="commercial_neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('district.towns')}}",
            method: 'POST',
            data: {id:district_id, _token:token},
            dataType:"json",
            success: function(data) {
                var town_id = $("#town").val();
                $.each(data, function(key, value){
                    $('select[name="commercial_town_id"]').append('<option value="' + key + '"' + (key == town_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="commercial_town_id"]').selectpicker('refresh');
                $('select[name="commercial_neighborhood_id"]').selectpicker('refresh');
                $('select[name="commercial_town_id"]').trigger("change");
            }
        });
    });
    $('select[name="commercial_town_id"]').on('change', function(){
        var town_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="commercial_neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('town.neighborhoods')}}",
            method: 'POST',
            data: {id:town_id, _token:token},
            dataType:"json",
            success: function(data) {
                var neighborhood_id = $("#neighborhood").val();
                $.each(data, function(key, value){
                    $('select[name="commercial_neighborhood_id"]').append('<option value="' + key + '"' + (key == neighborhood_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="commercial_neighborhood_id"]').selectpicker('refresh');
            }
        });
    });
    $('select[name="personal_district_id"]').on('change', function(){
        var district_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="personal_town_id"]').empty();
        $('select[name="personal_neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('district.towns')}}",
            method: 'POST',
            data: {id:district_id, _token:token},
            dataType:"json",
            success: function(data) {
                var town_id = $("#town").val();
                $.each(data, function(key, value){
                    $('select[name="personal_town_id"]').append('<option value="' + key + '"' + (key == town_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="personal_town_id"]').selectpicker('refresh');
                $('select[name="personal_neighborhood_id"]').selectpicker('refresh');
                $('select[name="personal_town_id"]').trigger("change");
            }
        });
    });
    $('select[name="personal_town_id"]').on('change', function(){
        var town_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="personal_neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('town.neighborhoods')}}",
            method: 'POST',
            data: {id:town_id, _token:token},
            dataType:"json",
            success: function(data) {
                var neighborhood_id = $("#neighborhood").val();
                $.each(data, function(key, value){
                    $('select[name="personal_neighborhood_id"]').append('<option value="' + key + '"' + (key == neighborhood_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="personal_neighborhood_id"]').selectpicker('refresh');
            }
        });
    });

    $("input[name='defaulter").on('change', function(){
        if($("input[name='defaulter").prop('checked')){
            $('main').addClass('bg-warning');
        }else{
            $('main').removeClass('bg-warning');
        };
    });
</script>