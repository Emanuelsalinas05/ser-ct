@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'USUARIOS ESCUELAS. ENTREGA-RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'USUARIOS ESCUELAS. ENTREGA-RECEPCIÓN')

{{-- Content body: main page content --}}
@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between" style="font-size:13px;">
            <b><i class="nav-icon fa fa-school"></i>&nbsp;
                USUARIOS ESCUELAS. ENTREGA-RECEPCIÓN
            </b>
        </div>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-hover table-bordered table-sm"
               style="font-size:12px;"
               id="example13">
            <thead class="bg-lightblue" align="center">
            <tr>
                <th>#</th>
                <th>NOMBRE C.T.</th>
                <th>NIVEL DE ACCESO</th>
                <th>VALLE</th>
                <th>USUARIO</th>
                <th>CONTRASEÑA</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuarios as $key => $usrs)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $usrs->oct . ' - ' . $usrs->name }}</td>
                <td align="center">{{ $usrs->ocargo }}</td>
                <td align="center">{{ $usrs->ovalle }}</td>
                <td align="center">{{ $usrs->email }}</td>
                <td align="center">
                    <span class="password-mask" data-pass="{{ $usrs->opwd }}">******</span>
                    <button class="btn btn-outline-info btn-sm ver-pass">VER</button>
                </td>
                <td align="center">
                    <a href="#"
                       class="btn btn-outline-dark btn-sm"
                       style="font-size: 12px;">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@push('scripts')
<script>
    document.querySelectorAll('.ver-pass').forEach(btn => {
        btn.addEventListener('click', function () {
            const span = this.previousElementSibling;
            span.textContent = span.dataset.pass;
        });
    });
</script>
@endpush
