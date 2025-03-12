@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '8.3 INVENTARIO DE EXISTENCIAS EN ALMACENES')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 8.3 INVENTARIO DE EXISTENCIAS EN ALMACENES')

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
            <a  href="{{ url('/situacion-recursos-materiales') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>{{$anexo->onum_anexo.'. '.$anexo->oanexo}}</b>
            </a>&nbsp;
        </li>
        <br>
        @if($avances->oinventario_almacen_a==0)
            @include('documentos.situacion-recursos-materiales.form')
            <br>
        @endif
        
        @if($ialmacenc>0)

        <table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue ">
                <tr>
                    <th scope="col">PROG.</th>
                    <th scope="col">NOMBRE DEL DOCUMENTO</th>
                    <th scope="col">ADJUNTAR ARCHIVO</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($ialmacen as $key => $inventario)
                <tr>
                    <th scope="row" width="5%">
                        {{ $key+1 }}
                    </th>
                      
                    <td width="50%">
                        {{ $inventario->onombre_documento }}
                    </td>
                      
                    <td width="40%">
                        <a  href="storage/{{ $inventario->ourl.$inventario->oarchivo_adjunto }}"
                            target="_blank"
                            download 
                            title="{{ $inventario->oarchivo_adjunto }}">
                            {{ $inventario->oarchivo_adjunto }}
                        </a>
                    </td>
                      
                    <td width="5%">
                    @if($avances->oinventario_almacen_a==0)
                        <x-adminlte-button  data-toggle="modal" 
                                            icon="fas fa-minus"
                                            data-target="#modaldelete{{ $inventario->id }}" 
                                            class="bg-danger btn-sm"/>
                        @include('documentos.situacion-recursos-materiales.form-delete')
                    @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br>

            @if($avances->oinventario_almacen_a==0)
            <li class="list-group-item d-flex justify-content-between align-items-center"
                style="border:none;">
                &nbsp;
                <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('inventario-almacen.update', $datosacta->id ) }}" >
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
                            FINALIZAR REGISTRO DE DOCUMENTOS&nbsp;
                        <i class="fas fa-user-check"></i>
                    </button>

                </form>
            </li>
            @endif
        @endif
    </div>
</div>
@stop