<script type="text/javascript">
$(document).ready(function() {

    $('select[name="country_id"]').on('change', function(){
        var country_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="province_id"]').empty();
        $('select[name="district_id"]').empty();
        $('select[name="town_id"]').empty();
        $('select[name="neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('country.provinces')}}",
            method: 'POST',
            data: {id:country_id, _token:token},
            dataType:"json",
            success: function(data) {
                var province_id = $("#province").val();
                $.each(data, function(key, value){
                    $('select[name="province_id"]').append('<option value="' + key + '"' + (key == province_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="province_id"]').selectpicker('refresh');
                $('select[name="district_id"]').selectpicker('refresh');
                $('select[name="town_id"]').selectpicker('refresh');
                $('select[name="neighborhood_id"]').selectpicker('refresh'); 
                $('select[name="province_id"]').trigger("change");
            }
        }); 
    });
    $('select[name="province_id"]').on('change', function(){
        var province_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="district_id"]').empty();
        $('select[name="town_id"]').empty();
        $('select[name="neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('province.districts')}}",
            method: 'POST',
            data: {id:province_id, _token:token},
            dataType:"json",
            success: function(data) {
                var district_id = $("#district").val();
                $.each(data, function(key, value){
                    $('select[name="district_id"]').append('<option value="' + key +'"' + (key == district_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="district_id"]').selectpicker('refresh');
                $('select[name="town_id"]').selectpicker('refresh');
                $('select[name="neighborhood_id"]').selectpicker('refresh');
                $('select[name="district_id"]').trigger("change");
            }
        });
    });
    $('select[name="district_id"]').on('change', function(){
        var district_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="town_id"]').empty();
        $('select[name="neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('district.towns')}}",
            method: 'POST',
            data: {id:district_id, _token:token},
            dataType:"json",
            success: function(data) {
                var town_id = $("#town").val();
                $.each(data, function(key, value){
                    $('select[name="town_id"]').append('<option value="' + key + '"' + (key == town_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="town_id"]').selectpicker('refresh');
                $('select[name="neighborhood_id"]').selectpicker('refresh');
                $('select[name="town_id"]').trigger("change");
            }
        });
    });
    $('select[name="town_id"]').on('change', function(){
        var town_id = $(this).val();
        var token = $("input[name='_token']").val();
        $('select[name="neighborhood_id"]').empty();
        $.ajax({
            url: "{{route('town.neighborhoods')}}",
            method: 'POST',
            data: {id:town_id, _token:token},
            dataType:"json",
            success: function(data) {
                var neighborhood_id = $("#neighborhood").val();
                $.each(data, function(key, value){
                    $('select[name="neighborhood_id"]').append('<option value="' + key + '"' + (key == neighborhood_id ? ' selected' : '') + '>' + value + '</option>');
                });
                $('select[name="neighborhood_id"]').selectpicker('refresh');
            }
        });
    });

});
</script>