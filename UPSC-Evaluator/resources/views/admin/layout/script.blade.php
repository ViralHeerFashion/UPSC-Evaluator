<script src="{{asset('admin/assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/dist/js/adminlte.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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