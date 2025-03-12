@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'USUARIOS DE ENTREGA - RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' USUARIOS DE ENTREGA - RECEPCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                USUARIOS DE ENTREGA - RECEPCIÓN
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <form   name="FrmCartel" id="FrmCartel" 
                method="get" 
                action="{{ route('usuarios.show', 0 ) }}" >
                @method('PATCH')
                @csrf

            <table class="table table-sm " style="font-size:14px;">
                <tr>
                    <td align="right" width="25%">
                        <b class="text-info">BUSCAR CENTRO DE TRABAJO</b>
                    </td>
                    <td width="20%">
                        <input  type="text" 
                                id="elct" name="elct"
                                class="form-control"
                                required 
                                value="{{ old('elct', $requeste) }}" >
                    </td>
                    <td width="25%">
                        <button type="submit" 
                                class="btn btn-outline-success btn-sm">
                            VER USUARIO &nbsp;&nbsp;
                            <i class="fa fa-search"></i>
                        </button>
                    </td>
                    <td width="35%" align="right">
                        <a href="{{ url('/usuarios') }}"
                            class="btn btn-outline-info"
                            style="font-size:14px;">
                            VER TODOS LOS USUARIOS
                        </a>
                    </td>
                </tr>
            </table>
        </form>


        @if($ban==1)
        <table  class="table table-hover table-bordered table-sm"
                style="font-size:14px;"
                id="example1300">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>CENTRO DE TRABAJO</th>
                    <th>PERFIL DEL USUARIO</th>
                    <th>USUARIO</th>
                    <th>CONTRASEÑA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $userx->email.' - '.$userx->elct->onombre_ct }}</td>
                    <td>{{ $userx->roluser->orol}}</td>
                    <td>{{ $userx->email}}</td>
                    <td>{{ $userx->opwd}}</td>
                    <td> 
                        <a  href="{{ route('usuarios.edit', $userx->id_ct) }}"
                            class="btn btn-outline-dark btn-sm" 
                                style="font-size: 12px;">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <center>
            <h3 class="text-warning">
                <b>USUARIO NO ENCONTRADO</b>
            </h3>
        </center>
        @endif
        


    </div>
</div>
@stop