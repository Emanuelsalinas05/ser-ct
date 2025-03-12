@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '5.1 PLANTILLA DE PERSONAL AUTORIZADA')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 5.1 PLANTILLA DE PERSONAL AUTORIZADA')

{{-- Content body: main page content --}}
@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-center">
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

        @if($avances->oplantilla_personal_a==0)

            @if(Auth::user()->onivel=='ELEMENTAL')
                @include('documentos.recursos-humanos.5-1.form')
            @elseif(Auth::user()->onivel=='SECUNDARIA')
                @include('documentos.recursos-humanos.5-1.form-sirepe')
            @endif
                
        @endif

        @if($plantillacp>0) 

            @if(Auth::user()->onivel=='ELEMENTAL')
                @include('documentos.recursos-humanos.5-1.plantilla-claves') 
            @elseif(Auth::user()->onivel=='SECUNDARIA')
                @include('documentos.recursos-humanos.5-1.plantilla-sirepe') 
            @endif
            <br>

            @if($avances->oplantilla_personal_a==0)
            <li class="list-group-item d-flex justify-content-between align-items-center"
                style="border:none;">
                &nbsp;
                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('plantilla-personal.update', $datosacta->id ) }}" >
                        @method('PATCH')
                        @csrf
                    <input  type="hidden" 
                            name="acta" 
                            id="acta" 
                            value="{{ $datosacta->id }}">
                    
                    <input  type="hidden" 
                            name="actionplantilla" 
                            id="actionplantilla" 
                            value="2">

                    <button class="btn btn-success btn-sm"
                            style="font-size: 14px;">
                        FINALIZAR REGISTRO DE PERSONAL&nbsp;
                        <i class="fas fa-user-check"></i>
                    </button>

                </form>
            </li>
            @endif

        @else
            <center>
                <b class="text-warning">AÚN NO SE HA REGISTRADO INFORMACIÓN</b>
            </center>
        @endif
        
    </div>
</div>
@stop

<script>
    function restoree()
    {
        var totalo = $('#ototalocupadas').val('');
        var totalv = $('#ototalvacantes').val('');
        var totalvx= $('#ototalvacantesx').val('');
    }



    function restaPlazas()
    {
        var totalp = parseInt($('#ototalplazas').val());
        var totalo = parseInt($('#ototalocupadas').val());

        if(totalo>totalp)
        {
            Swal.fire('aviso!', 'El total de plazas ocupadas no puede ser mayor al total de plazas', 'warning');
        
            var totalo = $('#ototalocupadas').val('');
            var totalv = $('#ototalvacantes').val('');
            var totalv = $('#ototalvacantes').val('');
            var totalvx= $('#ototalvacantesx').val('');
        
        }else if(totalo<totalp){
        
            var totalv = $('#ototalvacantes').val(totalp-totalo);
            var totalvx= $('#ototalvacantesx').val(totalp-totalo);
        
        }else if(totalp==totalo){
        
            var totalv = $('#ototalvacantes').val(0);
            var totalvx= $('#ototalvacantesx').val(0);
        }
    }
</script>