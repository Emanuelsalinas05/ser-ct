@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUD DE INTERVENCIÓN PARA E-R')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUD DE INTERVENCIÓN PARA E-R')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp;
                SOLICITUD DE INTERVENCIÓN PARA E-R 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >



        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">

            @if(Auth::user()->orol==2)
                    <x-adminlte-button  data-toggle="modal" 
                                        icon="fa fa-edit"
                                        label="SOLICITAR INTERVENCIÓN"
                                        data-target="#modaldeletefile" 
                                        class="bg-success btn-sm"/>
                    
                    <!--
                     <a  href="reportes/intervencion.php"
                        class="btn btn-outline-info "
                        target="_blank"
                        style="font-size:12px;">
                        VER REPORTE    &nbsp;
                        <i class="fa fa-file-alt"></i>
                    </a>
                    -->
                    @if($intervencionesc>0)

                        @if(Auth::user()->ocargo=='SUBDIRECCIÓN' || Auth::user()->ocargo=='DEPARTAMENTO')
                            <x-adminlte-button  data-toggle="modal" 
                                            icon="fa fa-edit"
                                            label="GENERAR REPORTE "
                                            data-target="#modalgenera" 
                                            class="bg-info btn-sm"/>
                            @include('adg.intervenciones.modal-genera')
                        @endif

                    @else
                    &nbsp;
                    @endif
            @endif

        </li>
        @include('adg.intervenciones.modal')
        <br>


        <li class=" d-flex justify-content-between align-items-center"
            style="border:none; font-size: 12px;">
            &nbsp;
            <i>
                ***AL GENERAR EL REPORTE, LOS REGISTROS LISTADOS A CONTINUACIÓN SE GUARDARAN EN UN ARCHIVO EN FORMATO PDF, 
                DISPONIBLE PARA SU DESCARGA AQUI&nbsp;
                <a href="{{ route('reportes-intervencion.edit', Auth::user()->id_ct ) }}"
                    class="btn btn-outline-info btn-sm"
                    style="font-size:12px;">
                    VER REPORTES&nbsp;
                    <i class="fa fa-file-export"></i>
                </a>
            </i>
        </li>
        <br>
        <br>

        @if($intervencionesc>0)
        <table  class="table table-sm table-striped table-bordered"
                style="font-size:12px;"
                id="example13">
            <thead  class="bg-lightblue disabled"
                    align="center">
                <tr>
                    <th>UNIDAD ADMINISTRATIVA </th>
                    <th>TITULAR</th>
                    <th>FECHA INTERV.</th>
                    <th>C.T. A ENTREGAR</th>
                    <th>FECHA ENTREGA DEL CT</th>
                    <th>OFICIO</th>
                    <th>ENTREGA / RECIBE</th>
                    <th>MOTIVO</th>
                    @if(Auth::user()->orol==2 )<th colspan="2">EDITAR</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($intervenciones as $key => $i)
                <tr>
                    <td width="20%">
                        {{ $i->oct_nivel.' - '.$i->onivel_educativo }}
                    </td>

                    <td width="15%">
                        {{ $i->otitular_nivel }}
                    </td>

                    <td align="center"
                        width="10%">
                        {{ $i->fechacreacion }}
                    </td>

                    <td width="20%" style="font-size:12px;">
                        <b>{{ $i->oclave  }}</b> - {{ $i->onombrect }}
                        <br>
                        {{ $i->odomicilio }}
                    </td>

                    <td align="center"
                        width="10%">
                        {{ $i->fechaentrega }}<br>{{  $i->ohora_entrega.' HRS.' }}
                    </td>

                    <td width="10%"
                        align="center">
                        {{ $i->ooficio }}
                    </td>


                    <td width="15%" 
                        style="font-size:10px;">
                        <b>Entrega</b>: {{ $i->oentrega }}
                        <br>
                        <b>Recibe</b>: {{ $i->orecibe }}
                    </td>

                    <td width="15%" 
                        style="font-size:10px;">
                        {{ $i->omotivo }}
                    </td>

                    @if(Auth::user()->orol==2)
                    <td width="5%">
                        <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-edit"
                                    data-target="#modaldedit{{ $i->id }}" 
                                    class="bg-info btn-xs"/>
                        @include('adg.intervenciones.modal-edit')
                    </td>
                    <td width="5%">
                        <x-adminlte-button  data-toggle="modal" 
                                    icon="fa fa-minus"
                                    data-target="#modaldeditxxx{{ $i->id }}" 
                                    class="bg-danger btn-xs"/>
                        @include('adg.intervenciones.modal-delete')
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <center>
                <h3><b class="text-warning">AÚN NO HAY REGISTRO DE INTERVENCIONES</b></h3>
            </center>
        @endif

    </div>
</div>
@stop