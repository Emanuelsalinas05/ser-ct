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