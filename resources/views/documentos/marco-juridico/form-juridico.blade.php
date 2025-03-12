<x-adminlte-callout>
    
    <p style="font-size:13px; text-align: justify;">
        <i class="fa fa-info-circle"></i>&nbsp;
        <b class="text-info">INDICACIONES PARA EL REGISTRO:</b><br>
        {{ $documento->odescripcion }}.<br>
        AL TERMINAR CON EL REGISTRO DA CLIC EN "<B>FINALIZAR REGISTRO</B>" PARA CONCLUIR ESTE APARTADO. 
    </p>
</x-adminlte-callout>


    <form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route('marco-juridico.store') }}" >
        @method('POST')
        @csrf
        <table class="table table-sm"
                style="font-size:12px;">
        <thead class="bg-light ">
            <tr class="text-info">
                <th>NOMBRE DEL ORDENAMIENTO JURÍDICO-ADMINISTRATIVO</th>
                <th>MEDIO OFICIAL DE PUBLICACIÓN</th>
                <th>FECHA DE PUBLICACIÓN </th>
                <th>LOCALIZADOR UNIFORME DE RECURSOS (URL)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="35%">
                    <input  type="text" 
                            name="oordenamiento" id="oordenamiento"
                            class="form-control form-control-sm" value="{{ old('oordenamiento') }}" />
                    @error('oordenamiento') <span style="color:red;">{{ $message }}</span> @enderror
                </td>

                <td width="15%">
                    <select class="form-control form-control-sm"
                            name="omediooficial" id="omediooficial" >
                        <option selected disabled>-- ELIJE UN MEDIO --</option>
                        <option value="DIARIO OFICIAL DE LA FEDERACIÓN">DIARIO OFICIAL DE LA FEDERACIÓN</option>
                        <option value="GACETA DEL GOBIERNO">GACETA DEL GOBIERNO</option>
                        <option value="AGENDA SEIEM">AGENDA SEIEM</option>
                    </select>
                    @error('omediooficial') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
                    
                <td width="5%">
                    <input  type="date" 
                            name="ofechapublicacion" id="ofechapublicacion"
                            class="form-control form-control-sm" value="{{ old('ofechapublicacion') }}" />
                    @error('ofechapublicacion') <span style="color:red;">{{ $message }}</span> @enderror
                </td>

                <td width="35%">
                    <input  type="text" 
                            name="olocalizador" id="olocalizador"
                            class="form-control form-control-sm" value="{{ old('olocalizador') }}" />
                    @error('olocalizador') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
                    
                <td width="10%">
                    <button class="btn btn-outline-success" 
                            style="font-size:12px;">
                        AGREGAR <i class="fa fa-edit"></i>
                    </button>
                </td>
            </tr>
        </tbody>
        </table>
    </form>
