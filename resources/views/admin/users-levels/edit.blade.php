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
                MODIFICAR USUARIO DE NIVEL 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('usuarios.update', $user->id  ) }}" >
        @method('PATCH')
        @csrf
        <table  class="table table-sm" width="100%" 
                style="font-size:14px;"
                id="example13">
            <tbody>
                <thead>
                    <tr>
                        <th colspan="2" class="text-info">
                            AQUÍ PODRÁS REESTABLECER LA COTRASEÑA DEL USUARIO, 
                            LA CUAL SE GENERA DE MANERA ALEATORIA Y AUTOMÁTICA
                        </th>
                    </tr>
                </thead>
                <tr>
                    <td align="right" width="20%"><b>CLAVE CT</b></td>
                    <td width="70%" >
                        {{ $user->email }}
                    </td>
                </tr>
                <tr>
                    <td align="right" width="20%"><b>NOMBRE DEL CT</b></td>
                    <td width="70%" >
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <td align="right" width="20%"><b>CONTRASEÑA</b></td>
                    <td width="30%">
                        {{ $user->opwd }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <a  href="/usuarios"
                            class="btn btn-secondary btn-sm ">
                            <i class="fas fa-reply-all"></i>
                            Regresar
                        </a>
                    <td>
                        <button type="submit"
                                class="btn btn-outline-dark bg-teal btn-sm">
                            REESTABLECER CONTRASEÑA&nbsp;
                            <i class="fa fa-save"></i>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>
        </form>
        
    </div>
</div>
@stop