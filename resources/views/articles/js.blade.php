<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="article_category_id"]').on('change', function(){
            var article_category_id = $(this).val();
            var article_id = $("#id").val();
            var token = $("input[name='_token']").val();
            $('#attributes').html('');
            $.ajax({
                url: "{{route('articleCategories.attributes')}}",
                method: 'POST',
                data: {id:article_category_id, _token:token},
                dataType:"json",
                success: function(data) {
                    console.log(data);
                    var div_class = "form-group col-xs-12 col-sm-12 col-md-4 col-lg-4";
                    var input_class = "form-group";
                    var html = "";
                    $.each(data, function(key, value){
                        html += '<div class="' + div_class + '">';
                        html += '<label>' + value + '</label>';
                        html += '<input type="hidden" name="art_attr_ids[]" class="form-control" value="0">';
                        html += '<input type="hidden" name="attr_ids[]" class="form-control" value="' + key + '">';
                        html += '<input type="text" name="attr_values[]" class="form-control" placeholder="' + value + '">';
                        html += '</div>';
                    });
                    $('#attributes').html(html);
                    art_attr_ids
                }
            }); 
        });
    });
</script>