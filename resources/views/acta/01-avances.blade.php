<x-adminlte-callout title="NIVEL DE CUMPLIMIENTO DEL ACTO DE ENTREGA-RECEPCIÓN"
                    icon="fas fa-file-export"
                    class="text-info">

   <span style="font-size:13px; color: black; text-align: justify;">
    <li>
        {{ strtoupper($datosacta->tipoacta->odescripcion) }}
    </li>
    SELECCIONA Y DA CLIC SOBRE EL NÚMERO DEL ANEXO AL CUAL DESEAS DIRIGIRTE.
    <br>
    <ul>
        <li>
            COMPLETA CADA APARTADO DE LOS ANEXOS PARA CONCLUIR Y GENERAR EL:
            <b>{{ strtoupper($datosacta->tipoacta->otipoacta) }}</b>.
        </li>
        <li>
            <i>CONFORME VAYAS COMPLETANDO CADA ANEXO, CON EL BOTÓN&nbsp;
            <button class="btn btn-xs btn-outline-info" disabled>
                VER&nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i>
            </button>&nbsp;
            PODRÁS IMPRIMIR LOS DOCUMENTOS DEL ANEXO.</i>
        </li>
        <li class="text-warning">
            <b>
                PODRÁS CAMBIAR ENTRE ANEXOS SI ASÍ LO REQUIERES. PARA ELLO, DEBERÁS SOLICITAR SU APERTURA A TU AUTORIDAD INMEDIATA SUPERIOR.<br>
                ESTO SOLO SERÁ POSIBLE ANTES DE REGISTRAR LOS DATOS DEL ACTA. POSTERIORMENTE, NO SE PODRÁ HABILITAR LA APERTURA DE NINGÚN ANEXO.
            </b>
        </li>
    </ul>
</span>


    <table class="table table-sm" style="font-size:14px;">
        <thead class="bg-lightblue" align="center">
        <tr>
            <th>&nbsp;&nbsp;ANEXOS</th>
            <th>AVANCE</th>
        </tr>
        </thead>
        <tbody>
        @foreach($anexos as $anexo)
            <tr class="shadow-sm">
                <td width="80%">
                    <a href="{{ url($anexo->ourl_anexo) }}"
                       style="color:black; text-decoration:none;"
                       title="Da clic para ir a {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}">
                        <i class="fas fa-folder-open text-warning"></i>&nbsp;
                        <b class="text-info">{{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}</b>
                        &nbsp;&nbsp;
                        <i class="fas fa-mouse-pointer"></i>
                    </a>
                    <br>
                    @include('acta.02-print-report')
                </td>
                <td width="20%" align="center" valign="middle">
                    <div>
                        @include('acta.02-avance-content')
                    </div>
                </td>
            </tr>
        @endforeach

        @if($avance->completado)
            <tr class="shadow-sm">
                <td colspan="2">
                    @if($avance->oestado == 1)
                        <li class="d-flex align-items-center">
                            <span class="text-info">
                                <i class="fa fa-file" style="font-size:18px;"></i>&nbsp;
                                <b>FORMATO DE {{ $datosacta->tipoacta->otipoacta }}</b>
                            </span>

                            &nbsp;&nbsp;&nbsp;

                            <a href="reportes/{{ $datosacta->id_tipoacta == 1 ? 'print-acta' : 'print-actac' }}.php?i1d3={{ $datosacta->id }}"
                               target="_blank"
                               class="btn btn-outline-success btn-sm"
                               title="Ver {{ $datosacta->tipoacta->otipoacta }}"
                               style="text-decoration: none; font-size:14px;">
                                <b>VER&nbsp;&nbsp;</b>
                                <i class="fa fa-file" style="font-size:16px;"></i>
                            </a>
                        </li>
                    @elseif($avance->oestado == 0)
                        <span style="font-size:20px; color:orange;">
                            <i class="far fa-hand-paper"></i>
                        </span>
                    @endif
                </td>
            </tr>

            @if($datosacta->ocargacomprimido == 1)
                <tr class="shadow-sm">
                    <td class="bg-light" colspan="2">
                    <span class="text-info">
                        <b><i class="fas fa-file-archive" style="font-size:18px;"></i>
                        &nbsp;CARPETA FINAL DE ARCHIVOS&nbsp;&nbsp;</b>
                    </span>

                        <a href="../storage/{{ $datosacta->ourlcarpeta }}/{{ $datosacta->onombrecarpeta }}"
                           target="_blank"
                           download
                           style="text-decoration:none;"
                           class="btn btn-outline-success btn-sm">
                            <b>DESCARGAR</b>
                            <i class="fas fa-cloud-download-alt"></i>
                        </a>
                    </td>
                </tr>
            @endif

            <tr class="shadow-sm">
                <td colspan="2">
                    @include('acta.03-aprobacion-acta')
                </td>
            </tr>
        @endif

        </tbody>
    </table>
</x-adminlte-callout>
