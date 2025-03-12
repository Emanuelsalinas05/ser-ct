@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', ' USUARIOS DE DIRECCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' USUARIOS DE DIRECCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                USUARIOS DE DIRECCIÓN
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

     
            <table  class="table table-hover table-striped table-sm"
                style="font-size:14px;"
                id="example13">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>CENTRO DE TRABAJO</th>
                    <th>USUARIO</th>
                    <th>CONTRASEÑA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($usct as $key => $ct)
                <tr>
                    <td width="60%">{{ $ct->usct->oct.' - '.$ct->usct->name }}</td>
                    <td align="center" width="15%">{{ $ct->usct->email }}</td>
                    <td align="center" width="15%">{{ $ct->usct->opwd }}</td>
                    <td align="center" width="5%"> 
                        <a  href="{{ route('usuarios.edit', $ct->usct->id_ct) }}"
                            class="btn btn-outline-dark btn-xs" 
                                style="font-size: 12px;">
                            VER
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        
    </div>
</div>
@stop
