@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REPORTES DE INTERVENCIONES ')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTES DE INTERVENCIONES ')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp;
                REPORTES DE INTERVENCIONES  
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >



        
        @if($intervencionesc>0)

        
            <table class="table table-sm">
                <tr>
                    <td class="bg-light"
                        align="right">
                        <b class="text-info">SELECCIONA EL PERIODO DEL REPORTE</b>
                    </td>
                    <td>
                        <form   action="https://entregasrecepcion.seiem.gob.mx/reportes/intervencion-general.php"
                                target="_blank"
                                method="get" 
                                >
                            <select class="form-control form-control-sm"
                                    id="f3ch4"
                                    name="f3ch4" required>
                                    <option value="" selected disabled> -- SELECCIONA EL PERÍODO -- </option>
                                @foreach($getmensual as $key => $gm)
                                    <option value="{{ $gm->fecha }}">{{ $gm->fecha }}</option>
                                @endforeach
                            </select> 
                            <button class="btn btn-outline-info btn-sm"  >
                                CONSULTAR REPORTE
                                <i class="fa fa-file-export"></i>
                            </button> 
                        </form>
                    </td>
                </tr>
            </table>                          
        </form>  
        <br>    


        <table  class="table table-sm  table-striped table-bordered"
                style="font-size:12px;" >
            <thead  class="bg-lightblue disabled"
                    align="center">
                <tr>
                    <th>UNIDAD ADMINISTRATIVA </th>
                    <th>CANTIDAD DE CT</th>
                    <th>FECHA DEL REPORTE </th>
                    <th>FORMATO GENERADO (SIN FIRMA)</th>
                    <th>FORMATO ESCANEADO</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($intervenciones as $key => $i)
                <tr>
                    <td width="50%" >
                        {{ $i->oct_nivel.' - '.$i->onivel_educativo }}
                    </td>

                    <td width="10%"
                        align="center">
                        {{ $i->totalct }}
                    </td>

                    <td width="10%"
                        align="center">
                        {{ $i->fechafin }}
                    </td>

                    <td width="20%"
                        align="center">
                        <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/intervencionx.php?id3p={{ $i->idct_departamento }}&f3c4={{ $i->ofechafin }}"
                            class="btn btn-outline-info btn-xs"
                            target="_blank"
                            style="font-size:12px;">
                            VER     &nbsp;
                            <i class="fa fa-file-alt"></i>
                        </a>
                    </td>

                    <td width="15%"
                        align="center">
                            <a  href="https://entregasrecepcion.seiem.gob.mx/{{ $i->ourl }}"
                                class="btn btn-outline-dark btn-xs"
                                target="_blank"
                                style="font-size:12px;">
                                VER     &nbsp;
                                <i class="fa fa-file"></i>
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