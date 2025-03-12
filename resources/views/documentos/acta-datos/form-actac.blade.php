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
        <th colspan="8" class="bg-lightblue">
            <i class="fa fa-file-alt"></i>
            CAPTURA DE DATOS PARA EL {{ $datosacta->tipoacta->otipoacta }}
            <br>VERIFICA CUIDADOSAMENTE QUE CADA DATO A REGISTRAR. 
            <span style="font-size: 12px;;">* LOS DATOS SON OBLIGATORIOS</span>
        </th>
    </tr>
</thead>
<tbody>
    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>OTROS HECHOS</b>:</td>
    </tr>
    <tr>
        <td style="text-align: justify;" colspan="8">
            <b>* ASENTAR LA RAZÓN POR LA CUAL SE LEVANTA EL ACTA Y LA DESCRIPCIÓN GENERAL DE CÓMO SE RECIBE EL CENTRO DE TRABAJO EN RELACIÓN A LOS DOCUMENTOS QUE SE MENCIONAN EN EL ACTA DE ENTREGA Y RECEPCIÓN.</b>
            <textarea   name="ohechos_ac" 
                        id="ohechos_ac"
                        class="form-control "
                        rows="6"  
                        style="resize: none; font-size:13px;">{{ old('ohechos_ac', $datosacta->ohechos_ac) }}</textarea>
            @error('ohechos_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <b>* HORA DE INICIO</b>:
        </td>
        <td>
            <input  type="time" name="ohora_inicio_ac"
                    class="form-control form-control-sm"
                    value="{{ old('ohora_inicio_ac', $datosacta->ohora_inicio_ac) }}">
            @error('ohora_inicio_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td align="right" colspan="2">
            <b>* FECHA DE INICIO</b>:
        </td>
        <td>
            <input  type="date" name="ofecha_inicio_ac"
                    max="{{date('Y-m-d')}}" 
                    class="form-control form-control-sm"
                    value="{{ old('ofecha_inicio_ac', $datosacta->ofecha_inicio_ac) }}">
            @error('ofecha_inicio_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <b>CIUDAD</b>
        </td>
        <td colspan="4" width="45%">
            <input  type="text" name="olugar_ac"
                    class="form-control form-control-sm"
                    value="{{ old('olugar_ac', $datosacta->olugar_ac) }}">
            @error('olugar_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td colspan="2" width="30%">(LUGAR DONDE SE LLEVA A CABO)</td>
    </tr>
    <tr>
        <td align="right"><b>* DOMICILIO</b>:</td>
        <td colspan="5">
            <input  type="text" name="odomicilio_ct_ac"
                    class="form-control form-control-sm"
                    value="{{ old('odomicilio_ct_ac', $datosacta->odomicilio_ct_ac) }}">
            @error('odomicilio_ct_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* TEL.</b>:</td>
        <td>
            <input  type="text" name="otelefono_ct_ac"
                    class="form-control form-control-sm"
                    value="{{ old('otelefono_ct_ac', $datosacta->otelefono_ct_ac) }}"
                    maxlength="10"
                    onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;">
            @error('otelefono_ct_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right"><b>C.T.</b></td>
        <td>
            {{$datosacta->oct_ac}}
            <input  type="hidden" name="oct_ac"
                    class="form-control form-control-sm"
                    value="{{ old('oct_ac', $datosacta->oct_ac) }}">
        </td>
        <td align="right" colspan="2"><b>NOMBRE DEL C.T.</b></td>
        <td colspan="4">
            {{$datosacta->onombre_ct_ac}}
            <input  type="hidden" name="onombre_ct_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_ct_ac', $datosacta->onombre_ct_ac) }}">
        </td>
    </tr>
    <tr>
        <td align="right" colspan="3">
            <b>* DIRECCIÓN/SUBDIRECCIÓN/DEPARTAMENTO</b>
            <br>AL QUE PERTENECE
        </td>
        <td colspan="5">
            <input  type="text" name="odepartamento_ac"
                    class="form-control form-control-sm"
                    value="{{ old('odepartamento_ac', $datosacta->odepartamento_ac) }}">
            @error('odepartamento_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>SERVIDOR PÚBLICO QUE RECIBE</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOMBRE</b>:</td>
        <td colspan="2">
            {{$datosacta->onombre_recibe_ac}}
            <input  type="hidden" name="onombre_recibe_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_recibe_ac', $datosacta->onombre_recibe_ac) }}">
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            {{$datosacta->orfc_recibe_ac}}
            <input  type="hidden" name="orfc_recibe_ac"
                    class="form-control form-control-sm" maxlength="14" 
                    value="{{ old('orfc_recibe_ac', $datosacta->orfc_recibe_ac) }}">
        </td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_recibe_ac" 
                    class="form-control form-control-sm">
                <option value="" disabled selected>-----</option>
                <option value="INE" 
                    @if($datosacta->oidentificacion_recibe_ac=='INE') selected @else old('oidentificacion_recibe_ac') @endif>
                    INE
                </option> 
                <option value="CEDULA" 
                    @if($datosacta->oidentificacion_recibe_ac=='CEDULA') selected @else old('oidentificacion_recibe_ac') @endif >
                    CEDULA
                </option>
                <option value="PASAPORTE" 
                    @if($datosacta->oidentificacion_recibe_ac=='PASAPORTE') selected @else old('oidentificacion_recibe_ac') @endif >
                    PASAPORTE
                </option>
            </select>
            @error('oidentificacion_recibe_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_url_recibe_ac"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_url_recibe_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_recibe_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_recibe_ac', $datosacta->onumero_identificacion_recibe_ac) }}">
            @error('onumero_identificacion_recibe_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td style="text-align: justify; " colspan="8">
            <b>* ANOTAR LAS OBSERVACIONES QUE SEÑALE LA PERSONA SERVIDORA PÚBLICA DESIGNADA PARA RECIBIR.</b> 
            <textarea   name="omanifestacion_recibe_ac" 
                        id="omanifestacion_recibe_ac"
                        class="form-control "
                        rows="4"  
                        style="resize: none; font-size:13px;">{{ old('omanifestacion_recibe_ac', $datosacta->omanifestacion_recibe_ac) }}</textarea>
            @error('omanifestacion_recibe_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>



    <tr class="bg-lightblue disabled">
        <td colspan="3" >
            <b>REPRESENTANTE DEL ÓRGANO INTERNO DE CONTROL</b>
        </td>
        <td colspan="5">
            <b>* ¿PARTICIPA ALGÚN REPRESENTANTE?</b>&nbsp;&nbsp;

            <div class="form-check-inline">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="1" {{ old('orepresentante_ac') == '1' ? 'checked' : '' }}
                            name="orepresentante_ac"id="orepresentante_ac"
                            onclick="representanteac(1)">SI
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="2" {{ old('orepresentante_ac') == '2' ? 'checked' : '' }}
                            name="orepresentante_ac"id="orepresentante_ac"
                            onclick="representanteac(2)">NO
                </label>
            </div>
            @error('orepresentante_ac') <span style="color:red;">{{ $message }}</span> @enderror
            <script type="text/javascript">
                function representanteac(id){
                    if(id=='1'){
                        $('#repres_ac1').show();
                        $('#repres_ac2').show();
                        $('#repres_ac3').show();
                        $('#repres_ac4').show();
                    }else if(id=='2'){
                        $('#repres_ac1').hide();
                        $('#repres_ac2').hide();
                        $('#repres_ac3').hide();
                        $('#repres_ac4').hide();
                    }
                }
            </script>
        </td>
    </tr>
    <tr id="repres_ac1">
        <td  align="right"><b>NOMBRE</b>:</td>
        <td colspan="4">
            <input  type="text" name="orepresentante_contraloria_ac"
                    class="form-control form-control-sm"
                    value="{{ old('orepresentante_contraloria_ac', $datosacta->orepresentante_contraloria_ac) }}">
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            <input  type="text" name="orfc_orepresentante_contraloria_ac"
                    class="form-control form-control-sm" maxlength="14" 
                    value="{{ old('orfc_orepresentante_contraloria_ac', $datosacta->orfc_orepresentante_contraloria_ac) }}">
        </td>
        <td></td>
    </tr>
    <tr  id="repres_ac2">
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_representante_ac" 
                    class="form-control form-control-sm">
                <option value="" disabled selected>-----</option>
                <option value="INE" 
                    @if($datosacta->oidentificacion_representante_ac=='INE') selected @else old('oidentificacion_representante_ac') @endif>
                    INE
                </option> 
                <option value="CEDULA" 
                    @if($datosacta->oidentificacion_representante_ac=='CEDULA') selected @else old('oidentificacion_representante_ac') @endif >
                    CEDULA
                </option>
                <option value="PASAPORTE" 
                    @if($datosacta->oidentificacion_representante_ac=='PASAPORTE') selected @else old('oidentificacion_representante_ac') @endif >
                    PASAPORTE
                </option>
            </select>
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_representante_url_ac"
                    class="form-control form-control-sm"
                    accept="application/pdf">
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_representante_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_representante_ac', $datosacta->onumero_identificacion_representante_ac) }}">
            @error('onumero_identificacion_representante_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr id="repres_ac35">
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



    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>AUTORIDAD INMEDIATA SUPERIOR (PRIMER TESTIGO)</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOMBRE</b>:</td>
        <td colspan="4">
            <input  type="text" name="onombre_testigo1_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_testigo1_ac', $datosacta->onombre_testigo1_ac) }}">
            @error('onombre_testigo1_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            <input  type="text" name="orfc_testigo1_ac"
                    class="form-control form-control-sm" maxlength="14" 
                    value="{{ old('orfc_testigo1_ac', $datosacta->orfc_testigo1_ac) }}">
            @error('orfc_testigo1_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_testigo1_ac" 
                    class="form-control form-control-sm">
                <option value="INE" 
                    @if($datosacta->oidentificacion_testigo1_ac=='INE') selected @else old('oidentificacion_testigo1_ac') @endif>
                    INE
                </option> 
                <option value="CEDULA" 
                    @if($datosacta->oidentificacion_testigo1_ac=='CEDULA') selected @else old('oidentificacion_testigo1_ac') @endif >
                    CEDULA
                </option>
                <option value="PASAPORTE" 
                    @if($datosacta->oidentificacion_testigo1_ac=='PASAPORTE') selected @else old('oidentificacion_testigo1_ac') @endif >
                    PASAPORTE
                </option>
            </select>
            @error('oidentificacion_testigo1_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_testigo1_url_ac"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_testigo1_url_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_testigo1_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_testigo1_ac', $datosacta->onumero_identificacion_testigo1_ac) }}">
            @error('onumero_identificacion_testigo1_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td style="text-align: justify;" colspan="8">
            <b>* ANOTAR LAS OBSERVACIONES QUE SEÑALEN LOS REPRESENTANTES DE LA AUTORIDAD INMEDIATA SUPERIOR, DEL ÓRGANO INTERNO DE CONTROL Y TESTIGO. </b>
            <textarea   name="omanifiestan_representante_organo_ac" 
                        id="omanifiestan_representante_organo_ac"
                        class="form-control "
                        rows="4"  
                        style="resize: none; font-size:13px;">{{ old('omanifiestan_representante_organo_ac', $datosacta->omanifiestan_representante_organo_ac) }}</textarea>
            @error('omanifiestan_representante_organo_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>DATOS DEL SEGUNDO TESTIGO</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOMBRE</b>:</td>
        <td colspan="4">
            <input  type="text" name="onombre_testigo2_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_testigo2_ac', $datosacta->onombre_testigo2_ac) }}">
            @error('onombre_testigo2_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            <input  type="text" name="orfc_testigo2_ac"
                    class="form-control form-control-sm" maxlength="14" 
                    value="{{ old('orfc_testigo2_ac', $datosacta->orfc_testigo2_ac) }}">
            @error('orfc_testigo2_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE DENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_testigo2_ac" 
                    class="form-control form-control-sm">
                <option value="INE" 
                    @if($datosacta->oidentificacion_testigo2_ac=='INE') selected @else old('oidentificacion_testigo2_ac') @endif>
                    INE
                </option> 
                <option value="CEDULA" 
                    @if($datosacta->oidentificacion_testigo2_ac=='CEDULA') selected @else old('oidentificacion_testigo2_ac') @endif >
                    CEDULA
                </option>
                <option value="PASAPORTE" 
                    @if($datosacta->oidentificacion_testigo2_ac=='PASAPORTE') selected @else old('oidentificacion_testigo2_ac') @endif >
                    PASAPORTE
                </option>
            </select>
            @error('oidentificacion_testigo2_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <input  type="file" name="oidentificacion_testigo2_url_ac"
                    class="form-control form-control-sm"
                    accept="application/pdf">
            @error('oidentificacion_testigo2_url_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_testigo2_ac"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_testigo2_ac', $datosacta->onumero_identificacion_testigo2_ac) }}">
            @error('onumero_identificacion_testigo2_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td colspan="3" class="bg-lightblue disabled" align="right">
            <b>HORA Y FECHA DE FINALIZACIÓN DEL ACTA</b>
        </td>
        <td align="right">
            <b>* HORA </b>:
        </td>
        <td>
            <input  type="time" name="ohora_fin_ac"
                    class="form-control form-control-sm"
                    value="{{ old('ohora_fin_ac', $datosacta->ohora_fin_ac) }}">
            @error('ohora_fin_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>

        <td align="right">
            <b>* FECHA </b>:
        </td>
        <td>
            <input  type="date" name="ofecha_fin_ac"
                    max="{{date('Y-m-d')}}" 
                    class="form-control form-control-sm"
                    value="{{ old('ofecha_fin_ac', $datosacta->ofecha_fin_ac) }}">
            @error('ofecha_fin_ac') <span style="color:red;">{{ $message }}</span> @enderror
        </td>
        <td></td>
    </tr>
    <tr>
        <td colspan="4" align="right">
            SI DESEA ADJUNTAR ARCHIVO DE OTROS HECHOS, SELECCIONE EL ARCHIVO AQUÍ
        </td>
        <td colspan="4" >
            <input  type="file" name="ourl_hechosac"
                    class="form-control form-ourl_hechos-sm"
                    accept="application/pdf">
        </td>
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