<x-adminlte-callout title="NIVEL DE CUMPLIMIENTO DEL ACTA DE ENTREGA-RECEPCIÓN"
                    icon="fas fa-file-export"
                    class="text-info" >
        <span style="font-size:13px; color: black; text-align: justify;">
            <li>
                {{ $datosacta->tipoacta->odescripcion }}
            </li>
            ** SELECCIONA Y DA CLIC, SOBRE NÚMERO DE ANEXO AL CUAL QUIERAS DIRIGIRTE.  
            <br>
            COMPLETA CADA APARTADO DE LOS ANEXOS PARA CONCLUIR Y GENERAR EL: <b>{{ $datosacta->tipoacta->otipoacta }}</b>.
            <br>
            <i>CONFORME VAYAS COMPLETANDO CADA ANEXO, CON EL BOTÓN <button class="btn btn-xs btn-outline-info" disabled>VER &nbsp;<i class="fas fa-file-import" style="font-size: 14px;"></i></button> PODRÁS IMPRIMIR LOS DOCUMENTOS DEL ANEXO.</i>
        </span>
        <br><br>

        <table class="table table-sm"
                style="font-size:14px;">
        <thead class="bg-lightblue " align="center">
            <tr>
                <th>&nbsp;&nbsp;ANEXOS</th>
                <th>AVANCE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anexos as $anexo)
            <tr class="shadow-sm">
                <td width="85%">
                    <a  href="{{ url($anexo->ourl_anexo) }}" 
                        style=" color:black; text-decoration:none;"
                        title="DA CLIC PARA IR A {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}">
                        <i class="fas fa-folder-open"></i>&nbsp;
                        <b class="text-info"> {{ $anexo->onum_anexo }}. {{ $anexo->oanexo }}</b>
                        &nbsp;&nbsp;<i class="fas fa-mouse-pointer"></i>
                    </a>
                    <br>
                    @include('livewire.datos-acta.print-report')

                </td>
                <td width="15%" align="center" valign="middle">
                    <p>
                        @include('livewire.datos-acta.content-avance')
                    </p>
                </td>
            </tr>
            @endforeach
            @if($avance->completado)
            <tr>
                <td class="bg-lightblue disabled" colspan="2">
                    <b>
                        REGISTRA LOS DATOS PARA GENERAR EL {{ $datosacta->tipoacta->otipoacta }} 
                    </b>
                </td>
            </tr>
            <tr>
                <td>
                    @if($avance->oestado==0)
                    <a  href="{{ route('datos-acta.edit', $datosacta->id) }}"
                        class="text-info"
                        style="text-decoration: none;">
                        <i class="fa fa-edit" style="font-size:18px;"></i>
                        <b>REGISTRAR DATOS PARA EL ACTA </b>
                    </a>
                    @else
                    <span  class="text-info" >
                        <i class="fa fa-edit" style="font-size:18px;"></i>
                        <b> DATOS PARA EL ACTA REGISTRADOS</b>
                    </span>
                    @endif
                </td>
                <td>
                    @if($avance->oestado==1)
                        @if($datosacta->id_tipoacta==1)
                        <a  href="reportes/print-acta.php?i1d3={{$datosacta->id}}"
                            target="_blank" 
                            class="btn btn-outline-info btn-sm "
                            style="text-decoration: none;">
                            VER ACTA&nbsp;&nbsp;
                            <i class="fa fa-file" style="font-size:16px;"></i>
                        </a>
                        @elseif($datosacta->id_tipoacta==2)
                        <a  href="reportes/print-actac.php?i1d3={{$datosacta->id}}"
                            target="_blank" 
                            class="btn btn-outline-info btn-sm "
                            style="text-decoration: none;">
                            VER ACTA CIRCUNSTANCIADA&nbsp;&nbsp;
                            <i class="fa fa-file" style="font-size:16px;"></i>
                        </a>
                        @endif
                    @elseif($avance->oestado==0)
                        <span style="font-size:12px; color:orange;">
                            DEBE REGISTRAR LOS DATOS
                        </span>
                    @endif
                </td>
            </tr>
            @endif
        </tbody>
        </table>
</x-adminlte-callout>