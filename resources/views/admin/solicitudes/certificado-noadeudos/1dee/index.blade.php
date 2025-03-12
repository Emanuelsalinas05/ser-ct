@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUDES EN GESTIÓN Y/O EMISIÓN DE CERTIFICADOS DE NO ADEUDO')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUDES EN GESTIÓN Y/O EMISIÓN DE CERTIFICADOS DE NO ADEUDO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-export"></i>&nbsp;
                SOLICITUDES EN GESTIÓN Y/O EMISIÓN DE CERTIFICADOS DE NO ADEUDO
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="font-size:14px;">
        
            <!-- <li> Estas solicitudes se han aprobado, quedando en espera del Certificado de No Adeudo emitido por la Coordinación Académica y de Operación Educativa. </li>
            <li>Las siguientes solicitudes se han generado, para aprobar la gestión del Certificado de No Adeudo, vía estructura, ante la Coordinación Académica y de Operación Educativa.</li>   
             -->

        @if( Auth::user()->onivel='DIRECCIÓN' && Auth::user()->orol==1 && $solicitudesc>0 )
        <!--
            <a  class="btn btn-success btn-sm" 
                href="{{ route('file-export') }}">
                Exportar registros en excel 
                &nbsp;<i class="far fa-file-excel" style="font-size: 18px;"></i>&nbsp;
            </a>
            <br>
            <br>
        -->
        @endif


        @if( $solicitudesc>0 )  

          
        <p>
            <i>
                El formato de oficio está disponible para su descarga en la columna "FORMATO DE OFICIO" que deberás descargarlo para firmar, selllar y subirlo escaneado para que la DEE realice las acciones correspondientes para que se gestionen y emitan los certificadoe de no adeudos
            </i>
        </p>
    
    @if(Auth::user()->ocargo=='DIRECCIÓN')
        @if($solicitudesg->ofile_adg==1 && $solicitudesg->oconsecutivo_dee==NULL )
            <li class=" d-flex justify-content-between align-items-center"
                style="border:none;">
                <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-plus"
                                    label="GENERAR REPORTE DE OFICIO PARA LA CAOE "
                                    data-target="#modaldee" 
                                    class="bg-warning btn-sm"/>
                &nbsp;
            </li>
            @include('admin.solicitudes.certificado-noadeudos.1dee.modal-dee')
            <br>
        @elseif($solicitudesg->ofile_adg==1 && $solicitudesg->oconsecutivo_dee!=NULL )
            <table class="table table-sm">
                <tr>
                    <td colspan="2">
                        Primero descarca el reporte de oficio en el botón de "<b>REPORTE DE CERTIFICADOS</b>.." y después sube el oficio (firmado y sellado) escaneado en formato PDF 
                    </td>
                </tr>
                <tr>
                    <td colspan="30%">
                        <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/solicituddee.php" 
                            target="_blank" 
                            class="btn bg-info btn-sm" 
                            style="font-size: 14px;">
                            REPORTE DE CERTIFICADOS DE NO ADEUDOS
                            &nbsp;<i class="fa fa-file-export"></i>
                        </a>
                    </td>
                    <td colspan="70%"></td>
                </tr>
                <tr>
                    <td colspan="30%">
                        <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-file-export"
                                    label="SUBIR OFICIO ESCANEADO"
                                    data-target="#modaldee-file" 
                                    class="bg-success btn-sm"/>
                    </td>
                    <td colspan="70%"></td>
                </tr>
            </table>
            @include('admin.solicitudes.certificado-noadeudos.1dee.modal-load-file-dee')
            <br>
        @endif
    @endif


 

            <table class="table table-sm table-hover table-striped"
                    style="font-size:12px;" id="example13">
                <thead  class="bg-lightblue"
                        align="center">
                    <tr >
                        <th> UNIDAD ADMNISTRATIVA   </th>                        
                        <th> CENTROS DE TRABAJO     </th>
                        <th> FECHA DE FORMATO       </th>
                        <th> NÚMERO <br>DE OFICIO   </th>
                        <th> FORMATO <br>DE OFICIO  </th> 
                        <th> OFICIO <br>ESCANEADO   </th> 
                        <th> ESTADO SOLICITUD       </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $key => $solicitud)
                    <tr>
                        <td width="35%">
                            <b>
                            {{ $solicitud->id_dep>0 ?  $solicitud->titulardep->oclave.' - '.$solicitud->titulardep->onombre_ct : $solicitud->titularsub->oclave.' - '.$solicitud->titularsub->onombre_ct  }}
                            </b>
                        </td>

                        <td width="10%"
                            align="center">
                            {{ $solicitud->totalct }}
                        </td>

                        <td width="10%"
                            align="center">
                            {{ $solicitud->fechadg }}
                        </td>

                        <td width="15%"
                            align="center">
                            {{ $solicitud->oficio_adg.'/'.$solicitud->oconsecutivo_adg.'/'.$solicitud->oanio }}
                        </td>

                        <td width="10%"
                            align="center">
                                <form   method="post" 
                                        target="_blank"
                                        action="https://entregasrecepcion.seiem.gob.mx/reportes/solicitudadg.php">
                                    <!--
                                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/solicitudadg.php?c3t3={{ $solicitud->id_dep>0 ? $solicitud->id_dep : $solicitud->id_sub }}&f3c4={{ $solicitud->ofecha_adg }}"
                                        target="_blank"
                                        class="btn btn-sm btn-info">
                                        <i class="fa fa-file-alt"></i>
                                    </a>
                                    -->
                                        <input  type="hidden" 
                                                name="c3t3" 
                                                value="{{ $solicitud->id_dep>0 ? $solicitud->id_dep : $solicitud->id_sub }}"> 

                                        <input  type="hidden" 
                                                name="f3c4" 
                                                value="{{ $solicitud->ofecha_adg }}">
                                        
                                        <button class="btn btn-info btn-sm" 
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-file-alt"></i>
                                        </button>
                                </form>
                        </td>

                        <td width="10%"
                            align="center">
                            @if($solicitud->ofile_adg==0)                            
                                @if(Auth::user()->ocargo=='SUBDIRECCIÓN' || Auth::user()->ocargo=='DEPARTAMENTO')
                                    <x-adminlte-button  data-toggle="modal" 
                                                        icon="fa fa-plus"
                                                        label="SUBIR "
                                                        data-target="#modalcargaadg{{ $solicitud->ofecha_adg }}" 
                                                        class="bg-warning btn-sm"/>
                                    @include('admin.solicitudes.certificado-noadeudos.1dee.modal-load-file')
                                @else
                                    <b  class="text-danger"
                                        style="font-size:10px;">
                                        NO SE HA CARGADO
                                    </b>
                                @endif
                            @else
                                <a  href="https://entregasrecepcion.seiem.gob.mx/storage/{{ $solicitud->oruta_adg }}"
                                    target="_blank"
                                    class="btn btn-sm btn-danger">
                                    <i class="far fa-file-pdf"></i>
                                </a>
                            @endif
                        </td>

                        <td width="20%">
                            @if($solicitud->ofile_adg==1)
                                <b  class="text-success"
                                    style="font-size:10px;">
                                    @if($solicitud->odee==0) TURNADO A LA DEE @elseif($solicitud->odee==1) TURNADO A LA CAOE @endif
                                </b>
                            @elseif($solicitud->ofile_adg==0)
                                <b  class="text-info"
                                    style="font-size:10px;">
                                    SUBA EL FORMATO ESCANEADO, PARA TURNAR A LA DEE
                                </b>
                            @endif
                            </b>
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @else
                <center>
                    <h3>
                        <b class="text-warning"> AÚN NO HAY REGISTROS DE SOLICITUDES</b>
                    </h3>
                </center>
        @endif


        
    </div>
</div>
@stop



        

