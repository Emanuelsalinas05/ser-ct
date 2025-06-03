@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '5.3  RELACIÓN DE SERVIDORES PÚBLICOS COMISIONADOS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 5.3  RELACIÓN DE SERVIDORES PÚBLICOS COMISIONADOS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
            {{  $documento->onum_documento }}. {{ $documento->odocumento }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/recursos-humanos') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>{{$anexo->onum_anexo.'. '.$anexo->oanexo}}</b>
            </a>&nbsp;
        </li>
        <br>
        
        @if($avances->oplantilla_comisionados_a==0)
        <x-adminlte-callout>
            <p style="font-size:12px;">
                <i class="fa fa-info-circle"></i>&nbsp;
                <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
                {{ $documento->odescripcion }}.
                <br>AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
            </p>
            <div class="container">
            <div class="row">
                <div class="col-sm">
                    <x-adminlte-button  label="AGREGAR SERVIDOR PÚBLICO COMISIONADO" 
                                        data-toggle="modal" 
                                        data-target="#modalCustom" 
                                        class="btn btn-outline-info btn-sm btn-block"/>
                </div>
                <div class="col-sm">
                    <form   name="FrmCartel" id="FrmCartel" method="post" 
                            action="{{ route('plantilla-comisionados.store') }}" >
                            @method('POST')
                            @csrf
                        <input  type="hidden" 
                                name="action" 
                                id="action"
                                value="2">
                        <input  type="hidden" 
                                name="acta" 
                                id="acta"
                                value="{{ $datosacta->id }}">
                        <button type="submit" class="btn btn-outline-warning btn-sm btn-block">
                            NO APLICA
                        </button>
                    </form>
                </div>
            </div>        
        </div>
        </x-adminlte-callout>        
        @endif

        @include('documentos.recursos-humanos.5-3.form-comisionados')
        <br>
        @if($plantillacc>0)
        <table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue">
                <tr>
                    <th>N.P.</th>
                    <th>NOMBRE DEL SERVIDOR PÚBLICO</th>
                    <th>UNIDAD DE ADSCRIPCIÓN</th>
                    <th>C.T. COMISIONADO</th>
                    <th>PERÍODO DE INICIO</th>
                    <th>PERÍODO FINAL</th>
                    <th>OFICIO DE COMISIÓN</th>
                    <th>OBSERVACIONES</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantillac as $key => $comisionado)
                <tr>
                    <td>
                        {{ $key+1 }}
                    </td>

                    <td>
                        {{ $comisionado->onombre_servidor }}
                    </td>

                    <td>
                        {{ $comisionado->ounidad_adscripcion }}
                    </td>

                    <td>
                        {{ $comisionado->ocomisionado_act }}
                    </td>

                    <td>
                        {{ $comisionado->operiodoinicio }}
                    </td>

                    <td>
                        {{ $comisionado->operiodofinal }}
                    </td>

                    <td>
                        {{ $comisionado->ooficio_autorizacion }}
                    </td>

                    <td>
                        {{ $comisionado->oobservaciones }}
                    </td>

                    <td>
                        @if($comisionado->ofinalizacion==0)
                            <x-adminlte-button  data-toggle="modal" 
                                                icon="fa fa-user-times"
                                                data-target="#modaldelete{{ $comisionado->id }}" 
                                                class="bg-danger btn-sm"/>
                            @include('documentos.recursos-humanos.5-3.form-elimina')
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

            @if($avances->oplantilla_comisionados_a==0)
            <li class="list-group-item d-flex justify-content-between align-items-center"
                style="border:none;">
                &nbsp;
                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('plantilla-comisionados.update', $datosacta->id ) }}" >
                        @method('PATCH')
                        @csrf
                    <input  type="hidden" 
                            name="acta" 
                            id="acta" |
                            value="{{ $datosacta->id }}">
                    
                    <input  type="hidden" 
                            name="actioncomisionados" 
                            id="actioncomisionados" 
                            value="2">

                    <button class="btn btn-success btn-sm"
                            style="font-size: 14px;">
                        FINALIZAR REGISTRO&nbsp;
                        <i class="fas fa-user-check"></i>
                    </button>

                </form>
            </li>
            @endif
        @endif

    
        <br>
        
    </div>
</div>
@stop