<table  class="table table-sm table-striped "
        style="font-size:12px;">
    <thead class="bg-lightblue">
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
            <th></th>
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
            <td>
                @if($plantilla->ofinalizacion==0)
                    <x-adminlte-button  data-toggle="modal" 
                                        icon="fa fa-user-times"
                                        data-target="#modaldelete{{ $plantilla->id }}" 
                                        class="bg-danger btn-sm"/>
                    @include('documentos.recursos-humanos.5-1.form-elimina')
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>