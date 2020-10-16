<script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"></script>
<script>
    var def_title = "<strong>{{ config('app.name', 'Laravel') }}</strong><br/>";
    var newest = true;
    var progressBar = false;
    var mouse = 'pause';
    var animate_enter = 'animated fadeInDown';
    var animate_exit = 'animated fadeOutUp';

    @if(Session::has('success'))   
        $.notify(
            {
                // options
                icon: 'fas fa-check-circle',
                title: def_title,
                message: "{{ Session::get('success') }}"
            },{
                // settings
                type: "success",
                newest_on_top: newest,
                showProgressbar: progressBar,
                mouse_over: mouse,
                animate: {
                    enter: animate_enter,
                    exit: animate_exit
                }
            }
        );
        @php
            Session::forget('success');
        @endphp
    @endif

    @if(Session::has('info'))
        $.notify(
            {
                // options
                icon: 'fas fa-info-circle',
                title: def_title,
                message: "{{ Session::get('info') }}"
            },{
                // settings
                type: "info",
                newest_on_top: newest,
                showProgressbar: progressBar,
                mouse_over: mouse,
                animate: {
                    enter: animate_enter,
                    exit: animate_exit
                }
            }
        );
        @php
            Session::forget('info');
        @endphp
    @endif


    @if(Session::has('warning'))
        $.notify(
            {
                // options
                icon: 'fas fa-exclamation-circle',
                title: def_title,
                message: "{{ Session::get('warning') }}"
            },{
                // settings
                type: "warning",
                newest_on_top: newest,
                showProgressbar: progressBar,
                mouse_over: mouse,
                animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated bounceOut'
                }
            }
        );
        @php
            Session::forget('warning');
        @endphp
    @endif


    @if(Session::has('danger'))
    console.log({{ Session::get('danger') }});
        $.notify(
            {
                // options
                icon: 'fas fa-times-circle',
                title: def_title,
                message: "{{ Session::get('danger') }}"
            },{
                // settings
                type: "danger",
                newest_on_top: newest,
                showProgressbar: progressBar,
                mouse_over: mouse,
                animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated bounceOut'
                }
            }
        );
        @php
            Session::forget('danger');
        @endphp
    @endif
</script>