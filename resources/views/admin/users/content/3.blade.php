@foreach($ussec as $key => $sec)
    <tr>
        <td width="60%">{{ $sec->ussec->oct.' - '.$sec->ussec->name }}</td>
        <td align="center" width="15%">{{ $sec->ussec->email }}</td>
        <td align="center" width="15%">{{ $sec->ussec->opwd }}</td>
        <td align="center" width="5%"> 
            <a  href="{{ route('usuarios.edit', $sec->ussec->id) }}"
                class="btn btn-outline-dark btn-xs" 
                    style="font-size: 12px;">
                VER
            </a>
        </td>
    </tr>
@endforeach

@foreach($ussup as $key => $sup)
    <tr>
        <td width="60%">{{ $sup->ussup->oct.' - '.$sup->ussup->name }}</td>
        <td align="center" width="15%">{{ $sup->ussup->email }}</td>
        <td align="center" width="15%">{{ $sup->ussup->opwd }}</td>
        <td align="center" width="5%"> 
            <a  href="{{ route('usuarios.edit', $sup->ussup->id) }}"
                class="btn btn-outline-dark btn-xs" 
                    style="font-size: 12px;">
                VER
            </a>
        </td>
    </tr>
@endforeach

@foreach($usct as $key => $ct)
    <tr>
        <td width="60%">{{ $ct->usct->oct.' - '.$ct->usct->name }}</td>
        <td align="center" width="15%">{{ $ct->usct->email }}</td>
        <td align="center" width="15%">{{ $ct->usct->opwd }}</td>
        <td align="center" width="5%"> 
            <a  href="{{ route('usuarios.edit', $ct->usct->id) }}"
                class="btn btn-outline-dark btn-xs" 
                    style="font-size: 12px;">
                VER
            </a>
        </td>
    </tr>
@endforeach