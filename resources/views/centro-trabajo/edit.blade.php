@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'Actualizar datos Centro de Trabajo')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' Actualizar datos del Centro de Trabajo')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                {{$datas_ct->oclave.' | '.$datas_ct->onombre_ct}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" style="font-size:14px;">

        <x-adminlte-callout title="INFORMATION DEL CENTRO DE TRABAJO"
                            icon="fa fa-home"
                            class="text-info">

            <form   name="FrmCartel" id="FrmCartel" 
                    method="post" 
                    action="{{ route('centro-trabajo.update', $datas_ct->id ) }}" >
                @method('PATCH')
                @csrf
                
                <table class="table table-hover table-sm" 
                    style="color:black;">
                <tbody>
                    <tr>
                        <td align="right"><b>DIRECCIÓN</b></td>
                        <td>{{$datas_ct->odireccion}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>MODALIDAD</b></td>
                        <td>{{$datas_ct->desc_modal}} &nbsp;&nbsp;|&nbsp;&nbsp; {{$datas_ct->omodalidad}} </td>
                    </tr>
                    <tr>
                        <td align="right"><b>C.T.</b></td>
                        <td>{{$datas_ct->oclave}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>NOMBRE</b></td>
                        <td>{{$datas_ct->onombre_ct}}</td>
                    </tr>
                    <tr>
                        <td align="right"><b>CALLE Y NÚMERO</b></td>
                        <td>
                            <input  type="text" name="callenumero" id="callenumero"
                                    class="form-control form-control-sm"
                                    value="{{ old('callenumero', $datas_ct->odomicilio) }}">
                            @error('callenumero') <span style="color:red;">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>COLONIA</b></td>
                        <td>
                            <input  type="text" name="colonia" id="colonia"
                                    class="form-control form-control-sm"
                                    value="{{ old('colonia', $datas_ct->onombre_col) }}">
                            @error('colonia') <span style="color:red;">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>C.P</b></td>
                        <td>
                            <input  type="text" name="codigopostal" id="codigopostal"
                                    class="form-control form-control-sm"
                                    maxlength="5" 
                                    onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                    value="{{ old('codigopostal', $datas_ct->ocodigopostal) }}"
                                    style="width: 150px;">
                            @error('codigopostal') <span style="color:red;">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>MUNICIPIO</b></td>
                        <td>
                            <input  type="text" name="nombre_mun" id="nombre_mun"
                                    class="form-control form-control-sm"
                                    value="{{ old('nombre_mun', $datas_ct->nombre_mun) }}" >
                            @error('telefono') <span style="color:red;">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>LOCALIDAD</b></td>
                        <td>
                            <input  type="text" name="nombre_loc" id="nombre_loc"
                                    class="form-control form-control-sm" 
                                    value="{{ old('nombre_loc', $datas_ct->nombre_loc) }}" >
                            @error('telefono') <span style="color:red;">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><b>Tel.</b></td>
                        <td>
                            <input  type="text" name="telefono" id="telefono"
                                    class="form-control form-control-sm"
                                    maxlength="5" 
                                    onkeypress="if(event.keyCode<45 || event.keyCode>57) event.returnValue=false;"
                                    value="{{ old('telefono', $datas_ct->otelefono) }}"
                                    style="width: 150px;">
                            @error('telefono') <span style="color:red;">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <a  href="{{ url('centro-trabajo') }}" 
                                class="btn btn-outline-secondary btn-sm"
                                style="text-decoration: none;">
                                <i class="fas fa-reply-all"></i>&nbsp;
                                REGRESAR
                            </a>
                        </td>
                        <td align="right">
                            <button class="btn btn-success btn-sm">
                                GUARDAR CAMBIOS&nbsp;
                                <i class="fa fa-check"></i>
                            </button>
                        </td>
                    </tr>
                </tfoot>
                </table>
            </form>
        </x-adminlte-callout>

                

        
    </div>
</div>
@stop