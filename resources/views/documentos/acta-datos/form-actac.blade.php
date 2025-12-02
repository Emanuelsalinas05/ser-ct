<form name="FrmCartel" id="FrmCartel" method="POST"
      action="{{ route('datos-acta.update', $datosacta->id) }}"
      enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <input type="hidden" name="idacta"    value="{{ $datosacta->id }}">
    <input type="hidden" name="acta_tipo" value="{{ $datosacta->id_tipoacta }}">
    <input type="hidden" name="idavance"  value="{{ $avances->id }}">

<table class="table table-sm table-hover table-striped" style="font-size:14px;">
<thead>
<tr>
    <th colspan="8" class="bg-lightblue">
        <i class="fa fa-file-alt"></i>
        CAPTURA DE DATOS PARA EL {{ optional($datosacta->tipoacta)->otipoacta }}
        <br>VERIFICAR QUE LA INFORMACIÓN ESTÉ CORRECTA, YA QUE ÉSTA SERÁ PARA EL ACTA A REALIZAR. (DEBERÁ REGISTRAR CON MAYÚSCULAS Y ACENTOS).
        <span style="font-size:12px;">* LOS DATOS SON OBLIGATORIOS</span>
    </th>
</tr>
</thead>

<tbody>
<tr class="bg-lightblue disabled">
    <td colspan="8"><b>OTROS HECHOS</b>:</td>
