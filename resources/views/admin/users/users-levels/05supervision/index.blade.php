@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', ' USUARIOS DE SUPERVISIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', '  USUARIOS DE SUPERVISIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                USUARIOS DE SUPERVISIÓN
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
                    <th>VALLE</th>
                    <th>USUARIO</th>
                    <th>CONTRASEÑA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($cts as $key => $ct)
                <tr>
                    <td width="50%">{{ $ct->oct.' - '.$ct->name }}</td>
                    <td width="10%" align="center">{{ $ct->ovalle }}</td>
                    <td align="center" width="15%">{{ $ct->email }}</td>
                    <td align="center" width="15%">{{ $ct->opwd }}</td>
                    <td align="center" width="5%"> 
                        <a href="{{ route('usuarios-levels.edit', $ct->idus) }}"
                            class="btn btn-outline-info btn-xs" 
                            style="font-size:12px; text-decoration: none;">
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
