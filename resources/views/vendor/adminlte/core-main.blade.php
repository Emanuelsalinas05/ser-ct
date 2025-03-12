@extends('adminlte::page')

{{-- Customize layout sections --}}


{{-- Content body: main page content --}}

@section('content_body')
@section('plugins.Sweetalert2', true)
<br>
    <div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="fab fa-buromobelexperte dorado"></i>&nbsp;
                <span class="guinda2" >
                    @yield('head_card')
                      
                </span>
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive guinda" >
    @yield('body_card')
        


    </div>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
@yield('alert-messages')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script>
    $(document).ready(function() {

        @if (session('warning'))
        Swal.fire(
                'Error job!',
                'You clicked the button!',
                'warning'
            );
        @endif

        @if (session('error'))
            Swal.fire(
                'Error job!',
                'You clicked the button!',
                'error'
            );
        @endif

        @if (session('success'))
        Swal.fire(
                'Error job!',
                'You clicked the button!',
                'success'
            );
        @endif
    })
</script>

@endpush