@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '15.1 INFORME DE GESTIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 15.1 INFORME DE GESTIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
            {{  $documento->onum_documento }} {{ $documento->odocumento }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/informe-gestion') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>{{$anexo->onum_anexo.'. '.$anexo->oanexo}}</b>
            </a>&nbsp;
        </li>
        <br>

        @if($avances->oinforme_gestion_a==0)
        <x-adminlte-callout>
            <p style="font-size:13px; text-align: justify;">
                <i class="fa fa-info-circle"></i>&nbsp;
                <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
                {{ $documento->odescripcion }}.
                <br>AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
            </p>
            @if($igestionc==0)
            <a  href="{{route('informe-gestion-plantilla.create') }}"
                class="btn btn-outline-secondary btn-sm"
                style="text-decoration:none;">
                REGISTRAR INFORME DE GESTIÓN&nbsp;&nbsp;
                <i class="fa fa-edit"></i>
            </a>
            @endif

        </x-adminlte-callout>
        @endif

        @if($igestionc>0)
            @if($avances->oinforme_gestion_a==0)
            <ul class="list-group list-group-flush"
                style="font-size:12px;">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a  href="{{route('informe-gestion-plantilla.edit', $datosacta->id)}}" 
                        class="btn btn-outline-secondary btn-sm" 
                        title="">
                        MODIFICAR REGISTRO DE GESTIÓN&nbsp;
                        <i class="fa fa-edit"></i>
                    </a>

                    <form   name="FrmCartel" id="FrmCartel" method="post" 
                            action="{{ route($documento->ourl_documentos.'.update', $igestion->id ) }}" >
                        @method('PATCH')
                        @csrf
                        <input  type="hidden" 
                                name="acta" 
                                id="acta" 
                                value="{{ $datosacta->id }}">
                            
                        <input  type="hidden" 
                                name="action" 
                                id="action" 
                                value="1">

                        <button class="btn btn-success btn-sm"
                                style="font-size: 14px;">
                            FINALIZAR REGISTRO DE GESTIÓN&nbsp;
                            <i class="fas fa-check"></i>
                        </button>

                    </form>
                    
                </li>
            </ul>
            @endif
            
            <table  class="table table-striped table-sm"
                    style="font-size:14px;">
            <thead>
                <tr class="bg-lightblue disabled">
                    <th>REGISTRO DE INFORME DE GESTIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roi }}</b>
                        <p>{{ $igestion->oi }}</p>
                    </td>
                </tr>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roii }}</b>
                        <p>{{ $igestion->oii }}</p>
                    </td>
                </tr>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roiii }}</b>
                        <p>{{ $igestion->oiii }}</p>
                    </td>
                </tr>
                <tr class="text-secondary" style="text-align: justify;">
                    <td scope="row">
                        <b>{{ $igestion->roiv }}</b>
                        <p>{{ $igestion->oiv }}</p>
                    </td>
                </tr>
            </tbody>
            </table>

        @endif

        
    </div>
</div>
@stop