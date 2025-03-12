@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'MODIFICAR USUARIO DE NIVEL')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' MODIFICAR USUARIO DE NIVEL')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                MODIFICAR USUARIO DE NIVEL - {{ $user->ocargo }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <table  class="table table-hover table-bordered table-sm"
                style="font-size:14px;"
                id="example130">
            <tbody >
                <tr>
                    <td colspan="2">
                        <a  href="{{ url($ruta) }}" 
                            class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                            <i class="fas fa-backward"></i>&nbsp;
                            VOLVER A &nbsp; <b>USUARIOS {{ $user->ocargo }}</b>
                        </a>
                    </td>
                </tr>
                <tr class="bg-lightblue disabled">
                    <td align="center" colspan="2">
                        <b>NIVEL: &nbsp;{{ $user->ocargo }}</b> 
                    </td>
                </tr>
                <tr class="bg-lightblue disabled">
                    <td align="center" colspan="2">
                        <b>CENTRO DE TRABAJO</b>
                    </td>
                </tr>
                <tr>
                    <td align="right" class="text-info">
                        <b>CENTRO DE TRABAJO</b>
                    </td>
                    <td width="60%">{{ $user->email.' - '.$user->name }}</td>
                </tr>
                <tr class="bg-lightblue disabled">
                    <td align="center" colspan="2">
                        <b>DATOS DEL USUARIO</b>
                    </td>
                </tr>
                <tr>
                    <td align="right" class="text-info">
                        <b>USUARIO</b>
                    </td>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <td align="right" class="text-info">
                        <b>CONTRASEÑA</b> s
                    </td>
                    <td>
                        {{$user->opwd}}&nbsp;&nbsp;
                        <x-adminlte-button  label="CAMBIAR CONTRASEÑA" 
                                            data-toggle="modal" 
                                            icon="fa fa-edit"
                                            data-target="#modalCustomHist" 
                                            class="btn bg-success btn-xs"/>


                        <x-adminlte-modal   id="modalCustomHist" 
                                            title="CAMBIO DE CONTRASEÑA" 
                                            size="lg" 
                                            theme="teal"
                                            icon="fa fa-copy" 
                                            v-centered static-backdrop >

                            <form   name="FrmCartel" id="FrmCartel" method="post" 
                                    action="{{ route('usuarios.update', $user->id ) }}" >
                                    @method('PATCH')
                                    @csrf

                                <input  type="hidden" 
                                        name="action" 
                                        id="action" 
                                        value="99">
                            
                                <div>
                                    <center>
                                        <b class="text-warning">
                                            <h3>ESTA ACCIÓN CAMBIARA LA CONTRASEÑA, POR LO QUE CON LA ANTERIOR YA NO PODRÁ ACCEDER EL C.T. 
                                            {{ $user->email.' - '.$user->name }}</h3>
                                        </b>
                                        <br>
                                        <button class="btn btn-success btn-sm">
                                            CAMBIAR CONTRASEÑA
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </center>
                                </div>

                            </form>

                            <x-slot name="footerSlot">
                                <x-adminlte-button  theme="secondary" 
                                                    label=" CANCELAR ACCIÓN " 
                                                    data-dismiss="modal" 
                                                    icon="fa fa-times"
                                                    class="btn-sm"/>
                            </x-slot>
                        </x-adminlte-modal>




                    </td>
                </tr>
            </tbody>
        </table>



    </div>
</div>
@stop