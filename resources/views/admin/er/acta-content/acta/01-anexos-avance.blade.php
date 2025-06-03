<table class="table table-sm"
        style="font-size:14px;">
<thead align="center">
    <tr class="bg-lightblue " >
        <th colspan="2">
                NIVEL DE CUMPLIENTO DE: &nbsp;
                <b>{{$datosacta->elct->oclave}} - {{$datosacta->elct->onombre_ct}}</b>
                &nbsp;&nbsp;&nbsp;
                {{ $avance->oestado==1 ? '(ACTA GENERADA)' : '(EN PROCESO)' }}
        </th>
    </tr>
    <tr class="bg-lightblue disabled" >
        <th>&nbsp;&nbsp;ANEXOS</th>
        <th>AVANCE</th>
    </tr>
</thead>
<tbody>
    @foreach($anexos as $anexo)
    <tr class="shadow-sm">
        <td width="85%">

                <a  href="{{ url($anexo->ourl_anexoadmin, $datosacta->id) }}" 
                    style=" color:black; text-decoration:none;"
                    title="DA CLIC PARA IR A {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}">
                        <i class="fas fa-folder-open text-warning"></i>&nbsp;
                        <b class="text-info"> {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}</b>
                        &nbsp;&nbsp;<i class="fas fa-mouse-pointer"></i>
                </a>
                <br>

                @include('admin.er.acta-content.acta.02-documentos-avance')

        </td>
        <td width="15%" align="center" valign="middle">
                <p>@include('admin.er.acta-content.acta.03-avance-check')</p>
        </td>
    </tr>
    @endforeach


@if($avance->nivelavance==0)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-danger">
            <h2><b>¡¡ANEXO ABIERTO!! (DEBE FINALIZAR REGISTRO Y CONCLUIR ANEXO)</b></h2>
        </td>
    </tr>
@elseif($avance->nivelavance>0 && $avance->nivelavance<3)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-danger">
            <B>EN PROCESO DE REGISTRO DE ANEXOS</B>
        </td>
    </tr>
@elseif($avance->nivelavance==3)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-warning">
            <h2><b>EN PROCESO DE CAPTURA DE DATOS PARA ACTA</b></h2>
        </td>
    </tr>
@elseif($avance->nivelavance==4)
    <tr class="shadow-sm">
        <td>
            @if(Auth::user()->onivel=='ELEMENTAL')
                @include('admin.er.acta-content.acta.07-aprobar-carga')
            @endif
        </td>
        <td >
            @if($datosacta->id_tipoacta==1)
                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-acta.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-info btn-sm btn-block"
                        style="text-decoration: none; font-size:14px;">
                        FORMATO DE ACTA&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @elseif($datosacta->id_tipoacta==2)
                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-actac.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-info btn-sm btn-block"
                        style="text-decoration: none; font-size:14px;">
                        FORMATO DE ACTA&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="2">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header">
                            <a  class="card-link text-info" 
                                data-toggle="collapse" 
                                href="#collapse{{ $datosacta->id_tipoacta }}"
                                style="font-size: 13px; text-decoration: none;">
                                    <i class="fa fa-mouse-pointer"></i>
                                    (DA CLIC AQUÍ PARA VER LA INFORMACIÓN COMPLETA 
                                    <b>DEL {{$datosacta->tipoacta->otipoacta}}</b>)
                            </a>
                        </div>
                        <div id="collapse{{ $datosacta->id_tipoacta }}" 
                             class="collapse " 
                             data-parent="#accordion">
                            <div class="card-body">
                                    @if($datosacta->id_tipoacta==1)
                                            @include('admin.er.acta-content.acta.00-er')
                                    @elseif($datosacta->id_tipoacta==2)
                                            @include('admin.er.acta-content.acta.00-ac')
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
        </td>
    </tr>
@elseif($avance->nivelavance==5)
    <tr class="shadow-sm bg-light">
        <td align="center" class="text-success">
            <B>ESPERANDO LA CARGA DEL ACTA ESCANEADA Y FIRMADA</B>
        </td>
        <td align="center">
            @if($datosacta->id_tipoacta==1)
                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-acta.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm "
                        style="text-decoration: none; font-size:14px;">
                        FORMATO DE ACTA&nbsp;&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @elseif($datosacta->id_tipoacta==2)
                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-actac.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm "
                        style="text-decoration: none; font-size:14px;">
                        FORMATO DE ACTA&nbsp;&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @endif
        </td>
    </tr>
