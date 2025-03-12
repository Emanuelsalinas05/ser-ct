@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '1. MARCO JURÍDICO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 1. MARCO JURÍDICO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                1. MARCO JURÍDICO
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >
        
        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/entrega-recepcion') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>ACTO DE ENTREGA-RECEPCIÓN</b>
            </a>&nbsp;
        </li>

        <br>
        @if($avances->omarco_juridico_a==0)
            @include('documentos.marco-juridico.form-juridico')
        @endif


        @if($getjuridico>0)
            @if($avances->omarco_juridico_d==0)
                <li class="list-group-item d-flex justify-content-between align-items-center"
                    style="border:none;">
                    &nbsp;
                    <x-adminlte-button  data-toggle="modal" 
                                        label='FINALIZAR REGISTROS DE MARCO JURÍDICO'
                                        icon="fas fa-check"
                                        data-target="#finaliza" 
                                        class="bg-success btn-sm"/>
                    @include('documentos.marco-juridico.form-finaliza')
                </li>
                <br><br>
            @else
                <x-adminlte-callout>
                    <p style="font-size:13px; text-align: justify;">
                        <i class="fa fa-info-circle"></i>&nbsp;
                        {{ $documento->odescripcion }}
                    </p>
                </x-adminlte-callout><br>
            @endif
            

            <table  class="table table-striped table-hover table-sm"
                    id="example13"
                    style="font-size:12px;">
                <thead class="bg-lightblue" >
                    <tr>
                        <th>PROG.</th>
                        <th>DENOMINACIÓN DEL ORDENAMIENTO JURÍDICO-ADMINISTRATIVO</th>
                        <th>MEDIO OFICIAL <br>DE PUBLICACIÓN</th>
                        <th>FECHA <br>DE PUBLICACIÓN </th>
                        <th>URL ORDENBAMIENTO</th>
                        @if($avances->omarco_juridico_a==0)
                        <th colspan="2"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($juridicos as $key => $juridico)
                    <tr>
                        <td width="3%" align="right">
                                {{ $key+1 }} 
                        </td>
                        
                        <td width="50%">
                                {{ $juridico->odenominacion_juridica }}
                        </td>

                        <td width="20%">
                                {{ $juridico->omedio_oficial_publicacion }}
                        </td>
                        
                        <td width="10%" align="center">
                                {{ $juridico->ofecha_publicacion }}
                        </td>
                        
                        <td width="20%" align="center">
                                <a  href="{{ $juridico->ourl_publicacion }}" 
                                    target="_blank" 
                                    class="btn btn-outline-info btn-sm" 
                                    title="{{ $juridico->ourl_publicacion }}"
                                    style="font-size:12px;">
                                    CONSULTAR
                                </a>

                                <input  type="hidden" 
                                        name="txCopy{{$juridico->onprogresivo}}" 
                                        id="txCopy{{$juridico->onprogresivo}}"
                                        value="{{ $juridico->ourl_publicacion }}">

                                <button id="btnCopy{{$juridico->onprogresivo}}" 
                                        class="btn btn-outline-info btn-sm alertCopy{{$juridico->onprogresivo}}"
                                        title="Copiar URL {{ $juridico->ourl_publicacion }}">
                                        <i class="fa fa-copy"></i>
                                </button>

                                <script type="text/javascript">
                                    document.getElementById('btnCopy{{$juridico->onprogresivo}}').addEventListener('click', copiarAlPortapapeles);
                                    function copiarAlPortapapeles(ev) {
                                        // Obtener contenido del div oculto
                                        let contenido = document.getElementById('txCopy{{$juridico->onprogresivo}}').value;
                                        // Crear input
                                        let input = document.createElement('input');
                                        // Asignar contenido
                                        input.value = contenido;
                                        // Agregar input a documento
                                        document.body.appendChild(input);
                                        // Seleccionar contenido
                                        input.select();
                                        // Copiar
                                        document.execCommand('copy');
                                        // Eliminar input
                                        input.remove();
                                    }


                                    $(function () {
                                        var Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000
                                        });

                                        $('.alertCopy{{$juridico->onprogresivo}}').click(function() {
                                                Swal.fire({
                                                title: "{{ $juridico->onprogresivo.'.-  '.$juridico->odenominacion_juridica }}",
                                                text:  "Se copio la URL correctamente",
                                                icon: "info"
                                            });
                                        });
                                    });
                                </script>
                        </td>
                        @if($avances->omarco_juridico_a==0)
                        <td>
                            <x-adminlte-button  data-toggle="modal" 
                                            icon="fas fa-minus"
                                            data-target="#deletemj{{ $juridico->id }}" 
                                            class="bg-danger btn-sm"/>
                            @include('documentos.marco-juridico.form-elimina')

                        </td>
                        <td>
                            <x-adminlte-button  data-toggle="modal" 
                                            icon="fa fa-edit"
                                            data-target="#updatemj{{ $juridico->id }}" 
                                            class="bg-success btn-sm"/>
                            @include('documentos.marco-juridico.form-update')

                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <center>
                <b class="text-warning">NO HAY REGISTROS AÚN</b>
            </center>
        @endif

    </div>
</div>
@stop