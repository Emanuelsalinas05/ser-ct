@extends('layouts.app')
@php($dat=2)
{{-- Customize layout sections --}}
@section('title', 'SOLICITUDES EMITIDAS DE CERTIFICADOS DE NO ADEUDO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUDES EMITIDAS DE CERTIFICADOS DE NO ADEUDO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-copy"></i>&nbsp;
                SOLICITUDES EMITIDAS DE CERTIFICADOS DE NO ADEUDO
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >
        
        <ul>
            <li>
                <i>Los registros mostrados a continuación han sido reportados por la DEE a la CAOE, por lo que la liberación y emisión de los Certificados de No Adudos se realizarán conforme a las acciones y procedimientos considerados por la CAOE.</i>
            </li>
        </ul>
        
        @if( $solicitudesc>0 )
        <table class="table table-sm table-hover table-striped"
                style="font-size:12px;" id="example13">
            <thead class="bg-lightblue">
                <tr align="center">
                    <th> </th>
                    <th> DIRECCIÓN</th>
                    <th> ADG</th>
                    <th> CENTRO DE TRABAJO <br>QUE SE ENTREGA</th>
                    <th> SERVIDOR PÚBLICO <br>QUE SALE </th>
                    <th> OFICIO ADG</th>   
                    <th colspan="2">    </th>       
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $key => $solicitud)
                <tr>
                    <td width="3%" 
                        align="right">
                            {{ $key+1 }}
                    </td>

                    <td width="10%"
                        align="center">
                        {{  $solicitud->odir }}
                    </td>

                    <td width="20%">
                        {{  $solicitud->id_dep>0 ? $solicitud->titulardep->oclave.' - '.$solicitud->titulardep->onombre_ct : $solicitud->titularsub->oclave.' - '.$solicitud->titularsub->onombre_ct }}
                    </td>

                    <td width="15%">
                            <b>{{ $solicitud->acta->oct_a.' - '.$solicitud->acta->onombre_ct_a }}</b>
                    </td>

                    <td width="15%">
                            {{ $solicitud->acta->onombre_entrega_a }}
                            <br>
                            <b>RFC:</b> {{ $solicitud->acta->orfc_entrega_a }}
                    </td>

                    <td width="10%" 
                        align="center"> 
                        {{ $solicitud->oficio_adg.'/'.$solicitud->oconsecutivo_adg.'/'.$solicitud->oanio }}
                    </td>

                    <td colspan="2"
                        align="{{ Auth::user()->orol==99 ? 'left' : 'center' }}">
                    @if(Auth::user()->orol==99)

                            @if($solicitud->ocaoe==1)
                                <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-certificado-noadeudo.php?i1d3={{ $solicitud->idsol  }}" 
                                    class="btn btn-outline-dark btn-sm"
                                    target="_blank" style="font-size:12px;">
                                    VER OFICIO <i class="fa fa-file-export"></i>
                                </a>
                            @elseif($solicitud->ocaoe==0)
                                <form   name="FrmCartel{{ $solicitud->idsol }}" 
                                    id="FrmCartel{{ $solicitud->idsol }}" 
                                    method="post" 
                                    action="{{ route('certificados-emitidos.update', $solicitud->id ) }}" >
                                    @method('PATCH')
                                    @csrf
                                    <table class="table table-sm">
                                        <tr>
                                            <td align="right"
                                                class="text-info">
                                                <b>Consecutivo oficio</b>:
                                            </td>
                                            <td width="40%"> 
                                                    <input  type="text" 
                                                            name="oficio"
                                                            class="form-control form-control-sm"
                                                            required 
                                                            value="{{ old('oficio') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right"
                                                class="text-info">
                                                <b>Rubrica</b>:
                                            </td>
                                            <td width="40%">
                                                   <input   type="text" 
                                                            name="orubrica"
                                                            class="form-control form-control-sm"
                                                            required 
                                                            value="{{ old('orubrica') }}">
                                            </td>  
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <button  class="btn btn-success btn-sm btn-block">
                                                    <i class="fa fa-file-export"></i>APROBAR
                                                </button>
                                                
                                            </td> 
                                        </tr>
                                    </table>    
                                </form>
                            @endif
                    @else
                        <b class="text-info">TURNADO A CAOE</b>
                    @endif
                    </td>                 
                </tr>
                
                @endforeach
            </tbody>
        </table>
        @else
            <center>
                <h3><b class="text-warning">AÚN NO HAY REGISTROS DE SOLICITUDES</b></h3>
            </center>
        @endif


    </div>
</div>
@stop