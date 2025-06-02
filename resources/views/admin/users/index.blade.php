@extends('layouts.app')

@section('title', 'USUARIOS DE ENTREGA - RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' USUARIOS DE ENTREGA - RECEPCIÓN')

@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                USUARIOS DE ENTREGA - RECEPCIÓN
            </b>
        </div>
    </div>
    <div class="card-body table-responsive">

        @if(Auth::user()->orol==1)
        <x-adminlte-callout>
            <form name="FrmCartel" id="FrmCartel" method="get" action="{{ route('usuarios.show', 0 ) }}">
                @method('PATCH')
                @csrf
                <table class="table-sm" style="font-size:14px;">
                    <tr>
                        <td align="right" width="35%">
                            <b class="text-info">INGRESA EL CENTRO DE TRABAJO COMPLETO</b>
                        </td>
                        <td width="20%">
                            <input type="text" id="elct" name="elct" class="form-control" required value="{{ old('elct') }}">
                        </td>
                        <td width="25%">
                            <button type="submit" class="btn btn-outline-success btn-sm">
                                BUSCAR C.T. &nbsp;&nbsp;
                                <i class="fa fa-search"></i>
                            </button>
                        </td>
                        <td width="25%" align="right">
                            <a href="{{ url('/usuarios') }}" class="btn btn-outline-info" style="font-size:14px;">
                                VER TODOS LOS USUARIOS
                            </a>
                        </td>
                    </tr>
                </table>
            </form>
        </x-adminlte-callout>
        @endif

        <table class="table table-hover table-striped table-sm" style="font-size:14px;" id="example13">
            <thead class="bg-lightblue" align="center">
            <tr>
                <th>CENTRO DE TRABAJO</th>
                <th>USUARIO</th>
                <th>CONTRASEÑA</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($usuariosFinales as $user)
            <tr>
                <td width="60%">{{ $user->oct . ' - ' . $user->name }}</td>
                <td align="center" width="15%">{{ $user->email }}</td>
                <td align="center" width="15%">{{ $user->opwd }}</td>
                <td align="center" width="5%">
                    <a href="{{ route('usuarios.edit', $user->id) }}"
                       class="btn btn-outline-dark btn-xs"
                       style="font-size: 12px;">
                        VER
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <br>

    </div>
</div>
@stop
