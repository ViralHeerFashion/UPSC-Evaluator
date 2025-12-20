<script src="{{asset('public/admin/assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('public/admin/assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('public/js/plugins/toastr/toastr.min.js')}}"></script>
<script>
    $(document).ready(function(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            @if(session('alert_success'))
            timeOut: 4000
            @else
            timeOut: 10000
            @endif
        };
        @if(session('alert_success'))
            toastr.success('{{ session('alert_success') }}', 'Success');
        @endif
        @if(session('alert_error'))
            toastr.error('{{ session('alert_error') }}', 'Error');
        @endif
    });
</script>