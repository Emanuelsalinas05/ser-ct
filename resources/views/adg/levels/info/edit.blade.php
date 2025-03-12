@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUD DE INTERVENCIÓN POR DEPARTAMENTO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUD DE INTERVENCIÓN POR DEPARTAMENTO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp;
                SOLICITUD DE INTERVENCIÓN POR DEPARTAMENTO 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/reportes-niveles') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER  &nbsp; 
            </a>&nbsp;
        </li>
        <br>
        
        @if($intervencionesc>0)
        <table  class="table table-sm col-sm-6 table-striped table-bordered"
                style="font-size:12px;" >
            <thead  class="bg-lightblue disabled"
                    align="center">
                <tr>
                    <th>FECHA DEL REPORTE </th>
                    <th>FORMATO GENERADOO (SIN FIRMA)</th>
                    <th>FORMATO ESCANEADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($intervenciones as $key => $i)
                <tr>
                    <td width="10%"
                        align="center">
                        {{ $i->fechaentrega }}
                    </td>

                    <td width="10%"
                        align="center">

                        <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/intervencionx.php?id3p={{ $i->idct_departamento }}&f3c4={{ $i->ofechafin }}"
                            class="btn btn-outline-info btn-xs"
                            target="_blank"
                            style="font-size:12px;">
                            VER  &nbsp;
                            <i class="fa fa-file-alt"></i>
                        </a>

                    </td>

                    <td width="10%"
                        align="center">
                        <a  href="https://entregasrecepcion.seiem.gob.mx/{{ $i->ourl }}"
                            class="btn btn-outline-success btn-xs"
                            target="_blank"
                            style="font-size:12px;">
                            VER &nbsp;
                            <i class="fa fa-file-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <center>
                <h3><b class="text-warning">AÚN NO HAY REPORTES DE INTERVENCIONES</b></h3>
            </center>
        @endif

        


           
        

    </div>
</div>
@stop