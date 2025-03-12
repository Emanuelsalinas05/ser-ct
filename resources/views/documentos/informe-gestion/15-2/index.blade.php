@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '15.2 INFORME DE COMPROMISOS EN LOS 90 DÍAS POSTERIORES A LA ENTREGA Y RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 15.2 INFORME DE COMPROMISOS EN LOS 90 DÍAS POSTERIORES A LA ENTREGA Y RECEPCIÓN')

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

        @if($avances->oinforme_compromisos_a==0)
        <x-adminlte-callout>
            <p style="font-size:13px; text-align: justify;">
                <i class="fa fa-info-circle"></i>&nbsp;
                <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
                {{ $documento->odescripcion }}.
                <br>AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
            </p>
            
            <a  href="{{route('informe-compromisos.create') }}"
                class="btn btn-outline-secondary btn-sm"
                style="text-decoration:none;">
                REGISTRAR COMPROMISO&nbsp;&nbsp;
                <i class="fa fa-edit"></i>
            </a>

        </x-adminlte-callout>
        @endif


        @if($icompromisosc>0)
            @if($avances->oinforme_compromisos_a==0)
            <ul class="list-group list-group-flush"
                style="font-size:12px;">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <b class="text-info" style="font-size: 14px;">
                        REGISTRO DE INFORME DE COMPROMISOS
                    </b>

                    <form   name="FrmCartel" id="FrmCartel" method="post" 
                            action="{{ route($documento->ourl_documentos.'.update', $datosacta->id ) }}" >
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
                            FINALIZAR REGISTRO DE COMPROMISOS&nbsp;
                            <i class="fas fa-check"></i>
                        </button>

                    </form>
                    
                </li>
            </ul>
            @endif

            <table  class="table table-sm"
                        style="font-size:13px;">
                <thead>
                    <tr class="bg-lightblue disabled">
                        <th>PROG.</th>
                        <th>INFORMACIÓN DEL COMPROMISO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($icompromisos as $key => $inventario )
                    <tr>
                        <td>
                            {{$key+1}}
                        </td>

                        <td>
                            <table class="table table-sm">
                                <tr>
                                    <td colspan="3">
                                        <b>RESPONSABLE</b>: {{$inventario->oresponsable}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:justify;">
                                        <b>DESCRIPCIÓN DEL ASUNTO</b>:<br>
                                        {{$inventario->odescripcion_asunto}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:justify;">
                                        <b>ACCIONES A REALIZAR</b>:<br>
                                        {{$inventario->oacciones_realizar}}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>LUGAR</b>: {{$inventario->olugar}}
                                    </td>
                                    <td>
                                        <b>FECHA Y HORA</b>: 
                                        {{$inventario->ofecha}} &nbsp;&nbsp;&nbsp;
                                        {{$inventario->ohora.'HRS.'}}
                                    </td>
                                </tr>       
                            </table>
                        </td>

                        <td>
                            @if($avances->oinforme_compromisos_a==0)
                            <a  href="{{ route($documento->ourl_documentos.'.edit', $inventario->id ) }}" 
                                title="Editar información"
                                class="btn btn-outline-warning btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            @endif
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

        
    </div>
</div>
@stop