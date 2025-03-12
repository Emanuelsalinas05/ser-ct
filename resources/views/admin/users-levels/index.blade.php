@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'USUARIOS PARA APROBACIÓN DE ENTREGA - RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' USUARIOS PARA APROBACIÓN DE ENTREGA - RECEPCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                USUARIOS PARA APROBACIÓN DE ENTREGA - RECEPCIÓN
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class="list-group-item d-flex justify-content-between align-items-center"
            style="border: none;">
            <a  href="{{ route('usuarios-niveles.create') }}"
                class="btn btn-outline-success btn-sm ">
                <i class="fas fa-user-plus"></i>&nbsp;&nbsp;AGREGAR USUARIO PARA APROBACIÓN&nbsp;
            </a>
            &nbsp;
        </li>
        <br>

        <table  class="table table-hover table-bordered table-sm"
                style="font-size:14px;"
                id="example13">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>#</th>
                    <th>NOMBRE C.T.</th>
                    <th>PERFIL DEL USUARIO</th>
                    <th>USUARIO</th>
                    <th>CONTRASEÑA</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $key => $user)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$user->name.' - '.$user->elct->onombre_ct}}</td>
                    <td>{{$user->roluser->orol}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->opwd}}</td>
                    <td> 
                        @if($user->orol==2)
                        <a  href="{{ route('usuarios.edit', $user->id) }}"
                            class="btn btn-outline-dark btn-sm" 
                                style="font-size: 12px;">
                            <i class="fa fa-edit"></i>
                        </a>
                        @else
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        
    </div>
</div>
@stop