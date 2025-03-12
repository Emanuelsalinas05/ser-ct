@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')


@stop


{{-- Create a common footer --}}

@section('footer')
    <div class="float-right">
        SEIEM |  {{ config('app.version', date('Y')) }}
    </div>

    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('app.company_name','') }}
        </a>
    </strong>
@stop

{{-- Add common Javascript/Jquery code --}}
@push('js')

    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>


    $(document).ready(function() {

        $('select').selectpicker();
        
        $('#ohechos_a').hide();
        $('#onombre_representante_contraloria_a').hide();
        $('#namerepres').hide();
        $('#reprecon').hide();
        $('#reprecon2').hide();
        $('#ohechos_azx').hide();
        $('#repres_ac1').hide();
        $('#repres_ac2').hide();
        $('#repres_ac3').hide();
        $('#ohechos_acz').hide();
        $('#ohechos_aczx').hide();
        // Add your common script logic here...
    });

document.addEventListener('DOMContentLoaded', function () {
    @if (session('success'))
        swal("Correcto", "{{ session('success') }}", "success");
    @endif

    @if (session('info'))
        swal("Aviso", "{{ session('info') }}", "info");
    @endif

    @if (session('warning'))
       swal("Atención", "{{ session('warning') }}", "warning");
    @endif

    @if (session('danger'))
       swal("Atención", "{{ session('danger') }}", "danger");
    @endif

    @if (session('recursoshumanos'))
        Swal.fire({
                title: 'Recursos Humanos',
                text:  'Se registraron correctamente los datos',
                icon:  'success'
            });
    @endif

    @if (session('recursosmateriales'))
        Swal.fire({
                title: 'Situación de Recursos Materiales',
                text:  'Se registraron correctamente los datos',
                icon:  'success'
            });
    @endif

    @if (session('recursostics'))
        Swal.fire({
                title: 'Situación de las TIC´s',
                text:  'Se registraron correctamente los datos',
                icon:  'success'
            });
    @endif

    @if (session('archivos'))
        Swal.fire({
                title: 'Archivos',
                text:  'Se registraron los archivos',
                icon:  'success'
            });
    @endif

    @if (session('noadeudo'))
        Swal.fire({
                title: 'Certificados de no adeudo',
                text:  'Se guardaron correctamente los certificados',
                icon:  'success'
            });
    @endif

    @if (session('informegestion'))
        Swal.fire({
                title: 'Informe de Gestión',
                text:  'Se guardaró correctamente el informe de gestión',
                icon:  'success'
            });
    @endif

    @if (session('otroshechos'))
        Swal.fire({
                title: 'Otros hechos',
                text:  'Se guardaró la información de otros hechos',
                icon:  'success'
            });
    @endif



});

$(function () {
        $("#example13").DataTable({
            "select": true,
            "paging": true,
            "lengthMenu": true,
            "lengthChange": true,
            "searching": true,
           "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                        },
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "buttons": ["copy", "excel", "pdf", "print", "pageLength"],
            lengthMenu: [
                            [25, 50, 100, 150, -1],
                            ['25', '50', '100', '150', 'Ver todos']
                        ],

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



        $("#example130").DataTable({
            "select": false,
            "paging": false,
            "lengthMenu": false,
            "lengthChange": false,
            "searching": true,
           "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                        },
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "buttons": ["copy", "excel", "pdf", "print", "pageLength"],
            lengthMenu: [
                            [25, 50, 100, 150, -1],
                            ['25', '50', '100', '150', 'Ver todos']
                        ],

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });





</script>
@endpush

{{-- Add common CSS customizations --}}
@push('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css" rel="stylesheet">
<style type="text/css">
    {{-- You can add AdminLTE customizations here --}}
    /*
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-weight: 600;
    }
    */
</style>
@endpush