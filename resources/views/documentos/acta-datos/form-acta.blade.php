<form   name="FrmCartel" id="FrmCartel" method="post" 
        action="{{ route('datos-acta.update', $datosacta->id ) }}"
        enctype="multipart/form-data" 
        accept="application/pdf" >
        @method('PATCH')
        @csrf

<input type="hidden" name="idacta" id="idacta" value="{{$datosacta->id}}">
<input type="hidden" name="acta_tipo" id="acta_tipo" value="{{$datosacta->id_tipoacta}}">
<input type="hidden" name="idavance" id="idavance" value="{{$avances->id}}">

<table  class="table table-sm table-hover table-striped"
        style="font-size:14px;">
<thead>
    <tr>
        <th colspan="8" class="bg-lightblue ">
            <i class="fa fa-file-alt"></i>
            CAPTURA DE DATOS PARA EL {{ $datosacta->tipoacta->otipoacta }}
            <br>VERIFICA CUIDADOSAMENTE QUE CADA DATO A REGISTRAR. 
            <span style="font-size: 12px;">* LOS DATOS SON OBLIGATORIOS</span>
        </th>
    </tr>
</thead>
<tbody>
    <tr class="bg-lightblue disabled">
        <td colspan="8"><b>LUGAR Y FECHA</b></td>
    </tr>
    <tr>
        <td align="right"><b>C.T.</b></td>
        <td>
            {{$datosacta->oct_a}}
            <input  type="hidden" name="oct_a"
                    class="form-control form-control-sm"
                    value="{{ old('oct_a', $datosacta->oct_a) }}">
        </td>

        <td align="right"><b>NOMBRE DEL C.T.</b></td>
        <td colspan="5">
            {{$datosacta->onombre_ct_a}}
            <input  type="hidden" name="onombre_ct_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_ct_a', $datosacta->onombre_ct_a) }}">
        </td>
    </tr>
    <tr>
        <td align="right"><b>* LUGAR</b></td>
        <td colspan="3" width="40%">
            <input  type="text" name="olugar_a"
                    class="form-control form-control-sm"
                    value="{{ old('olugar_a', $datosacta->olugar_a) }}">
            @error('olugar_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td align="right"><b>* HORA</b></td>
        <td>
            <input  type="time" name="ohora_inicio_a"
                    class="form-control form-control-sm"
                    value="{{ old('ohora_inicio_a', $datosacta->ohora_inicio_a) }}">
            @error('ohora_inicio_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* FECHA</b></td>
        <td>
            <input  type="date" name="ofecha_inicio_a"
                    max="{{date('Y-m-d')}}" 
                    class="form-control form-control-sm"
                    value="{{ old('ofecha_inicio_a', $datosacta->ofecha_inicio_a) }}">
            @error('ofecha_inicio_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right"><b>* DOMICILIO</b></td>
        <td colspan="5">
            <input  type="text" name="odomicilio_ct_a"
                    class="form-control form-control-sm"
                    value="{{ old('odomicilio_ct_a', $datosacta->odomicilio_ct_a) }}">
            @error('odomicilio_ct_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td colspan="2"></td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>SERVIDOR PÚBLICO QUE ENTREGA</b></td>
    </tr>
    <tr>
        <td align="right"><b>NOMBRE</b>:</td>
        <td colspan="2">
            {{$datosacta->onombre_entrega_a}}
            <input  type="hidden" name="onombre_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_entrega_a', $datosacta->onombre_entrega_a) }}">
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_entrega_a}}
            <input  type="hidden" name="orfc_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('orfc_entrega_a', $datosacta->orfc_entrega_a) }}">
        </td>
        
        <td align="right"><b>CARGO</b>:</td>
        <td colspan="2">
            {{$datosacta->ocargo_entrega_a}}
            <input  type="hidden" name="ocargo_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_entrega_a', $datosacta->ocargo_entrega_a) }}">
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_entrega_a" 
                    class="form-control form-control-sm">
                <option value="" disabled selected>-----</option>
                <option value="INE" 
                @if($datosacta->oidentificacion_entrega_a=='INE') selected @else old('oidentificacion_entrega_a') @endif>
                    INE
                </option>
                <option value="CEDULA"
                @if($datosacta->oidentificacion_entrega_a=='CEDULA') selected @else old('oidentificacion_entrega_a') @endif>CEDULA</option>
                <option value="PASAPORTE"
                @if($datosacta->oidentificacion_entrega_a=='PASAPORTE') selected @else old('oidentificacion_entrega_a') @endif>PASAPORTE</option>
            </select>
            @error('oidentificacion_entrega_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_url_entrega_a"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_url_entrega_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_entrega_a', $datosacta->onumero_identificacion_entrega_a) }}">
            @error('onumero_identificacion_entrega_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>SERVIDOR PÚBLICO QUE RECIBE</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOMBRE</b>:</td>
        <td colspan="2">
            <!--
            {{$datosacta->onombre_recibe_a}}
        -->
            <input  type="text" name="onombre_recibe_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_recibe_a', $datosacta->onombre_recibe_a) }}">
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            <!--
            {{$datosacta->orfc_recibe_a}}
        -->
            <input  type="text" name="orfc_recibe_a"
                    class="form-control form-control-sm"
                    value="{{ old('orfc_recibe_a', $datosacta->orfc_recibe_a) }}">
        </td>
        
        <td  align="right"><b>CARGO</b>:</td>
        <td colspan="2">
            {{$datosacta->ocargo_recibe_a}}
            <input  type="hidden" name="ocargo_recibe_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_recibe_a', $datosacta->ocargo_recibe_a) }}">
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_recibe_a" 
                    class="form-control form-control-sm">
                <option value="" disabled selected>-----</option>
                <option value="INE"
                @if($datosacta->oidentificacion_recibe_a=='INE') selected @else old('oidentificacion_recibe_a') @endif>
                INE</option>
                <option value="CEDULA"
                @if($datosacta->oidentificacion_recibe_a=='CEDULA') selected @else old('oidentificacion_recibe_a') @endif>
                CEDULA</option>
                <option value="PASAPORTE"
                @if($datosacta->oidentificacion_recibe_a=='PASAPORTE') selected @else old('oidentificacion_recibe_a') @endif>
                PASAPORTE</option>
            </select>
            @error('oidentificacion_recibe_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_url_recibe_a"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_url_recibe_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_recibe_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_recibe_a', $datosacta->onumero_identificacion_recibe_a) }}">
            @error('onumero_identificacion_recibe_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>TESTIGO 1</b></td>
    </tr>
    <tr>
        <td  align="right"><b>* NOMBRE</b>:</td>
        <td colspan="3">
            <input  type="text" name="onombre_testigo_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_testigo_a', $datosacta->onombre_testigo_a) }}">
            @error('onombre_testigo_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* RFC TESTIGO 1</b>:</td>
        <td colspan="2">
            <input  type="TEXT" name="orfc_testigo" maxlength="14" 
                    class="form-control form-control-sm"
                    value="{{ old('orfc_testigo', $datosacta->orfc_testigo) }}">
            @error('orfc_testigo') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td colspan="2">
        </td>
    </tr>
    <tr>
        <td  align="right"><b>* C.T.</b>:</td>
        <td colspan="5">
            <select id="oct_testigo_a" 
                    name="oct_testigo_a"
                    class="selectpicker" 
                    data-live-search="true" style="cursor: pointer;"  
                    data-width="350" 
                    title="ELIJE EL C.T. DEL TESTIGO 1">
                @foreach($centrotrabajo as $ct)
                <option value="{{$ct->oclave}}">
                    {{$ct->oclave.' - '.$ct->onombre_ct}}
                </option>
                @endforeach
            </select>
            @error('oct_testigo_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* CARGO</b>:</td>
        <td >
            <input  type="text" name="ocargo_testigo_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_testigo_a', $datosacta->ocargo_testigo_a) }}">
            @error('ocargo_testigo_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_testigo" 
                    class="form-control form-control-sm">
                <option value="" disabled selected>-----</option>
                <option value="INE"
                @if($datosacta->oidentificacion_recibe_a=='INE') selected @else old('oidentificacion_recibe_a') @endif>
                INE</option>
                <option value="CEDULA"
                @if($datosacta->oidentificacion_recibe_a=='CEDULA') selected @else old('oidentificacion_recibe_a') @endif>
                CEDULA</option>
                <option value="PASAPORTE"
                @if($datosacta->oidentificacion_recibe_a=='PASAPORTE') selected @else old('oidentificacion_recibe_a') @endif>
                PASAPORTE</option>
            </select>
            @error('oidentificacion_testigo') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_url_testigo"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_url_testigo') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_testigo_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_testigo_a', $datosacta->onumero_identificacion_testigo_a) }}">
            @error('onumero_identificacion_testigo_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>



    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>TESTIGO 2</b></td>
    </tr>
    <tr>
        <td  align="right"><b>* NOMBRE</b>:</td>
        <td colspan="3">
            <input  type="text" name="onombre_testigo2_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_testigo2_a', $datosacta->onombre_testigo2_a) }}">
            @error('onombre_testigo2_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* RFC TESTIGO 2</b>:</td>
        <td colspan="2">
            <input  type="TEXT" name="orfc_testigo2"
                    class="form-control form-control-sm" maxlength="14" 
                    value="{{ old('orfc_testigo2', $datosacta->orfc_testigo2) }}">
            @error('orfc_testigo2') <span style="color:red;">{{ $message }}</span> @enderror

        </td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td  align="right"><b>* C.T.</b>:</td>
        <td colspan="5">
            <select id="oct_testigo2_a" 
                    name="oct_testigo2_a"
                    class="selectpicker" 
                    data-live-search="true" style="cursor: pointer;"  
                    data-width="350" 
                    title="ELIJE EL C.T. DEL TESTIGO 2">
                @foreach($centrotrabajo as $ct)
                <option value="{{$ct->oclave}}">
                    {{$ct->oclave.' - '.$ct->onombre_ct}}
                </option>
                @endforeach
            </select>
            @error('oct_testigo2_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* CARGO</b>:</td>
        <td>
        <input  type="text" name="ocargo_testigo2_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_testigo2_a', $datosacta->ocargo_testigo2_a) }}">
            @error('ocargo_testigo2_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_testigo2" 
                    class="form-control form-control-sm">
                <option value="" disabled selected>-----</option>
                <option value="INE"
                @if($datosacta->oidentificacion_recibe_a=='INE') selected @else old('oidentificacion_recibe_a') @endif>
                INE</option>
                <option value="CEDULA"
                @if($datosacta->oidentificacion_recibe_a=='CEDULA') selected @else old('oidentificacion_recibe_a') @endif>
                CEDULA</option>
                <option value="PASAPORTE"
                @if($datosacta->oidentificacion_recibe_a=='PASAPORTE') selected @else old('oidentificacion_recibe_a') @endif>
                PASAPORTE</option>
            </select>
            @error('oidentificacion_testigo2') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td  align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_url_testigo2"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_url_testigo2') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_testigo2_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_testigo2_a', $datosacta->onumero_identificacion_testigo2_a) }}">
            @error('onumero_identificacion_testigo2_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>



    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>REPRESENTANTE DEL OIC Ó DE LA SECOGEM</b></td>
    </tr>
    <tr>
        <td colspan="3" align="right">
            <b>* ¿PARTICIPA ALGÚN REPRESENTANTE?</b>
        </td>
        <td colspan="5">
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="1" 
                            name="orepresentante_a"id="orepresentante_a"
                            onclick="representante(1)">SI
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="2" 
                            name="orepresentante_a"id="orepresentante_a"
                            onclick="representante(2)">NO
                </label>
            </div>
            @error('orepresentante_a') <span style="color:red;">{{ $message }}</span> @enderror
            <script type="text/javascript">
                function representante(id){
                    if(id=='1'){
                        $('#onombre_representante_contraloria_a').show();
                        $('#namerepres').show();
                        $('#reprecon').show();
                        $('#reprecon2').show();
                    }else if(id=='2'){
                        $('#onombre_representante_contraloria_a').hide();
                        $('#namerepres').hide();
                        $('#reprecon').hide();
                        $('#reprecon2').hide();
                    }
                }
            </script>
        </td>
    </tr>
    <tr id="reprecon">
        <td colspan="3" align="right"><span id="namerepres"><b>NOMBRE DEL REPRESENTANTE:</b></span></td>
        <td colspan="3">
            <input  type="text" name="onombre_representante_contraloria_a"
                    id="onombre_representante_contraloria_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_representante_contraloria_a', $datosacta->onombre_representante_contraloria_a) }}">
        </td>
        <td colspan="2"></td>
    </tr>
    <tr id="reprecon2">
        <td colspan="2" align="right"><b>* OFICIO NÚM:</b></td>
        <td>
            <input  type="text" name="ooficio_designacion_er_a"
                    id="ooficio_designacion_er_a"
                    class="form-control form-control-sm"
                    value="{{ old('ooficio_designacion_er_a', $datosacta->ooficio_designacion_er_a) }}">
            @error('ooficio_designacion_er_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* FECHA:</b></td>
        <td>
            <input  type="date" name="ofecha_ofocio_designacion_er_a"
                    id="ofecha_ofocio_designacion_er_a"
                    max="{{date('Y-m-d')}}" 
                    class="form-control form-control-sm"
                    value="{{ old('ofecha_ofocio_designacion_er_a', $datosacta->ofecha_ofocio_designacion_er_a) }}">
            @error('ofecha_ofocio_designacion_er_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td colspan="3"></td>
    </tr>
    <tr class="bg-light">
        <td colspan="8" class="text-info">
            <b>* ¿DESEA AGREGAR OTROS HECHOS?</b>&nbsp;&nbsp;&nbsp;

            <div class="form-check-inline" style="color:black;">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="1" 
                            name="ohechos_ax"id="ohechos_ax"
                            onclick="ohechos(1)">SI
                </label>
            </div>
            <div class="form-check-inline" style="color:black;">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="2" 
                            name="ohechos_ax"id="ohechos_ax"
                            onclick="ohechos(2)">NO
                </label>
            </div>
            @error('ohechos_ax') <span style="color:red;">{{ $message }}</span> @enderror
            <script type="text/javascript">
                function ohechos(id){
                    if(id=='1'){
                        $('#ohechos_a').show();
                        $('#ohechos_az').show();
                        $('#ohechos_azx').show();
                    }else if(id=='2'){
                        $('#ohechos_a').hide();
                        $('#ohechos_az').hide();
                        $('#ohechos_azx').hide();
                    }
                }
            </script>
        </td>
    </tr>
    <tr id="ohechos_az">
        <td colspan="8" id="ohechos_az">
            <textarea   name="ohechos_a" 
                        id="ohechos_a"
                        class="form-control "
                        rows="7"  
                        style="resize: none;">{{ old('ohechos_a', $datosacta->ohechos_a) }}</textarea>
        </td>
    </tr>
    <tr id="ohechos_azx">
        <td colspan="2" id="ohechos_azx">
            ADJUNTAR AQUÍ ARCHIVO DE OTROS HECHOS
        </td>
        <td colspan="6" id="ohechos_az">
            <input  type="file" name="ourl_hechos"
                    class="form-control form-ourl_hechos-sm"
                    accept="application/pdf">
        </td>
    </tr>
    <tr>
        <td colspan="3" class="text-info" align="right">
            <b>HORA Y FECHA DE FINALIZACIÓN DEL ACTA</b>
        </td>
        <td align="right">
            <b>* HORA </b>:
        </td>
        <td>
            <input  type="time" name="ohora_fin_a"
                    class="form-control form-control-sm"
                    value="{{ old('ohora_fin_a', $datosacta->ohora_fin_a) }}">
            @error('ohora_fin_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td align="right">
            <b>* FECHA </b>:
        </td>
        <td>
            <input  type="date" name="ofecha_fin_a"
                    max="{{date('Y-m-d')}}" 
                    class="form-control form-control-sm"
                    value="{{ old('ofecha_fin_a', $datosacta->ofecha_fin_a) }}">
            @error('ofecha_fin_a') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td></td>
    </tr>

    <tr>
        <td colspan="8" align="right">
            <button class="btn btn-success btn-sm">
                GUARDAR DATOS DE {{$datosacta->tipoacta->otipoacta}}
            </button>
        </td>
    </tr>        
</tbody>
</table>

</form>
