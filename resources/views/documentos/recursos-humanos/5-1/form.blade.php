<x-adminlte-callout>
    <p style="font-size:12px;">
        <i class="fa fa-info-circle"></i>&nbsp;
        <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
        {{ $documento->odescripcion }}.
        <br>AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO.
    </p>
    
    <form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route('plantilla-personal.store') }}" >
        @method('POST')
        @csrf

        <input  type="hidden" 
                name="actionpers" 
                id="actionpers" 
                value="1">
                
        <input  type="hidden" 
                name="idacta" 
                id="idacta"
                value="{{ $datosacta->id }}">

        <table class="table table-sm"
                style="font-size:12px;">
        <thead class="bg-lightblue disabled">
            <tr>
                <th>CATEGORÍA - PUESTO</th>
                <th>TOTAL DE PLAZAS</th>
                <th>TOTAL  OCUPADAS </th>
                <th>TOTAL DE VACANTES</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="45%">
                    <select name="ocategoria" id="ocategoria"
                            class="selectpicker form-control-sm" 
                            data-live-search="true" style="cursor: pointer;"  
                            data-width="100%"  
                            style="font-size: 14px;">
                        <option value="" selected >-- Selecciona la categoría --</option>
                        @foreach($plantilla as $ppersonal)
                        <option value="{{$ppersonal->id}}" data-tokens="{{$ppersonal->oclave.' - '.$ppersonal->oclave_descripcion }}">
                            {{$ppersonal->oclave.' - '.$ppersonal->oclave_descripcion }}
                        </option>
                        @endforeach
                    </select>
                    @error('ocategoria') <span style="color:red;">{{ $message }}</span> @enderror
                </td>

                <td width="15%">
                    <select name="ototalplazas" id="ototalplazas"
                            onchange="restoree()"
                            class="form-control form-control-sm"
                            style="font-size: 14px;">
                        <option value="" selected disabled>---- </option>
                        @for($tp=1; $tp<=200; $tp++)
                        <option value="{{$tp}}">{{ $tp }}</option>
                        @endfor
                    </select>
                    @error('ototalplazas') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
                    
                <td width="15%">
                    <select name="ototalocupadas" id="ototalocupadas"
                            onchange="restaPlazas()" 
                            class="form-control form-control-sm"
                            style="font-size: 14px;">
                        <option value="" selected disabled>---- </option>
                        @for($tp=1; $tp<=200; $tp++)
                        <option value="{{$tp}}">{{ $tp }}</option>
                        @endfor
                    </select>
                    @error('ototalocupadas') <span style="color:red;">{{ $message }}</span> @enderror
                </td>

                <td width="15%">
                    <input  type="hidden" 
                            name="ototalvacantes" id="ototalvacantes"
                            class="form-control form-control-sm" />
    
                    <input  type="text" 
                            name="ototalvacantesx" id="ototalvacantesx"
                            style="font-size: 14px;"
                            class="form-control form-control-sm" disabled/>
                </td>
                    
                <td width="10%">
                    <button class="btn btn-outline-success" 
                            style="font-size:12px;">
                        AGREGAR <i class="fa fa-user-plus"></i>
                    </button>
                </td>
            </tr>
        </tbody>
        </table>
    </form>

</x-adminlte-callout>
