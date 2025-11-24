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
            <br>VERIFICAR QUE LA INFORMACIÓN ESTÉ CORRECTA, YA QUE ÉSTA SERÁ PARA EL ACTA A REALIZAR. (DEBERÁ REGISTRAR CON MAYÚSCULAS Y ACENTOS).
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
            @error('olugar_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>

        <td align="right"><b>* HORA</b></td>
        <td>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                </div>
                <input  type="time" name="ohora_inicio_a"
                        class="form-control form-control-sm"
                        value="{{ old('ohora_inicio_a', $datosacta->ohora_inicio_a) }}">
            </div>
            @error('ohora_inicio_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* FECHA</b></td>
        <td>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input  type="date" name="ofecha_inicio_a"
                        max="{{date('Y-m-d')}}" 
                        class="form-control form-control-sm"
                        value="{{ old('ofecha_inicio_a', $datosacta->ofecha_inicio_a) }}">
            </div>
            @error('ofecha_inicio_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right"><b>* DOMICILIO</b></td>
        <td colspan="5">
            <input  type="text" name="odomicilio_ct_a"
                    class="form-control form-control-sm"
                    value="{{ old('odomicilio_ct_a', $datosacta->odomicilio_ct_a) }}">
            @error('odomicilio_ct_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>

        <td colspan="2"></td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>SERVIDOR PÚBLICO QUE ENTREGA</b></td>
    </tr>
    <tr>
        <td align="right"><b>NOMBRE</b>:</td>
        <td colspan="2">
            <input  type="text" name="onombre_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_entrega_a', $datosacta->onombre_entrega_a) }}">
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
            <input  type="text" name="orfc_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('orfc_entrega_a', $datosacta->orfc_entrega_a) }}">
        </td>
        
        <td align="right"><b>CARGO</b>:</td>
        <td colspan="2">
            <input  type="text" name="ocargo_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_entrega_a', $datosacta->ocargo_entrega_a) }}">
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_entrega_a" 
                    class="form-control form-control-sm">
                <option value="" disabled {{ old('oidentificacion_entrega_a', $datosacta->oidentificacion_entrega_a) ? '' : 'selected' }}>Selecciona una opción</option>
                <option value="INE" {{ old('oidentificacion_entrega_a', $datosacta->oidentificacion_entrega_a)=='INE' ? 'selected' : '' }}>INE</option>
                <option value="CEDULA" {{ old('oidentificacion_entrega_a', $datosacta->oidentificacion_entrega_a)=='CEDULA' ? 'selected' : '' }}>CEDULA</option>
                <option value="PASAPORTE" {{ old('oidentificacion_entrega_a', $datosacta->oidentificacion_entrega_a)=='PASAPORTE' ? 'selected' : '' }}>PASAPORTE</option>
            </select>
            @error('oidentificacion_entrega_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <div class="custom-file custom-file-sm">
                <input  type="file" 
                        name="oidentificacion_url_entrega_a"
                        id="oidentificacion_url_entrega_a"
                        class="custom-file-input"
                        accept="application/pdf">
                <label class="custom-file-label" for="oidentificacion_url_entrega_a">
                    {{ $datosacta->oidentificacion_url_entrega_a ? 'Archivo actual seleccionado' : 'Seleccionar archivo PDF' }}
                </label>
            </div>
            @if($datosacta->oidentificacion_url_entrega_a)
                <small class="d-block mt-1">
                    <a target="_blank" href="{{ Storage::url($datosacta->oidentificacion_url_entrega_a) }}" class="text-primary">
                        <i class="fa fa-file-pdf"></i> Ver archivo actual
                    </a>
                </small>
            @endif
            @error('oidentificacion_url_entrega_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_entrega_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_entrega_a', $datosacta->onumero_identificacion_entrega_a) }}">
            @error('onumero_identificacion_entrega_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
    </tr>


    <tr class="bg-lightblue disabled">
        <td colspan="8" ><b>SERVIDOR PÚBLICO QUE RECIBE</b></td>
    </tr>
    <tr>
        <td  align="right"><b>NOMBRE</b>:</td>
        <td colspan="2">
            <input  type="text" name="onombre_recibe_a"
                    class="form-control form-control-sm"
                    value="{{ old('onombre_recibe_a', $datosacta->onombre_recibe_a) }}">
        </td>

        <td  align="right"><b>RFC</b>:</td>
        <td>
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
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_recibe_a" 
                    class="form-control form-control-sm">
                <option value="" disabled {{ old('oidentificacion_recibe_a', $datosacta->oidentificacion_recibe_a) ? '' : 'selected' }}>Selecciona una opción</option>
                <option value="INE" {{ old('oidentificacion_recibe_a', $datosacta->oidentificacion_recibe_a)=='INE' ? 'selected' : '' }}>INE</option>
                <option value="CEDULA" {{ old('oidentificacion_recibe_a', $datosacta->oidentificacion_recibe_a)=='CEDULA' ? 'selected' : '' }}>CEDULA</option>
                <option value="PASAPORTE" {{ old('oidentificacion_recibe_a', $datosacta->oidentificacion_recibe_a)=='PASAPORTE' ? 'selected' : '' }}>PASAPORTE</option>
            </select>
            @error('oidentificacion_recibe_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <div class="custom-file custom-file-sm">
                <input  type="file" 
                        name="oidentificacion_url_recibe_a"
                        id="oidentificacion_url_recibe_a"
                        class="custom-file-input"
                        accept="application/pdf">
                <label class="custom-file-label" for="oidentificacion_url_recibe_a">
                    {{ $datosacta->oidentificacion_url_recibe_a ? 'Archivo actual seleccionado' : 'Seleccionar archivo PDF' }}
                </label>
            </div>
            @if($datosacta->oidentificacion_url_recibe_a)
                <small class="d-block mt-1">
                    <a target="_blank" href="{{ Storage::url($datosacta->oidentificacion_url_recibe_a) }}" class="text-primary">
                        <i class="fa fa-file-pdf"></i> Ver archivo actual
                    </a>
                </small>
            @endif
            @error('oidentificacion_url_recibe_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_recibe_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_recibe_a', $datosacta->onumero_identificacion_recibe_a) }}">
            @error('onumero_identificacion_recibe_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
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
            @error('onombre_testigo_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* RFC TESTIGO 1</b>:</td>
        <td colspan="2">
            <input  type="TEXT" name="orfc_testigo" maxlength="14" 
                    class="form-control form-control-sm"
                    value="{{ old('orfc_testigo', $datosacta->orfc_testigo) }}">
            @error('orfc_testigo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
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
                <option value="{{$ct->oclave}}" {{ $ct->oclave==old('oct_testigo_a',$datosacta->oct_testigo_a) ? 'selected' : '' }}>
                    {{$ct->oclave.' - '.$ct->onombre_ct}}
                </option>
                @endforeach
            </select>
            @error('oct_testigo_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* CARGO</b>:</td>
        <td >
            <input  type="text" name="ocargo_testigo_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_testigo_a', $datosacta->ocargo_testigo_a) }}">
            @error('ocargo_testigo_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_testigo" 
                    class="form-control form-control-sm">
                <option value="" disabled {{ old('oidentificacion_testigo', $datosacta->oidentificacion_testigo) ? '' : 'selected' }}>Selecciona una opción</option>
                <option value="INE" {{ old('oidentificacion_testigo', $datosacta->oidentificacion_testigo)=='INE' ? 'selected' : '' }}>INE</option>
                <option value="CEDULA" {{ old('oidentificacion_testigo', $datosacta->oidentificacion_testigo)=='CEDULA' ? 'selected' : '' }}>CEDULA</option>
                <option value="PASAPORTE" {{ old('oidentificacion_testigo', $datosacta->oidentificacion_testigo)=='PASAPORTE' ? 'selected' : '' }}>PASAPORTE</option>
            </select>
            @error('oidentificacion_testigo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        
        <td align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <div class="custom-file custom-file-sm">
                <input  type="file" 
                        name="oidentificacion_url_testigo"
                        id="oidentificacion_url_testigo"
                        class="custom-file-input"
                        accept="application/pdf">
                <label class="custom-file-label" for="oidentificacion_url_testigo">
                    {{ $datosacta->oidentificacion_url_testigo ? 'Archivo actual seleccionado' : 'Seleccionar archivo PDF' }}
                </label>
            </div>
            @if($datosacta->oidentificacion_url_testigo)
                <small class="d-block mt-1">
                    <a target="_blank" href="{{ Storage::url($datosacta->oidentificacion_url_testigo) }}" class="text-primary">
                        <i class="fa fa-file-pdf"></i> Ver archivo actual
                    </a>
                </small>
            @endif
            @error('oidentificacion_url_testigo') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_testigo_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_testigo_a', $datosacta->onumero_identificacion_testigo_a) }}">
            @error('onumero_identificacion_testigo_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
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
            @error('onombre_testigo2_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* RFC TESTIGO 2</b>:</td>
        <td colspan="2">
            <input  type="TEXT" name="orfc_testigo2"
                    class="form-control form-control-sm" maxlength="14" 
                    value="{{ old('orfc_testigo2', $datosacta->orfc_testigo2) }}">
            @error('orfc_testigo2') <span class="text-danger small d-block">{{ $message }}</span> @enderror

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
                <option value="{{$ct->oclave}}" {{ $ct->oclave==old('oct_testigo2_a',$datosacta->oct_testigo2_a) ? 'selected' : '' }}>
                    {{$ct->oclave.' - '.$ct->onombre_ct}}
                </option>
                @endforeach
            </select>
            @error('oct_testigo2_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td  align="right"><b>* CARGO</b>:</td>
        <td>
        <input  type="text" name="ocargo_testigo2_a"
                    class="form-control form-control-sm"
                    value="{{ old('ocargo_testigo2_a', $datosacta->ocargo_testigo2_a) }}">
            @error('ocargo_testigo2_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2"><b>* MEDIO DE IDENTIFICACIÓN</b>:</td>
        <td>
            <select name="oidentificacion_testigo2" 
                    class="form-control form-control-sm">
                <option value="" disabled {{ old('oidentificacion_testigo2', $datosacta->oidentificacion_testigo2) ? '' : 'selected' }}>Selecciona una opción</option>
                <option value="INE" {{ old('oidentificacion_testigo2', $datosacta->oidentificacion_testigo2)=='INE' ? 'selected' : '' }}>INE</option>
                <option value="CEDULA" {{ old('oidentificacion_testigo2', $datosacta->oidentificacion_testigo2)=='CEDULA' ? 'selected' : '' }}>CEDULA</option>
                <option value="PASAPORTE" {{ old('oidentificacion_testigo2', $datosacta->oidentificacion_testigo2)=='PASAPORTE' ? 'selected' : '' }}>PASAPORTE</option>
            </select>
            @error('oidentificacion_testigo2') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        
        <td  align="right"><b>* ARCHIVO DE IDENTIFICACIÓN</b>:</td>
        <td colspan="2">
            <div class="custom-file custom-file-sm">
                <input  type="file" 
                        name="oidentificacion_url_testigo2"
                        id="oidentificacion_url_testigo2"
                        class="custom-file-input"
                        accept="application/pdf">
                <label class="custom-file-label" for="oidentificacion_url_testigo2">
                    {{ ($datosacta->oidentificacion_testigo2_url ?? false) ? 'Archivo actual seleccionado' : 'Seleccionar archivo PDF' }}
                </label>
            </div>
            @if($datosacta->oidentificacion_testigo2_url ?? false)
                <small class="d-block mt-1">
                    <a target="_blank" href="{{ Storage::url($datosacta->oidentificacion_testigo2_url) }}" class="text-primary">
                        <i class="fa fa-file-pdf"></i> Ver archivo actual
                    </a>
                </small>
            @endif
            @error('oidentificacion_url_testigo2') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* NÚMERO IDENTIFICACIÓN</b>:</td>
        <td >
            <input  type="text" name="onumero_identificacion_testigo2_a"
                    class="form-control form-control-sm"
                    value="{{ old('onumero_identificacion_testigo2_a', $datosacta->onumero_identificacion_testigo2_a) }}">
            @error('onumero_identificacion_testigo2_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
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
                            name="orepresentante_a" id="orepresentante_a1"
                            onclick="representante(1)">SI
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="2" 
                            name="orepresentante_a" id="orepresentante_a2"
                            onclick="representante(2)">NO
                </label>
            </div>
            @error('orepresentante_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
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
            @error('ooficio_designacion_er_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td align="right"><b>* FECHA:</b></td>
        <td>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input  type="date" name="ofecha_ofocio_designacion_er_a"
                        id="ofecha_ofocio_designacion_er_a"
                        max="{{date('Y-m-d')}}" 
                        class="form-control form-control-sm"
                        value="{{ old('ofecha_ofocio_designacion_er_a', $datosacta->ofecha_ofocio_designacion_er_a) }}">
            </div>
            @error('ofecha_ofocio_designacion_er_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td colspan="3"></td>
    </tr>
    <tr class="bg-light">
        <td colspan="8" class="text-info">
            <b>* ¿Desean registrar algún hecho importante o información adicional?</b>&nbsp;&nbsp;&nbsp;

            <div class="form-check-inline" style="color:black;">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="1" 
                            name="ohechos_ax" id="ohechos_ax1"
                            onclick="ohechos(1)">SI
                </label>
            </div>
            <div class="form-check-inline" style="color:black;">
                <label class="form-check-label">
                    <input  type="radio" 
                            class="form-check-input" 
                            value="2" 
                            name="ohechos_ax" id="ohechos_ax2"
                            onclick="ohechos(2)">NO
                </label>
            </div>
            @error('ohechos_ax') <span class="text-danger small d-block">{{ $message }}</span> @enderror
            <script type="text/javascript">
                function ohechos(id){
                    if(id=='1'){
                        // SI: Mostrar modal para ingresar otros hechos
                        Swal.fire({
                            title: '¿Desean registrar algún hecho importante o información adicional?',
                            html: `
                                <div class="text-left">
                                    <div class="form-group">
                                        <label><b>* DESCRIPCIÓN:</b></label>
                                        <textarea id="swal_ohechos" class="form-control" rows="7" 
                                                  placeholder="Ingrese la descripción del hecho importante o información adicional que desee agregar al acta..."
                                                  style="resize: none;">{{ old('ohechos_a', $datosacta->ohechos_a) }}</textarea>
                                    </div>
                                    <div class="alert alert-info">
                                        <small><i class="fa fa-info-circle"></i> Después de guardar, podrá adjuntar un archivo PDF o información adicional en el formulario si lo desea.</small>
                                    </div>
                                </div>
                            `,
                            width: '700px',
                            showCancelButton: true,
                            confirmButtonText: 'GUARDAR',
                            cancelButtonText: 'CANCELAR',
                            confirmButtonColor: '#28a745',
                            cancelButtonColor: '#dc3545',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            preConfirm: () => {
                                const hechos = document.getElementById('swal_ohechos').value.trim();
                                
                                if (!hechos) {
                                    Swal.showValidationMessage('Ingrese la descripción del hecho importante o información adicional');
                                    return false;
                                }
                                
                                return {
                                    hechos: hechos.toUpperCase()
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                // Llenar el campo de texto del formulario
                                document.getElementById('ohechos_a').value = result.value.hechos;
                                
                                // Mostrar los campos en el formulario
                                if (typeof jQuery !== 'undefined') {
                                    jQuery('#ohechos_a').show();
                                    jQuery('#ohechos_az').show();
                                    jQuery('#ohechos_azx').show();
                                } else {
                                    var elem1 = document.getElementById('ohechos_a');
                                    var elem2 = document.getElementById('ohechos_az');
                                    var elem3 = document.getElementById('ohechos_azx');
                                    if (elem1) elem1.style.display = '';
                                    if (elem2) elem2.style.display = '';
                                    if (elem3) elem3.style.display = '';
                                }
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Datos guardados',
                                    html: 'La información se ha registrado correctamente.<br>Puede adjuntar un archivo PDF o información adicional en el formulario si lo desea.',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                // Si canceló, deseleccionar el radio button
                                document.getElementById('ohechos_ax2').checked = true;
                                ohechos(2);
                            }
                        });
                    }else if(id=='2'){
                        // NO: Ocultar campos del formulario
                        // Asegurar que jQuery esté disponible
                        if (typeof jQuery !== 'undefined') {
                            jQuery('#ohechos_a').hide();
                            jQuery('#ohechos_az').hide();
                            jQuery('#ohechos_azx').hide();
                        } else {
                            // Fallback sin jQuery
                            var elem1 = document.getElementById('ohechos_a');
                            var elem2 = document.getElementById('ohechos_az');
                            var elem3 = document.getElementById('ohechos_azx');
                            if (elem1) elem1.style.display = 'none';
                            if (elem2) elem2.style.display = 'none';
                            if (elem3) elem3.style.display = 'none';
                        }
                        // Limpiar campos
                        document.getElementById('ohechos_a').value = '';
                        const fileInput = document.getElementById('ourl_hechos');
                        if (fileInput) {
                            fileInput.value = '';
                        }
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
            Adjuntar aquí archivo o información adicional.
        </td>
        <td colspan="6" id="ohechos_az">
            <div class="custom-file custom-file-sm">
                <input  type="file" 
                        name="ourl_hechos"
                        id="ourl_hechos"
                        class="custom-file-input"
                        accept="application/pdf">
                <label class="custom-file-label" for="ourl_hechos">
                    {{ $datosacta->ourl_hechos ? 'Archivo actual seleccionado' : 'Seleccionar archivo PDF' }}
                </label>
            </div>
            @if($datosacta->ourl_hechos)
                <small class="d-block mt-1">
                    <a target="_blank" href="{{ Storage::url($datosacta->ourl_hechos) }}" class="text-primary">
                        <i class="fa fa-file-pdf"></i> Ver archivo actual
                    </a>
                </small>
            @endif
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
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                </div>
                <input  type="time" name="ohora_fin_a"
                        class="form-control form-control-sm"
                        value="{{ old('ohora_fin_a', $datosacta->ohora_fin_a) }}">
            </div>
            @error('ohora_fin_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>

        <td align="right">
            <b>* FECHA </b>:
        </td>
        <td>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
                <input  type="date" name="ofecha_fin_a"
                        max="{{date('Y-m-d')}}" 
                        class="form-control form-control-sm"
                        value="{{ old('ofecha_fin_a', $datosacta->ofecha_fin_a) }}">
            </div>
            @error('ofecha_fin_a') <span class="text-danger small d-block">{{ $message }}</span> @enderror
        </td>
        <td></td>
    </tr>

    <tr>
        <td colspan="8" align="right" class="pt-3">
            <button class="btn btn-success btn-lg shadow-sm" onclick="this.disabled=true; this.form.submit();">
                <i class="fa fa-save"></i> GUARDAR DATOS DE {{$datosacta->tipoacta->otipoacta}}
            </button>
        </td>
    </tr>        
</tbody>
</table>

</form>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function(){
    // Preseleccionar radios desde old() o BD
    var rep = @json(old('orepresentante_a', $datosacta->orepresentante_a));
    var hx  = @json(old('ohechos_ax', $datosacta->ohechos_a ? '1' : '2'));

    if(rep=='1'){ document.getElementById('orepresentante_a1').checked=true; }
    else if(rep=='2'){ document.getElementById('orepresentante_a2').checked=true; }

    if(hx=='1'){ document.getElementById('ohechos_ax1').checked=true; }
    else { document.getElementById('ohechos_ax2').checked=true; }

    // Mostrar/ocultar secciones según valores actuales
    representante(rep ? String(rep) : '2');
    ohechos(hx ? String(hx) : '2');
    
    // Actualizar labels de archivos cuando se selecciona un archivo
    var fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo PDF';
            var label = e.target.nextElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.textContent = fileName;
            }
        });
    });
});
</script>
