@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' CENTROS DE TRABAJO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                CENTROS DE TRABAJO {{ Auth::user()->onivel=='ELEMENTAL' ? 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL' : 'DIRECCIÓN DE EDUCACIÓN SECUNDARIA Y SERVICIOS DE APOYO' }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <li class=" d-flex justify-content-between align-items-center"
            style="border:none;">
            <a  href="{{ url('/centros-de-trabajo') }}" 
                class="btn btn-outline-secondary tn-sm" style="font-size: 12px;">
                <i class="fas fa-backward"></i>&nbsp;
                VOLVER A &nbsp; <b>CT ESCUELAS</b>
            </a>&nbsp;
        </li>
        <br>

                                   
        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('centros-de-trabajo.store') }}"  
                style="font-size:12px;">
        @method('POST')
        @csrf

            <legend style="font-size:14px;" class="text-info">
                <b>REGISTRAR CENTRO DE TRABAJO</b>
            </legend>
                
            <table class="table table-sm col-sm-10" >
                <tr>
                    <td align="right" width="35%">CLAVE DE CENTRO DE TRABAJO
                        
                    </td>
                    <td>
                        <input  type="text" 
                                name="oct" id="oct"
                                class="form-control form-control-sm col-sm-4">
                        @error('oct') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        NOMBRE CENTRO DE TRABAJO
                    </td>
                    <td>
                        <input  type="text" 
                                name="onombrect" id="onombrect"
                                class="form-control form-control-sm">
                        @error('onombrect') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        NIVEL
                    </td>
                    <td><b>ESCUELA</b>
                        <!--
                        <select name="onivel" id="onivel" 
                                class="form-control form-control-sm col-sm-4">
                            <option value="" selected disabled>-- Elije el nivel --</option>
                            <option value="ESCUELA" >ESCUELA</option>
                            <option value="SECTOR" >SECTOR</option>
                            <option value="SUPERVISIÓN" >SUPERVISIÓN</option>
                        </select>
                    -->
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        SUBDIRECCIÓN
                    </td>
                    <td> 
                        <select name="osubdir" id="osubdir" 
                                class="form-control form-control-sm ">
                            <option value="" selected disabled>-- Elije la subdirección --</option>
                            <option value="0" >SIN SUBDIRECCIÓN</option>
                            @foreach($subdirs as $sub)
                                <option value="{{ $sub->idct_subdireccion }}" >
                                    {{ $sub->cct_subdireccion }}  
                                </option>
                            @endforeach
                        </select>
                        @error('osubdir') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        DEPARTAMENTO
                    </td>
                    <td> 
                        <select name="odepto" id="odepto" 
                                class="form-control form-control-sm  ">
                            <option value="" selected disabled>-- Elije el departamento --</option>
                            <option value="0" >SIN DEPARTAMENTO</option>
                            @foreach($deptos as $dep)
                                <option value="{{ $dep->idct_departamento }}" >
                                    {{ $dep->cct_departamento }}  
                                </option>
                            @endforeach
                        </select>
                        @error('odepto') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        SECTOR
                    </td>
                    <td> 
                        <select name="osector" id="osector" 
                                class="selectpicker" 
                                data-live-search="true" style="cursor: pointer;"  
                                data-width="100%"  
                                title="Sector a buscar...">
                            <option value="0" >SIN SECTOR</option>
                            @foreach($sectors as $sect)
                                <option value="{{ $sect->idct_sector }}" 
                                        data-tokens="{{ $sect->cct_sector }}">
                                    {{ $sect->cct_sector }}  
                                </option>
                            @endforeach
                        </select>
                        @error('osector') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        SUPERVISIÓN
                    </td>
                    <td> 

                        <select name="osuper" id="osuper" 
                                class="selectpicker" 
                                data-live-search="true" style="cursor: pointer;"  
                                data-width="100%"  
                                title="Supervisión a buscar..."> 
                            <option value="0" >SIN SUPERVISIÓN</option>
                            @foreach($supers as $sup)
                                <option value="{{ $sup->idct_supervicion }}" 
                                        data-tokens="{{ $sup->cct_supervision }}" >
                                    {{ $sup->cct_supervision }}  
                                </option>
                            @endforeach
                        </select>
                        @error('osuper') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        VALLE
                    </td>
                    <td>
                        <select name="ovalle" id="ovalle" 
                                class="form-control form-control-sm col-sm-4">
                            <option value="" selected disabled>-- Elije el Valle --</option>
                            <option value="MEXICO" >MEXICO</option>
                            <option value="TOLUCA" >TOLUCA</option>
                        </select>
                        @error('ovalle') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        DOMICILIO
                    </td>
                    <td>
                        <input  type="text" 
                                name="odomicilio" id="odomicilio"
                                class="form-control form-control-sm">
                        @error('odomicilio') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        COLONIA
                    </td>
                    <td>
                        <input  type="text" 
                                name="ocolonia" id="ocolonia"
                                class="form-control form-control-sm">
                        @error('ocolonia') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        C.P.
                    </td>
                    <td>
                        <input  type="text" 
                                name="ocp" id="ocp"
                                class="form-control form-control-sm col-sm-4"
                                maxlength="5">
                        @error('ocp') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        TELEFONO
                    </td>
                    <td>
                        <input  type="text" 
                                name="otel" id="otel"
                                class="form-control form-control-sm col-sm-4"
                                maxlength="10">
                        @error('otel') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        CORREO
                    </td>
                    <td>
                        <input  type="text" 
                                name="ocorreo" id="ocorreo"
                                class="form-control form-control-sm col-sm-6">
                        @error('ocorreo') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        MUNICIPIO
                    </td>
                    <td>
                        <input  type="text" 
                                name="ompio" id="ompio"
                                class="form-control form-control-sm">
                        @error('ompio') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                        <button type="submit" 
                                class="btn btn-success btn-sm">
                            GUARDAR CENTRO DE TRABAJO
                        </button>
                    </td>
                </tr>
            </table>
        </form>


        
    </div>
</div>
@stop