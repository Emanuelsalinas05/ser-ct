<form   name="FrmCartel" id="FrmCartel" method="post" 
            action="{{ route('plantilla-personal.store') }}" >
        @method('POST')
        @csrf
        <input type="text" name="tipoplaza" value="2">
        <table class="table table-sm"
                style="font-size:12px;">
        <thead class="bg-lightblue disabled">
            <tr>
                <th>CATEGORÍA - PUESTO (PLAZAS PERSONAL ADMINISTRATIVO)</th>
                <th>TOTAL DE PLAZAS</th>
                <th>TOTAL OCUPADAS</th>
                <th>TOTAL VACANTES</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="45%">
                    <select name="ocategoriax" id="ocategoriax"
                            class="selectpicker form-control-sm" 
                            data-live-search="true" style="cursor: pointer;"  
                            data-width="100%"  
                            style="font-size: 14px;">
                        <option value="" selected >-- Selecciona la categoría --</option>
                        @foreach($plantillaad as $ppersonal)
                        <option value="{{$ppersonal->id}}" data-tokens="{{$ppersonal->oclave.' - '.$ppersonal->oclave_descripcion }}">
                            {{$ppersonal->oclave.' - '.$ppersonal->oclave_descripcion }}
                        </option>
                        @endforeach
                    </select>
                    @error('ocategoriax') <span style="color:red;">{{ $message }}</span> @enderror
                </td>

                <td width="15%">
                    <select name="ototalplazasx" id="ototalplazasx"
                            onchange="restoreex()"
                            class="form-control form-control-sm"
                            style="font-size: 14px;">
                        <option value="" selected >---- </option>
                        @for($tp=1; $tp<=100; $tp++)
                        <option value="{{$tp}}">{{ $tp }}</option>
                        @endfor
                    </select>
                    @error('ototalplazasx') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
                    
                <td width="15%">
                    <select name="ototalocupadasx" id="ototalocupadasx"
                            onchange="restaPlazasx()" 
                            class="form-control form-control-sm"
                            style="font-size: 14px;">
                        <option value="" selected >---- </option>
                        @for($tp=1; $tp<=100; $tp++)
                        <option value="{{$tp}}">{{ $tp }}</option>
                        @endfor
                    </select>
                    @error('ototalocupadasx') <span style="color:red;">{{ $message }}</span> @enderror
                </td>

                <td width="15%">
                    <input  type="hidden" 
                            name="ototalvacantesx" id="ototalvacantesx"
                            class="form-control form-control-sm" />
    
                    <input  type="text" 
                            name="ototalvacantesxx" id="ototalvacantesxx"
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
