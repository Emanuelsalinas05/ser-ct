<li class=" d-flex justify-content-between align-items-center"
    style="border:none;">
    &nbsp;
    <p style="color:gray; font-size: 13px;">
        <i><b>DA CLIC EN EL SÍMBOLO DE 
        <span class="btn btn-xs bg-light" disabled><i class="fas fa-plus"></i></span> 
        PARA VER LA INFORMACIÓN COMPLETA</b></i>
    </p>
</li>


<x-adminlte-card    title="5.1  PLANTILLA DE PERSONAL AUTORIZADA (INFORMACIÓN CONCENTRADA Y GLOBAL)"             
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">
        <table  class="table table-sm table-striped "
                style="font-size:12px;">
            <thead class="bg-lightblue disabled">
                <tr>
                    <th>N.P</th>
                    <th>COD. PUESTO</th>
                    <th>NOMBRE PUESTO</th>
                    <th>NIVEL Y RANGO</th>
                    <th>NÚMERO DE PLAZAS</th>
                    <th>OCUPADAS</th>
                    <th>VACANTES</th>
                    <th>SUELDO BRUTO <br>MENSUAL INDIVIDUAL</th>
                    <th>SUELDO BRUTO <br>MENSUAL TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantillap as $key => $plantilla)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $plantilla->oclave_puesto }}</td>
                    <td>{{ $plantilla->onombre_puesto }}..</td>
                    <td align="center">{{ $plantilla->onivelrango }}</td>
                    <td align="center">{{ $plantilla->ototalplazas }}</td>
                    <td align="center">{{ $plantilla->ototalocupadas }}</td>
                    <td align="center">{{ $plantilla->ototalvacantes }}</td>
                    <td>{{ number_format($plantilla->osueldo_ind, 2) }}</td>
                    <td>{{ number_format($plantilla->osueldo_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</x-adminlte-card>


<x-adminlte-card    title="5.3  RELACIÓN DE SERVIDORES PÚBLICOS COMISIONADOS. (INFORMACIÓN CONCENTRADA Y GLOBAL)"             
                    theme="lightblue" 
                    theme-mode="outline"
                    icon="fas fa-icon fa-file-alt" 
                    header-class="text-uppercase rounded-bottom border-info"
                    collapsible="collapsed">
    	<table  class="table table-striped table-sm"
                style="font-size:12px;">
            <thead class="bg-lightblue disabled">
                <tr>
                    <th>N.P.</th>
                    <th>NOMBRE DEL SERVIDOR PÚBLICO</th>
                    <th>UNIDAD DE ADSCRIPCIÓN</th>
                    <th>C.T. COMISIONADO</th>
                    <th>PERÍODO DE INICIO</th>
                    <th>PERÍODO FINAL</th>
                    <th>OFICIO DE COMISIÓN</th>
                    <th>OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plantillac as $key => $comisionado)
                <tr>
                    <td>
                        {{ $key+1 }}
                    </td>

                    <td>
                        {{ $comisionado->onombre_servidor }}
                    </td>

                    <td>
                        {{ $comisionado->ounidad_adscripcion }}
                    </td>

                    <td>
                        {{ $comisionado->ocomisionado_act }}
                    </td>

                    <td>
                        {{ $comisionado->operiodoinicio }}
                    </td>

                    <td>
                        {{ $comisionado->operiodofinal }}
                    </td>

                    <td>
                        {{ $comisionado->ooficio_autorizacion }}
                    </td>

                    <td>
                        {{ $comisionado->oobservaciones }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</x-adminlte-card>