@elseif($avance->nivelavance==6||$avance->nivelavance==7)
    
    <tr>
        <td class="bg-light" colspan="2">

            @if($datosacta->id_tipoacta==1)
                <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-acta.php?i1d3={{$datosacta->id}}"
                    target="_blank" 
                    class="btn btn-outline-info btn-sm "
                    style="text-decoration: none; font-size:14px;">
                    FORMATO DE ACTA&nbsp;&nbsp;
                    <i class="fa fa-file" style="font-size:16px;"></i>
                </a>
            @elseif($datosacta->id_tipoacta==2)
                <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-actac.php?i1d3={{$datosacta->id}}"
                    target="_blank" 
                    class="btn btn-outline-info btn-sm "
                    style="text-decoration: none; font-size:14px;">
                    FORMATO DE ACTA&nbsp;&nbsp;
                    <i class="fa fa-file" style="font-size:16px;"></i>
                </a>
            @endif

            @if($datosacta->ocargaacta=1)
            &nbsp;&nbsp;&nbsp;
            <a  href="https://entregasrecepcion.seiem.gob.mx/storage/{{ $datosacta->ourl_acta }}"
                target="_blank" 
                class="btn btn-outline-info btn-sm "
                title="{{ $datosacta->tipoacta->otipoacta }} FIRMADA Y ESCANEADA" 
                style="text-decoration: none; font-size:14px;">
                ACTA FIRMADA/ESCANEADA &nbsp;&nbsp;
                <i class="fa fa-file-alt" style="font-size:16px;"></i>
            </a>
            @endif
        </td>
    </tr>

    @if($avance->ocargacomprimido==0)
    
    <tr class="shadow-sm">
        <td class="bg-info" colspan="2">
            <center >
                <b style="font-size:18px;">
                    EN ESPERA DE CARGA Y ENVÍO DE LA CARPETA FINAL DE ARCHIVOS
                </b>
            </center>
        </td>
    </tr>


    @elseif($avance->ocargacomprimido==1)
    <tr class="shadow-sm">
        <td class="bg-light"   
            colspan="2">
                <b  class="text-success" 
                    style="font-size:16px;">
                    SE CARGO Y SE ENVÍO LA CARPETA FINAL
                </b>
                &nbsp;&nbsp;&nbsp;
                <a  href="https://entregasrecepcion.seiem.gob.mx/storage/{{ $datosacta->ourlcarpeta.'/'.$datosacta->onombrecarpeta }}"
                    target="_blank"
                    download 
                    style="text-decoration:none;" 
                    class="btn btn-outline-info btn-sm">
                    DESCARGAR CARPETA <i class="fas fa-file-archive" style="font-size:18px;"></i> 
                </a>
        </td>
    </tr>


    <tr class="shadow-sm">
        <td class="bg-light">
                <x-adminlte-button  label="FINALIZAR  {{ $datosacta->tipoacta->otipoacta }}"
                                    data-toggle="modal" 
                                    data-target="#modalfinish{{ $datosacta->id }}" 
                                    class="bg-success btn-block"/>
                @include('admin.er.acta-content.acta.08-modal-concluir')
        </td>
        <td >
            
        </td>
    </tr>
    @endif

@elseif($avance->nivelavance==8)
    <tr class="shadow-sm">
        <td class="bg-light">
            <center >
                <b  class="text-success"
                    style="font-size:18px;">
                    SE CONCLUYÓ&nbsp;{{ $datosacta->tipoacta->otipoacta }}  
                </b>
            </center>
        </td>
        <td align="center">
            @if($datosacta->id_tipoacta==1)
                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-acta.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm "
                        style="text-decoration: none; font-size:12px;">
                        ACTA&nbsp;&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @elseif($datosacta->id_tipoacta==2)
                    <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/print-actac.php?i1d3={{$datosacta->id}}"
                        target="_blank" 
                        class="btn btn-outline-success btn-sm "
                        style="text-decoration: none; font-size:12px;">
                        ACTA&nbsp;&nbsp;
                        <i class="fa fa-file" style="font-size:16px;"></i>
                    </a>
            @endif
        </td>
    </tr>
@endif

</tbody>
</table>
   
