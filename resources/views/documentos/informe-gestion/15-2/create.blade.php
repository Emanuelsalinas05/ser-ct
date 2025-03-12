@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '15.1 REGISTRAR INFORME DE GESTIÓN PLANTILLA')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' 15.1 REGISTRAR INFORME DE GESTIÓN PLANTILLA')

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


        <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route('informe-compromisos.store') }}" >
            @method('POST')
            @csrf
            <input  type="hidden" 
                    name="acta" 
                    id="acta"
                    value="{{ $datosacta->id }}">

        <table  class="table  table-sm"
                style="font-size: 13px;">
        <tbody>
            <tr>
                <td align="right">
                    <b>RESPONSABLE:</b>
                </td>
                <td colspan="7">
                    <input type="text" name="oresponsable" id="oresponsable"
                            class="form-control form-control-sm"
                            value="{{ old('oresponsable') }}">                       
                </td>
                <td>
                    @error('oresponsable') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
            </tr>
            <tr>
                <td align="right">
                    <b>DESCRIPCIÓN DEL ASUNTO:</b>
                </td>
                <td colspan="7">
                    <textarea   name="odescripcion_asunto" 
                                id="odescripcion_asunto"
                                class="form-control " rows="6"  
                                style="resize: none; font-size:13px;">{{ old('odescripcion_asunto') }}</textarea>                
                </td>
                <td>
                    @error('odescripcion_asunto') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td align="right">
                    <b>ACCIONES A REALIZAR:</b>
                </td>
                <td colspan="7">
                    <textarea   name="oacciones_realizar" 
                                id="oacciones_realizar"
                                class="form-control " rows="6"  
                                style="resize: none; font-size:13px;">{{ old('oacciones_realizar') }}</textarea>                        
                </td>
                <td>
                    @error('oacciones_realizar') <span style="color:red;">{{ $message }}</span> @enderror
                </td>
            </tr>
            <tr>
                
            </tr>
            <tr>
                <td align="right">
                    <b>LUGAR:</b>
                </td>
                <td colspan="4">
                    <input type="text" name="olugar" id="olugar"
                            class="form-control form-control-sm"
                            value="{{ old('olugar') }}">
                    @error('olugar') <span style="color:red;">{{ $message }}</span> @enderror 
                </td>
                <td align="right">
                    <b>FECHA:</b>
                </td>
                <td>
                    <input type="date" name="ofecha" id="ofecha"
                            class="form-control form-control-sm"
                            value="{{ old('ofecha') }}">
                    @error('ofecha') <span style="color:red;">{{ $message }}</span> @enderror 
                </td>
                <td align="right">
                    <b>HORA:</b>
                </td>
                <td>
                    <input type="time" name="ohora" id="ohora"
                            class="form-control form-control-sm"
                            value="{{ old('ohora') }}">
                    @error('ohora') <span style="color:red;">{{ $message }}</span> @enderror 
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <a  href="{{ url('/informe-compromisos') }}" 
                        class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                        <i class="fa fa-backward"></i>&nbsp;
                        REGRESAR
                    </a>
                </td>
                <td align="right" colspan="9">
                    <button class="btn btn-outline-success btn-sm">
                        GUARDAR COMPROMISO
                        <i class="fa fa-check"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
        </table>
        </form>

        
    </div>
</div>
@stop