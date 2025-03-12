@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '15.1 REGISTRAR INFORME DE GESTIÓN ')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 15.1 REGISTRAR INFORME DE GESTIÓN ')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                {{$anexo->onum_anexo.'. REGISTRAR '.$anexo->oanexo}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/informe-gestion-plantilla') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>15.1 INFORME DE GESTIÓN </b>
            </a>&nbsp;
        </li>
        <br>
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('informe-gestion-plantilla.store') }}" >
            @method('POST')
            @csrf
            <input  type="hidden" 
                    name="acta" 
                    id="acta"
                    value="{{ $datosacta->id }}">

        <table  class="table table-striped table-sm"
                style="font-size: 13px;">
        <tbody>
            <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>I.  ACTIVIDADES Y FUNCIONES (DESCRIPCIÓN DE LAS ACTIVIDADES Y TEMAS ENCOMENDADOS A LA PERSONA SERVIDORA PÚBLICA, QUE FUERON ATENDIDOS DURANTE SU GESTIÓN, RELACIONADOS CON LAS FACULTADES O FUNCIONES QUE LE CORRESPONDAN):</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea   name="oi" 
                                id="oi"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oi') }}</textarea>
                    @error('oi') <span style="color:red;">{{ $message }}</span> @enderror                
                </td>
            </tr>
             <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>II. RESULTADO DE LOS PROGRAMAS, PROYECTOS, ESTRATEGIAS Y ASPECTOS RELEVANTES O PRIORITARIOS (EN ESTE APARTADO SE DEBERÁ SEÑALAR EL GRADO DE CUMPLIMIENTO CUANTITATIVO, CON LA JUSTIFICACIÓN CORRESPONDIENTE QUE EXPLIQUE EL NIVEL ALCANZADO Y LAS RAZONES DE AQUELLO QUE QUEDÓ PENDIENTE DE ALCANZAR SOBRE LOS OBJETIVOS, METAS, POLÍTICAS, PROGRAMAS, PROYECTOS, ESTRATEGIAS Y ASPECTOS RELEVANTES O PRIORITARIOS QUE CORRESPONDAN AL ÁREA O FUNCIONES DE LA PERSONA QUE ENTREGA):</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea   name="oii" 
                                id="oii"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oii') }}</textarea> 
                    @error('oii') <span style="color:red;">{{ $message }}</span> @enderror                       
                </td>
            </tr>
            <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>III. PRINCIPALES LOGROS ALCANZADOS (SE DEBERÁ SEÑALAR LOS PRINCIPALES LOGROS ALCANZADOS Y SUS IMPACTOS, IDENTIFICANDO LOS PROGRAMAS, PROYECTOS O ACCIONES QUE SE CONSIDEREN DEBAN TENER CONTINUIDAD CON LA JUSTIFICACIÓN CORRESPONDIENTE, ASÍ COMO INDICAR LAS RECOMENDACIONES O PROPUESTAS DE POLÍTICAS Y ESTRATEGIAS QUE CONTRIBUYAN A SU SEGUIMIENTO):</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea   name="oiii" 
                                id="oiii"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oiii') }}</textarea>  
                    @error('oiii') <span style="color:red;">{{ $message }}</span> @enderror                      
                </td>
            </tr>
            <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>IV. TEMAS PRIORITARIOS, PRINCIPALES PROBLEMÁTICAS Y ESTADO QUE GUARDAN LOS ASUNTOS (SE DEBERÁ IDENTIFICAR LAS PRINCIPALES PROBLEMÁTICAS Y TEMAS PRIORITARIOS, SEÑALANDO EL GRADO DE ATENCIÓN DE LOS MISMOS, LOS PLAZOS O FECHAS DE VENCIMIENTO, EL PRESUPUESTO AUTORIZADO, LA ÚLTIMA ACTIVIDAD REALIZADA SOBRE LOS MISMOS, INDICANDO LA FECHA Y LAS RECOMENDACIONES A SEGUIR. SE DEBERÁ REPORTAR EL ESTADO DE LOS ASUNTOS A CARGO SEÑALANDO LOS QUE SE ENCUENTRAN CONCLUIDOS, EN PROCESO Y AQUELLOS QUE OCURREN CON CIERTA PERIODICIDAD, ASÍ COMO LOS QUE REQUIEREN DE ATENCIÓN ESPECIAL E INMEDIATA EN EL MOMENTO DE LA ENTREGA):</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                     <textarea   name="oiv" 
                                id="oiv"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oiv') }}</textarea>  
                    @error('oiv') <span style="color:red;">{{ $message }}</span> @enderror 
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="right">
                    <button class="btn btn-outline-success btn-sm">
                        GUARDAR REGISTRO
                    </button>
                </td>
            </tr>
        </tfoot>
        </table>
        </form>

        
    </div>
</div>
@stop