</tr>
<tr>
    <td colspan="8" style="text-align:justify;">
        <b>* ASENTAR LA RAZÓN POR LA CUAL SE LEVANTA EL ACTA Y LA DESCRIPCIÓN GENERAL...</b>
        <textarea name="ohechos_ac" id="ohechos_ac" class="form-control" rows="6" style="resize:none;font-size:13px;">{{ old('ohechos_ac', $datosacta->ohechos_ac) }}</textarea>
        @error('ohechos_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr>
    <td align="right" colspan="2"><b>* HORA DE INICIO</b>:</td>
    <td>
        <input type="time" name="ohora_inicio_ac" class="form-control form-control-sm"
               value="{{ old('ohora_inicio_ac', $datosacta->ohora_inicio_ac) }}">
        @error('ohora_inicio_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right" colspan="2"><b>* FECHA DE INICIO</b>:</td>
    <td>
        <input type="date" name="ofecha_inicio_ac" max="{{ date('Y-m-d') }}" class="form-control form-control-sm"
               value="{{ old('ofecha_inicio_ac', $datosacta->ofecha_inicio_ac) }}">
        @error('ofecha_inicio_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td colspan="2"></td>
</tr>

<tr>
    <td align="right" colspan="2"><b>CIUDAD</b></td>
    <td colspan="4" width="45%">
        <input type="text" name="olugar_ac" class="form-control form-control-sm"
               value="{{ old('olugar_ac', $datosacta->olugar_ac) }}">
        @error('olugar_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td colspan="2" width="30%">(LUGAR DONDE SE LLEVA A CABO)</td>
</tr>

<tr>
    <td align="right"><b>* DOMICILIO</b>:</td>
    <td colspan="5">
        <input type="text" name="odomicilio_ct_ac" class="form-control form-control-sm"
               value="{{ old('odomicilio_ct_ac', $datosacta->odomicilio_ct_ac) }}">
        @error('odomicilio_ct_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td align="right"><b>* TEL.</b>:</td>
    <td>
        <input type="text" name="otelefono_ct_ac" maxlength="10"
               onkeypress="if(event.keyCode<45||event.keyCode>57) event.returnValue=false;"
               class="form-control form-control-sm"
               value="{{ old('otelefono_ct_ac', $datosacta->otelefono_ct_ac) }}">
        @error('otelefono_ct_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr>
    <td align="right"><b>C.T.</b></td>
    <td>
        {{ $datosacta->oct_ac }}
        <input type="hidden" name="oct_ac" value="{{ old('oct_ac', $datosacta->oct_ac) }}">
    </td>
    <td align="right" colspan="2"><b>NOMBRE DEL C.T.</b></td>
    <td colspan="4">
        {{ $datosacta->onombre_ct_ac }}
        <input type="hidden" name="onombre_ct_ac" value="{{ old('onombre_ct_ac', $datosacta->onombre_ct_ac) }}">
    </td>
</tr>

<tr>
    <td align="right" colspan="3">
        <b>* DIRECCIÓN/SUBDIRECCIÓN/DEPARTAMENTO</b><br>AL QUE PERTENECE
    </td>
    <td colspan="5">
        <input type="text" name="odepartamento_ac" class="form-control form-control-sm"
               value="{{ old('odepartamento_ac', $datosacta->odepartamento_ac) }}">
        @error('odepartamento_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr class="bg-lightblue disabled">
    <td colspan="8"><b>SERVIDOR PÚBLICO DESIGNADO PARA RECIBIR</b></td>
</tr>
<tr>
    <td align="right"><b>NOMBRE</b>:</td>
    <td colspan="2">
        {{ $datosacta->onombre_recibe_ac }}
        <input type="hidden" name="onombre_recibe_ac" value="{{ old('onombre_recibe_ac', $datosacta->onombre_recibe_ac) }}">
    </td>

    <td align="right"><b>RFC</b>:</td>
    <td>
        {{ $datosacta->orfc_recibe_ac }}
        <input type="hidden" name="orfc_recibe_ac" maxlength="14"
               value="{{ old('orfc_recibe_ac', $datosacta->orfc_recibe_ac) }}">
    </td>
    <td colspan="3"></td>
</tr>

<tr>
    <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
    <td>
        <select name="oidentificacion_recibe_ac" class="form-control form-control-sm">
            <option value="" {{ old('oidentificacion_recibe_ac', $datosacta->oidentificacion_recibe_ac) ? '' : 'selected' }} disabled>Selecciona una opción</option>
            <option value="INE"       @selected(old('oidentificacion_recibe_ac', $datosacta->oidentificacion_recibe_ac)==='INE')>INE</option>
            <option value="CEDULA"    @selected(old('oidentificacion_recibe_ac', $datosacta->oidentificacion_recibe_ac)==='CEDULA')>CEDULA</option>
            <option value="PASAPORTE" @selected(old('oidentificacion_recibe_ac', $datosacta->oidentificacion_recibe_ac)==='PASAPORTE')>PASAPORTE</option>
        </select>
        @error('oidentificacion_recibe_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
    <td colspan="2">
        <input type="file" name="oidentificacion_url_recibe_ac" class="form-control form-control-sm" accept="application/pdf">
        @if($datosacta->oidentificacion_url_recibe_ac)
            <small><a href="{{ Storage::url($datosacta->oidentificacion_url_recibe_ac) }}" target="_blank">Ver archivo actual</a></small>
        @endif
        @error('oidentificacion_url_recibe_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
    <td>
        <input type="text" name="onumero_identificacion_recibe_ac" class="form-control form-control-sm"
               value="{{ old('onumero_identificacion_recibe_ac', $datosacta->onumero_identificacion_recibe_ac) }}">
        @error('onumero_identificacion_recibe_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr>
    <td colspan="8" style="text-align:justify;">
        <b>* ANOTAR LAS OBSERVACIONES QUE SEÑALE LA PERSONA SERVIDORA PÚBLICA DESIGNADA PARA RECIBIR.</b>
        <textarea name="omanifestacion_recibe_ac" id="omanifestacion_recibe_ac" class="form-control" rows="4" style="resize:none;font-size:13px;">{{ old('omanifestacion_recibe_ac', $datosacta->omanifestacion_recibe_ac) }}</textarea>
        @error('omanifestacion_recibe_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr class="bg-lightblue disabled">
    <td colspan="3"><b>REPRESENTANTE DEL ÓRGANO INTERNO DE CONTROL</b></td>
    <td colspan="5">
        <b>* ¿PARTICIPA ALGÚN REPRESENTANTE?</b>&nbsp;&nbsp;
        @php $repac = old('orepresentante_ac', $datosacta->orepresentante_ac); @endphp
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="orepresentante_ac" id="repac_si" value="1" @checked($repac=='1')>SI
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="orepresentante_ac" id="repac_no" value="2" @checked($repac=='2')>NO
            </label>
        </div>
        @error('orepresentante_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr id="repres_ac1">
    <td align="right"><b>NOMBRE</b>:</td>
    <td colspan="4">
        <input type="text" name="orepresentante_contraloria_ac" class="form-control form-control-sm"
               value="{{ old('orepresentante_contraloria_ac', $datosacta->orepresentante_contraloria_ac) }}">
    </td>
    <td align="right"><b>RFC</b>:</td>
    <td>
        <input type="text" name="orfc_orepresentante_contraloria_ac" maxlength="14" class="form-control form-control-sm"
               value="{{ old('orfc_orepresentante_contraloria_ac', $datosacta->orfc_orepresentante_contraloria_ac) }}">
    </td>
    <td></td>
</tr>

<tr id="repres_ac2">
    <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
    <td>
        <select name="oidentificacion_representante_ac" class="form-control form-control-sm">
            <option value="" {{ old('oidentificacion_representante_ac', $datosacta->oidentificacion_representante_ac) ? '' : 'selected' }} disabled>Selecciona una opción</option>
            <option value="INE"       @selected(old('oidentificacion_representante_ac', $datosacta->oidentificacion_representante_ac)==='INE')>INE</option>
            <option value="CEDULA"    @selected(old('oidentificacion_representante_ac', $datosacta->oidentificacion_representante_ac)==='CEDULA')>CEDULA</option>
            <option value="PASAPORTE" @selected(old('oidentificacion_representante_ac', $datosacta->oidentificacion_representante_ac)==='PASAPORTE')>PASAPORTE</option>
        </select>
    </td>

    <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
    <td colspan="2">
        <input type="file" name="oidentificacion_representante_url_ac" class="form-control form-control-sm" accept="application/pdf">
        @if($datosacta->oidentificacion_representante_url_ac)
            <small><a href="{{ Storage::url($datosacta->oidentificacion_representante_url_ac) }}" target="_blank">Ver archivo actual</a></small>
        @endif
    </td>

    <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
    <td>
        <input type="text" name="onumero_identificacion_representante_ac" class="form-control form-control-sm"
               value="{{ old('onumero_identificacion_representante_ac', $datosacta->onumero_identificacion_representante_ac) }}">
        @error('onumero_identificacion_representante_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr id="repres_ac35">
    <td colspan="2" align="right"><b>* OFICIO NÚM:</b></td>
    <td>
        <input type="text" name="ooficio_designacion_er_a" id="ooficio_designacion_er_a" class="form-control form-control-sm"
               value="{{ old('ooficio_designacion_er_a', $datosacta->ooficio_designacion_er_a) }}">
        @error('ooficio_designacion_er_a')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td align="right"><b>* FECHA:</b></td>
    <td>
        <input type="date" name="ofecha_ofocio_designacion_er_a" id="ofecha_ofocio_designacion_er_a"
               max="{{ date('Y-m-d') }}" class="form-control form-control-sm"
               value="{{ old('ofecha_ofocio_designacion_er_a', $datosacta->ofecha_ofocio_designacion_er_a) }}">
        @error('ofecha_ofocio_designacion_er_a')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td colspan="3"></td>
</tr>

<tr class="bg-lightblue disabled">
    <td colspan="8"><b>AUTORIDAD INMEDIATA SUPERIOR (PRIMER TESTIGO)</b></td>
</tr>
<tr>
    <td align="right"><b>NOMBRE</b>:</td>
    <td colspan="4">
        <input type="text" name="onombre_testigo1_ac" class="form-control form-control-sm"
               value="{{ old('onombre_testigo1_ac', $datosacta->onombre_testigo1_ac) }}">
        @error('onombre_testigo1_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>RFC</b>:</td>
    <td>
        <input type="text" name="orfc_testigo1_ac" maxlength="14" class="form-control form-control-sm"
               value="{{ old('orfc_testigo1_ac', $datosacta->orfc_testigo1_ac) }}">
        @error('orfc_testigo1_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td></td>
</tr>

<tr>
    <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
    <td>
        <select name="oidentificacion_testigo1_ac" class="form-control form-control-sm">
            <option value="INE"       @selected(old('oidentificacion_testigo1_ac', $datosacta->oidentificacion_testigo1_ac)==='INE')>INE</option>
            <option value="CEDULA"    @selected(old('oidentificacion_testigo1_ac', $datosacta->oidentificacion_testigo1_ac)==='CEDULA')>CEDULA</option>
            <option value="PASAPORTE" @selected(old('oidentificacion_testigo1_ac', $datosacta->oidentificacion_testigo1_ac)==='PASAPORTE')>PASAPORTE</option>
        </select>
        @error('oidentificacion_testigo1_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
    <td colspan="2">
        <input type="file" name="oidentificacion_testigo1_url_ac" class="form-control form-control-sm" accept="application/pdf">
        @if($datosacta->oidentificacion_testigo1_url_ac)
            <small><a href="{{ Storage::url($datosacta->oidentificacion_testigo1_url_ac) }}" target="_blank">Ver archivo actual</a></small>
        @endif
        @error('oidentificacion_testigo1_url_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
    <td>
        <input type="text" name="onumero_identificacion_testigo1_ac" class="form-control form-control-sm"
               value="{{ old('onumero_identificacion_testigo1_ac', $datosacta->onumero_identificacion_testigo1_ac) }}">
        @error('onumero_identificacion_testigo1_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr>
    <td colspan="8" style="text-align:justify;">
        <b>* ANOTAR LAS OBSERVACIONES QUE SEÑALEN LOS REPRESENTANTES...</b>
        <textarea name="omanifiestan_representante_organo_ac" id="omanifiestan_representante_organo_ac"
                  class="form-control" rows="4" style="resize:none;font-size:13px;">{{ old('omanifiestan_representante_organo_ac', $datosacta->omanifiestan_representante_organo_ac) }}</textarea>
        @error('omanifiestan_representante_organo_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr class="bg-lightblue disabled">
    <td colspan="8"><b>DATOS DEL SEGUNDO TESTIGO</b></td>
</tr>
<tr>
    <td align="right"><b>NOMBRE</b>:</td>
    <td colspan="4">
        <input type="text" name="onombre_testigo2_ac" class="form-control form-control-sm"
               value="{{ old('onombre_testigo2_ac', $datosacta->onombre_testigo2_ac) }}">
        @error('onombre_testigo2_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>RFC</b>:</td>
    <td>
        <input type="text" name="orfc_testigo2_ac" maxlength="14" class="form-control form-control-sm"
               value="{{ old('orfc_testigo2_ac', $datosacta->orfc_testigo2_ac) }}">
        @error('orfc_testigo2_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td></td>
</tr>

<tr>
    <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
    <td>
        <select name="oidentificacion_testigo2_ac" class="form-control form-control-sm">
            <option value="INE"       @selected(old('oidentificacion_testigo2_ac', $datosacta->oidentificacion_testigo2_ac)==='INE')>INE</option>
            <option value="CEDULA"    @selected(old('oidentificacion_testigo2_ac', $datosacta->oidentificacion_testigo2_ac)==='CEDULA')>CEDULA</option>
            <option value="PASAPORTE" @selected(old('oidentificacion_testigo2_ac', $datosacta->oidentificacion_testigo2_ac)==='PASAPORTE')>PASAPORTE</option>
        </select>
        @error('oidentificacion_testigo2_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
    <td colspan="2">
        <input type="file" name="oidentificacion_testigo2_url_ac" class="form-control form-control-sm" accept="application/pdf">
        @if($datosacta->oidentificacion_testigo2_url_ac)
            <small><a href="{{ Storage::url($datosacta->oidentificacion_testigo2_url_ac) }}" target="_blank">Ver archivo actual</a></small>
        @endif
        @error('oidentificacion_testigo2_url_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>

    <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
    <td>
        <input type="text" name="onumero_identificacion_testigo2_ac" class="form-control form-control-sm"
               value="{{ old('onumero_identificacion_testigo2_ac', $datosacta->onumero_identificacion_testigo2_ac) }}">
        @error('onumero_identificacion_testigo2_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
</tr>

<tr class="bg-lightblue disabled">
    <td colspan="3" align="right"><b>HORA Y FECHA DE FINALIZACIÓN DEL ACTA</b></td>
    <td align="right"><b>* HORA</b>:</td>
    <td>
        <input type="time" name="ohora_fin_ac" class="form-control form-control-sm"
               value="{{ old('ohora_fin_ac', $datosacta->ohora_fin_ac) }}">
        @error('ohora_fin_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td align="right"><b>* FECHA</b>:</td>
    <td>
        <input type="date" name="ofecha_fin_ac" max="{{ date('Y-m-d') }}" class="form-control form-control-sm"
               value="{{ old('ofecha_fin_ac', $datosacta->ofecha_fin_ac) }}">
        @error('ofecha_fin_ac')<span style="color:red;">{{ $message }}</span>@enderror
    </td>
    <td></td>
</tr>

<tr>
    <td colspan="4" align="right">SI DESEA ADJUNTAR ARCHIVO DE OTROS HECHOS, SELECCIONE EL ARCHIVO AQUÍ</td>
    <td colspan="4">
        <input type="file" name="ourl_hechosac" class="form-control form-control-sm" accept="application/pdf">
        @if($datosacta->ourl_hechos)
            <small><a href="{{ Storage::url($datosacta->ourl_hechos) }}" target="_blank">Ver archivo actual</a></small>
        @endif
    </td>
</tr>

<tr>
    <td colspan="8" align="right">
        <button type="submit" class="btn btn-success btn-sm" id="btnGuardarActaCircunstanciada" onclick="return guardarActaCircunstanciada(this);">
            GUARDAR DATOS DE {{ optional($datosacta->tipoacta)->otipoacta }}
        </button>
    </td>
</tr>
</tbody>
</table>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rep = @json(old('orepresentante_ac', $datosacta->orepresentante_ac));
    toggleRep(rep);

    const si = document.getElementById('repac_si');
    const no = document.getElementById('repac_no');
    if (si) si.addEventListener('click', () => toggleRep('1'));
    if (no) no.addEventListener('click', () => toggleRep('2'));

    function toggleRep(val){
        const show = (val === '1' || val === 1);
        ['repres_ac1','repres_ac2','repres_ac35'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = show ? '' : 'none';
        });
    }

    const form = document.getElementById('FrmCartel');
    if (form) {
        form.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                if (e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            }
        });

        form.addEventListener('submit', function(e) {
            const isFromButton = (e.submitter && e.submitter.id === 'btnGuardarActaCircunstanciada') || 
                                 (form.dataset.allowSubmit === 'true');
            
            if (!isFromButton) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            form.dataset.allowSubmit = 'false';
        });
    }
});

function guardarActaCircunstanciada(btn) {
    const form = document.getElementById('FrmCartel');
    if (!form) {
        alert('Error: No se encontró el formulario');
        return false;
    }
    
    const camposObligatorios = {
        'ohechos_ac': 'DEBE REGISTRAR LOS HECHOS',
        'ohora_inicio_ac': 'DEBE INGRESAR LA HORA DE INICIO',
        'ofecha_inicio_ac': 'DEBE INGRESAR LA FECHA DE INICIO',
        'odomicilio_ct_ac': 'DEBE INGRESAR EL DOMICILIO',
        'otelefono_ct_ac': 'DEBE REGISTRAR EL TELÉFONO',
        'odepartamento_ac': 'DEBE INGRESAR EL NOMBRE DEL DEPARTAMENTO',
        'oidentificacion_recibe_ac': 'DEBE SELECCIONAR EL TIPO DE IDENTIFICACIÓN',
        'onumero_identificacion_recibe_ac': 'DEBE INGRESAR EL NÚMERO DE IDENTIFICACIÓN',
        'omanifestacion_recibe_ac': 'DEBE ESCRIBIR SU MANIFESTACIÓN',
        'onombre_testigo1_ac': 'DEBE INGRESAR EL NOMBRE DEL PRIMER TESTIGO',
        'orfc_testigo1_ac': 'DEBE INGRESAR EL RFC DEL PRIMER TESTIGO',
        'oidentificacion_testigo1_ac': 'DEBE SELECCIONAR EL TIPO DE IDENTIFICACIÓN DEL TESTIGO 1',
        'onumero_identificacion_testigo1_ac': 'DEBE INGRESAR EL NÚMERO DE IDENTIFICACIÓN DEL TESTIGO 1',
        'omanifiestan_representante_organo_ac': 'DEBE ESCRIBIR SU MANIFESTACIÓN',
        'onombre_testigo2_ac': 'DEBE INGRESAR EL NOMBRE DEL SEGUNDO TESTIGO',
        'orfc_testigo2_ac': 'DEBE INGRESAR EL RFC DEL SEGUNDO TESTIGO',
        'oidentificacion_testigo2_ac': 'DEBE SELECCIONAR EL TIPO DE IDENTIFICACIÓN DEL TESTIGO 2',
        'onumero_identificacion_testigo2_ac': 'DEBE INGRESAR EL NÚMERO DE IDENTIFICACIÓN DEL TESTIGO 2',
        'ohora_fin_ac': 'DEBE INGRESAR LA HORA DE TERMINO',
        'ofecha_fin_ac': 'DEBE INGRESAR LA FECHA DE TERMINO',
        'orepresentante_ac': 'DEBE SELECCIONAR SI HAY REPRESENTANTE DEL OIC'
    };
    
    const camposFaltantes = [];
    
    for (const [campo, mensaje] of Object.entries(camposObligatorios)) {
        const elemento = form.querySelector('[name="' + campo + '"]');
        
        if (!elemento) continue;
        
        let valor = '';
        if (elemento.type === 'file') {
            const tieneArchivo = elemento.files && elemento.files.length > 0;
            const existeArchivoAnterior = elemento.nextElementSibling && 
                                         elemento.nextElementSibling.querySelector('a');
            if (!tieneArchivo && !existeArchivoAnterior) {
                camposFaltantes.push(mensaje);
            }
        } else if (elemento.type === 'radio') {
            const radios = form.querySelectorAll('[name="' + campo + '"]');
            const algunoSeleccionado = Array.from(radios).some(r => r.checked);
            if (!algunoSeleccionado) {
                camposFaltantes.push(mensaje);
            }
        } else if (elemento.tagName === 'SELECT') {
            valor = elemento.value;
            if (!valor || valor === '' || elemento.options[elemento.selectedIndex].disabled) {
                camposFaltantes.push(mensaje);
            }
        } else {
            valor = elemento.value ? elemento.value.trim() : '';
            if (!valor) {
                camposFaltantes.push(mensaje);
            }
        }
    }
    
    const representanteSi = form.querySelector('[name="orepresentante_ac"][value="1"]');
    if (representanteSi && representanteSi.checked) {
        const camposRepresentante = {
            'orepresentante_contraloria_ac': 'DEBE INGRESAR EL NOMBRE DEL REPRESENTANTE',
            'orfc_orepresentante_contraloria_ac': 'DEBE INGRESAR EL RFC DEL REPRESENTANTE',
            'oidentificacion_representante_ac': 'DEBE SELECCIONAR EL TIPO DE IDENTIFICACIÓN DEL REPRESENTANTE',
            'onumero_identificacion_representante_ac': 'DEBE INGRESAR EL NÚMERO DE IDENTIFICACIÓN DEL REPRESENTANTE',
            'oidentificacion_representante_url_ac': 'DEBE SELECCIONAR EL ARCHIVO DE IDENTIFICACIÓN DEL REPRESENTANTE',
            'ooficio_designacion_er_a': 'DEBE INGRESAR EL NÚMERO DE OFICIO',
            'ofecha_ofocio_designacion_er_a': 'DEBE INGRESAR LA FECHA DEL OFICIO'
        };
        
        for (const [campo, mensaje] of Object.entries(camposRepresentante)) {
            const elemento = form.querySelector('[name="' + campo + '"]');
            if (!elemento) continue;
            
            let valor = '';
            if (elemento.type === 'file') {
                const tieneArchivo = elemento.files && elemento.files.length > 0;
                const existeArchivoAnterior = elemento.nextElementSibling && 
                                             elemento.nextElementSibling.querySelector('a');
                if (!tieneArchivo && !existeArchivoAnterior) {
                    camposFaltantes.push(mensaje);
                }
            } else if (elemento.tagName === 'SELECT') {
                valor = elemento.value;
                if (!valor || valor === '' || elemento.options[elemento.selectedIndex].disabled) {
                    camposFaltantes.push(mensaje);
                }
            } else {
                valor = elemento.value ? elemento.value.trim() : '';
                if (!valor) {
                    camposFaltantes.push(mensaje);
                }
            }
        }
    }
    
    if (camposFaltantes.length > 0) {
        let mensaje = 'POR FAVOR, COMPLETE LOS SIGUIENTES CAMPOS OBLIGATORIOS:\n\n';
        camposFaltantes.forEach((campo, index) => {
            mensaje += (index + 1) + '. ' + campo + '\n';
        });
        alert(mensaje);
        return false;
    }
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> GUARDANDO...';
    form.dataset.allowSubmit = 'true';
    
    return true;
}
</script>
@endpush
