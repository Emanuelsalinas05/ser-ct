@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REGISTROS DE ENTREGAS-RECEPCIÓN')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REGISTROS DE ENTREGAS-RECEPCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-book"></i>&nbsp;
                REGISTROS DE ACTOS ENTREGAS-RECEPCIÓN
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <x-adminlte-callout theme="light">
    <div class="panel panel-success">
            <div class="panel-heading">buscar Noticiero</div>
            <form action="entregas-recepcion/buscar" method="get" onsubmit="return showLoad()">
            <div class="panel-body">
                <label class="label-control">Nombre del noticiero</label>
                <input type="text" name="busqueda" class="form-control" placeholder="Ingresar nombre del noticiero/descripcion" required="required">
                <br>

        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-success">buscar</button>
        </div>
        </form>
    </div>
            <table  class="table table-bordered table-striped table-sm"
                    id="example130"
                    style="font-size:12px;">
            <thead class="bg-lightblue" align="center">
                <tr>
                    <th>TIPO DE ACTA</th>
                    <th>CENTRO DE TRABAJO</th>
                    <th>SERVIDOR PÚBLICO RESPONSABLE</th>
                    <th>ESTADO</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach($datosacta as $key=> $acta)
                <tr>
                    <td width="20%">
                        {{ $acta->tipoacta->otipoacta }}
                    </td>
                    
                    <td width="30%">
                        {{ $acta->elct->oclave.' - '.$acta->elct->onombre_ct }}
                    </td>
                    
                    <td width="25%">
                        @if($acta->ock==1)
                            @if($acta->id_tipoacta==1)
                               <b>RECIBE</b>: {{ $acta->onombre_recibe_a }}
                               <br>
                               <b>ENTREGA</b>: {{ $acta->onombre_entrega_a }}
                            @elseif($acta->id_tipoacta==2)
                                <b>RECIBE</b>: {{ $acta->onombre_recibe_ac }}
                            @endif
                        @elseif($acta->ock==0)
                            ESPERANDO REGISTROS
                        @endif
                    </td>
                    
                    
                    <td width="15%" style="font-size:11px;">
                        {{ $acta->estadoacta }}
                    </td>
                    
                    <td width="10%" align="center">
                        <a  href="{{route('entregas-recepcion.edit', $acta->id)}}" 
                            class="btn btn-outline-dark btn-sm"
                            title="VER ANEXOS Y AVANCE DE: {{ $acta->elct->oclave.' - '.$acta->elct->onombre_ct }}"
                            style="text-decoration: none; font-size:12px;">
                            VER&nbsp;
                            <i class="  fas fa-folder-open"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>

            {{ $datosacta->links() }}

        </x-adminlte-callout>
        
    </div>
</div>
@stop