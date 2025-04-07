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


        <table  class="table table-striped table-sm"
                id="example13"
                style="font-size:13px;">
            <thead class="bg-lightblue">
                <tr>
                    <th>#</th>
                    <th>NOMBRE DEL CENTRO DE TRABAJO</th>
                    <th>DIRECCIÓN</th>
                    <th>DESCRIPCIÓN MODALIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cts as $key => $ct)
                <tr>
                    <td>{{$ct->idct_escuela}}</td>
                    
                    <td>
                        {{ $ct->cct_escuela.' - '.$ct->cct->onombre_ct }}
                    </td>
                    
                    <td>
                        {{ $ct->cct->odireccion }}
                    </td>
                    
                    <td>
                        {{ $ct->cct->desc_modal }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
@stop