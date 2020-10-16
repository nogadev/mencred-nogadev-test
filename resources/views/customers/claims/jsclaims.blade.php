<script type="text/javascript">

    var claimTable;

    $(document).ready(function() {

        var baseOptions = $.extend( {}, selectBootDefaOpt);
        $('select[name="newClaimType"]').selectpicker(baseOptions);

        claimTable = $('#tableClaims').DataTable( {
            searching: false, 
            paging: false, 
            info: false,
            "columns": [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { "data": "type" },
                { "data": "init_date" },
                { "data": "end_date" },
                { "data": "status" },
                { "data": "actions" },
                { "data": "print" }
            ],
        } );

        $('#tableClaims tbody').on('click', 'td.details-control', function () {

            var tr = $(this).closest('tr');
            var row = claimTable.row( tr );            

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                tr.addClass('more');                
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                $("#claim_id").val(row.data().id);                
                tr.removeClass('more');
                tr.addClass('shown');
            }
        });


        $("#lnkNuevoReclamo").on('click', function(e){
            e.preventDefault();
            $("#newClaimModal").modal('show');            
        });

    });

    function storeNewClaim(){
        var type=       $("#newClaimType").val();
        var init_date=  $("#newClaimDateInit").val();
        var observation=$("#newClaimObservation").val();
        var credit_id=  $("#credit_id").val();
        var _token =    $("input[name='_token']").val();

    if (type != null && type != '' && observation != null && observation != ''){
        $.ajax({
            type: "POST",
            url: "{{route('claim.store')}}",
            data: {
                credit_id:  credit_id,
                observation:observation,
                init_date:  init_date,
                type:       type
            },
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function (response) {
            
                var action = '<a onclick="resolvClaim(0,0)" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="CONFIRMAR"><i class="fa fa-check" aria-hidden="true"></i></a>';
                var claimId = response.id;
                var printClaim = "{{url( '/print/claim') }}/" + claimId;
                var print = '<a id="printClaim" target="_blank" href='+printClaim+' class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="IMPRIMIR"><i class="fa fa-print" aria-hidden="true"></i></a>';

                claimTable.row.add({
                    id:         response.id,
                    detail:     '',
                    type:       response.type,
                    init_date:  init_date,
                    end_date:   '',
                    status:     response.status.status,
                    trakings:   response.claimtrakings,
                    actions:    action,
                    print:      print
                }).draw( false );

                $("#newClaimType").val('');
                $("#newClaimDateInit").val('');
                $("#newClaimObservation").val('');

                $.notify(
                    {
                        // options
                        icon: 'fas fa-success-circle',
                        message: "Observación registrada con éxito"
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

                $("#newClaimModal").modal('hide');

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
    }

    }


    function format ( claim ) {

        // `d` is the original data object for the row
        var str = '<table id="trakingsTable" cellspacing="0" border="0" style="width:100%">';
        $.each(claim.trakings, function(i, d){

            var arr = d.date_of.split(' ')[0].split('-');
            date_of = arr[2]+'/'+arr[1]+'/'+arr[0];

            str = str + '<tr>'+
                '<td>'+date_of+'</td>'+
                '<td>'+d.observation+'</td>'+
            '</tr>';
        });

        if(claim.status != 'RESUELTO'){
            str = str + '<tr>'+
                    '<td>'+
                    '</td>'+
                    '<td>'+
                        '<input id="inputNewTraking" class="form-control form-control-sm" placeholder="NUEVA OBSERVACION" type="text" style="width:90%"/>'+
                    '</td>'+
                    '<td>'+
                        '<a onclick="addTraking()" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="CONFIRMAR"><i class="fa fa-check" aria-hidden="true"></i></a>'+
                    '</td>'+
                '</tr>';
        }

        str  = str + '</table>';
        return str;
    }

    function addTraking(){
        var claim_id= $("#claim_id").val();
        var d       = new Date();
        var date    = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();
        var obs     = $("#inputNewTraking").val();
        var _token  = $("input[name='_token']").val();

        //borro el form ficticio para ponerlo despues a lo ultimo
        $("#trakingsTable tr:last").remove();

        $.ajax({
            type: "POST",
            url: "{{route('claim.trakingStore')}}",
            data: {
                claim_id:   claim_id,
                observation:obs,
                date_of:    d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate()
            },
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function (response) {
                $.notify(
                    {
                        // options
                        icon: 'fas fa-success-circle',
                        message: "REGISTRADO"
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
                        message: "ERROR"
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

        str = '<tr>'+
            '<td>'+date+'</td>'+
            '<td>'+obs+'</td>'+
        '</tr>';

        $("#trakingsTable").append(str);

        str = '<tr>'+
                '<td>'+
                '</td>'+
                '<td>'+
                   '<input id="inputNewTraking" class="form-control form-control-sm" placeholder="NUEVA OBSERVACION" type="text" style="width:90%"/>'+
                '</td>'+
                '<td>'+
                   '<a onclick="addTraking()" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="CONFIRMAR"><i class="fa fa-check" aria-hidden="true"></i></a>'+
                '</td>'+
            '</tr>';
        $("#trakingsTable").append(str);
        refreshClaimTable();

    }

    function resolvClaim(id, index){

        var _token  = $("input[name='_token']").val();

        $.ajax({
            type: "POST",
            url: "{{route('claim.resolv')}}",
            data: {
                id:id
            },
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function (response) {

                var arr = response.end_date.split(' ')[0].split('-');
                var end_date = arr[2]+'/'+arr[1]+'/'+arr[0];

                data = claimTable.row(index).data();
                data.end_date = end_date;
                data.status  = 'RESUELTO';
                data.actions = '';

                claimTable.row(index).data(data).draw( false );

                $.notify(
                    {
                        // options
                        icon: 'fas fa-success-circle',
                        message: "Reclamo resuelto con éxito"
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
    }

    function refreshClaimTable(){
        var id=  $("#credit_id").val();
        $.get("{{ route('claimsJson') }}", { credit_id: id } , function (data) {
                claimTable.clear();
                $.each(data, function(i, item) {

                    var arr = item.init_date.split(' ')[0].split('-');
                    var init_date = arr[2] + '/' + arr[1] + '/' + arr[0];                    

                    var end_date = '';
                    if(item.end_date != null){
                        var arr = item.end_date.split(' ')[0].split('-');
                        end_date = arr[2]+'/'+arr[1]+'/'+arr[0];
                    }

                    var action = '';
                    if(item.status_id == 7){
                        var action = '<a onclick="resolvClaim('+item.id+','+i+')" class="btn btn-success btn-circle" data-toggle="tooltip" data-placement="top" title="Confirmar"><i class="fa fa-check" aria-hidden="true"></i></a>';
                    }
                    var claimId = item.id;
                    var printClaim = "{{url( '/print/claim') }}/" + claimId;
                    var print = '<a id="printClaim" target="_blank" href='+printClaim+' class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="top" title="IMPRIMIR"><i class="fa fa-print" aria-hidden="true"></i></a>';
                                        
                    claimTable.row.add({
                        id:         item.id,
                        detail:     '',
                        type:       item.type,
                        init_date:  init_date,
                        end_date:   end_date,
                        status:     item.status.status,
                        trakings:   item.claimtrakings,
                        actions:    action,
                        print:      print
                    }).draw( false );
                });
        });
    }




</script>