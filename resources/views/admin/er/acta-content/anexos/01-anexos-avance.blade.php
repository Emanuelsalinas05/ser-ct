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
        <td width="90%">

                <a  href="{{ url($anexo->ourl_anexoadmin, $datosacta->id) }}" 
                    style=" color:black; text-decoration:none;"
                    title="DA CLIC PARA IR A {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}">
                        <i class="fas fa-folder-open"></i>&nbsp;
                        <b class="text-info"> {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}</b>
                        &nbsp;&nbsp;<i class="fas fa-mouse-pointer"></i>
                </a>
                <br>

                @include('admin.er.acta-content.acta.02-documentos-avance')

        </td>
        <td width="10%" align="center" valign="middle">
                <p>@include('admin.er.acta-content.acta.03-avance-check')</p>
        </td>
    </tr>
    @endforeach


@if($avanceacta->nivelavance==0)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-danger">
            <B>ANEXO ABIERTO, ¡NO SE HAN COMPLETADO!</B>
        </td>
    </tr>
@elseif($avanceacta->nivelavance>0 && $avanceacta->nivelavance<3)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-danger">
            <B>EN PROCESO DE REGISTRO DE ANEXOS</B>
        </td>
    </tr>
@elseif($avanceacta->nivelavance==3)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-success">
            <B>EN PROCESO DE CAPTURA DE DATOS DEL ACTA</B>
        </td>
    </tr>
@elseif($avanceacta->nivelavance==4)
    <tr class="shadow-sm">
        <td>
            @include('admin.er.acta-content.acta.07-aprobar-carga')
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
@elseif($avanceacta->nivelavance==5)
    <tr class="shadow-sm bg-light">
        <td colspan="2" align="center" class="text-success">
            <B>ESPERANDO LA CARGA DEL ACTA ESCANEADA Y FIRMADA</B>
        </td>
    </tr>
@elseif($avanceacta->nivelavance==6)
    <tr class="shadow-sm">
        <td colspan="2" class="bg-light">
                <x-adminlte-button  label="FINALIZAR  {{ $datosacta->tipoacta->otipoacta }}"
                                    data-toggle="modal" 
                                    data-target="#modalfinish{{ $datosacta->id }}" 
                                    class="bg-success btn-block"/>
                @include('admin.er.acta-content.acta.08-modal-concluir')
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
@elseif($avanceacta->nivelavance==7)
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
   
