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
            <a  href="{{ route('centros-de-trabajo.create') }}" 
                class="btn btn-outline-success tn-sm" style="font-size: 12px;">
                &nbsp; <b>AGREGAR NUEVO CT </b>&nbsp;<i class="fas fa-save"></i>&nbsp;
            </a>
            &nbsp;
        </li>
        <br>

         @if(Auth::user()->orol==1)
        <x-adminlte-callout>
                 <form  name="FrmCartel" id="FrmCartel" 
                        method="get" 
                        action="{{ route('centros-de-trabajo.show', 0 ) }}" >
                        @method('PATCH')
                        @csrf

                    <table class="table table-sm " style="font-size:14px;">
                        <tr>
                            <td align="right" width="25%">
                                <b class="text-info">BUSCAR CENTRO DE TRABAJO</b>
                            </td>
                            <td width="20%">
                                <input  type="text" 
                                        id="elct" name="elct"
                                        class="form-control"
                                        required 
                                        value="{{ old('elct', $requeste) }}" >
                            </td>
                            <td width="25%">
                                <button type="submit" 
                                        class="btn btn-outline-success btn-sm">
                                    VER CT &nbsp;&nbsp;
                                    <i class="fa fa-search"></i>
                                </button>
                            </td>
                            <td width="35%" align="right">
                                <a href="{{ url('/centros-de-trabajo') }}"
                                    class="btn btn-outline-info"
                                    style="font-size:14px;">
                                    VER TODOS LOS CT
                                </a>
                            </td>
                        </tr>
                    </table>
                </form>
        </x-adminlte-callout>
        @endif

        
        <table  class="table table-striped table-sm"
                id="example130"
                style="font-size:13px;">
            <thead class="bg-lightblue">
                <tr align="center">
                    <th>NOMBRE DEL CENTRO DE TRABAJO</th>
                    <th>DESCRIPCIÓN MODALIDAD</th>
                    <th>VALLE</th>
                    <th>SUPERVISION</th>
                    <th>SECTOR</th>
                    <th>DEPARTAMENTO</th>
                    <th>SUBDIRECCIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cts as $key => $ct)
                <tr>
                    <td>
                        {{ $ct->cct_escuela.' - '.$ct->cct->onombre_ct }}
                    </td>
                    <td>
                        {{ $ct->cct->desc_modal }}
                    </td>
                    <td>
                        {{ $ct->ovalle }}
                    </td>

                    <td align="center">
                        @if($ct->cct_supervision<=1)
                            ---
                        @else
                            {{ $ct->cct_supervision }}
                        @endif
                    </td>

                    <td align="center">
                        @if($ct->cct_sector<=1)
                            ---
                        @else
                            {{ $ct->cct_sector }}
                        @endif
                    </td>

                    <td align="center">
                        @if($ct->cct_departamento<=1)
                            ---
                        @else
                            {{ $ct->cct_departamento }}
                        @endif
                    </td>

                    <td align="center">
                        {{ $ct->cct_subdireccion }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        
    </div>
</div>
@stop