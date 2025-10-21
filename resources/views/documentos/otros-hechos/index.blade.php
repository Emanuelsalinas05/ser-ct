@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '18. OTROS HECHOS (GENERALES)')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 18. OTROS HECHOS (GENERALES)')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                {{$anexo->onum_anexo.'. '.$anexo->oanexo}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/entrega-recepcion') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>ACTA DE ENTREGA-RECEPCIÓN</b>
            </a>&nbsp;
        </li>
        <br>
        <span style="font-size:14px;">Completa cada apartado y después podrás dar clic en el botón de "<b>FINALIZAR ANEXO</b>"</span>
        <br>
        <br>

        <x-adminlte-callout theme="info">
            <div class="row">
                <div class="col-sm">

                    <ul class="list-group list-group-flush"
                        style="font-size:12px;">
                    
                        @foreach($documentos as $documento)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$documento->onum_documento}} ) {{$documento->odocumento}}

                                @foreach($avanceanexos as $avance)
                                    @if($documento->oavance_documentos=='ootros_hechos_a')
                                        <a  href="{{ url($documento->ourl_documentos) }}"
                                            style="text-decoration: none; font-size:12px;" 
                                            class="btn bg-teal btn-outline-dark btn-sm ">
                                            @if($avance->ootros_hechos_a==1)
                                                Completado 
                                                <i class="fas fa-check"></i>      
                                            @else
                                                Registrar 
                                                <i class="a fa-pencil-square-o"></i>     
                                            @endif  
                                        </a>
                                    @endif
                                @endforeach
                        </li>
                        @endforeach
                        
                        @if($datosacta->avances->ootros_hechos_a==1)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        &nbsp;

                        @if($datosacta->avances->ootros_hechos_d==1)
                            <a  href="{{ url('entrega-recepcion') }}" 
                                class="btn btn-outline-success btn-sm"
                                style="font-size:14px; text-decoration: none;">
                                ANEXO <b>{{$anexo->onum_anexo.'. '.$anexo->oanexo}}</b> FINALIZADO
                            </a>
                        @else
                            <form   name="FrmCartel" id="FrmCartel" method="post" 
                                    action="{{ route('avances-anexos.update', $datosacta->id ) }}" >
                                    @method('PATCH')
                                    @csrf
                                <input  type="hidden" 
                                        name="acta" 
                                        id="acta" 
                                        value="{{ $datosacta->id }}">
                                
                                <input  type="hidden" 
                                        name="num_anexo" 
                                        id="num_anexo" 
                                        value="{{ $anexo->onum_anexo }}">

                                <button class="btn btn-success" style="font-size:14px;">
                                        FINALIZAR ANEXO <b>{{$anexo->onum_anexo.'. '.$anexo->oanexo}}</b>
                                </button>
                            </form>
                        @endif
                            
                    </li>
                    @endif

                    </ul>

                </div>
            </div>
        </x-adminlte-callout>
        
    </div>
</div>
@stop