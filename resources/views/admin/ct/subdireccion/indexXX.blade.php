@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ESTRUCTURA CENTROS DE TRABAJO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                ESTRUCTURA CENTROS DE TRABAJO {{ Auth::user()->onivel=='ELEMENTAL' ? 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL' : 'DIRECCIÓN DE EDUCACIÓN SECUNDARIA Y SERVICIOS DE APOYO' }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <table  class="table table-striped table-sm"
                id="example130"
                style="font-size:13px;">
            <thead class="bg-lightblue"> 
                <tr >
                    <th width="25%">SUBDIRECCIÓN</th>
                    <th colspan="3" width="75%">
                    </th>
                </tr> 
            </thead>
            <tbody>
                @foreach($ctsub as $key => $sub)
                <tr>
                    <td width="25%">
                        {{ $sub->cct_subdireccion }} - {{ $sub->ctsub->onombre_ct }}
                    </td>

                    <td colspan="3" width="75%" >
                        <table class="table table-sm">
                            @foreach($ctdep as $key => $dep)
                            @if($dep->idct_subdireccion==$sub->idct_subdireccion)
                            <tr>
                                <td width="50%">
                                    {{ $dep->cct_departamento }} - {{ $dep->ctdep->onombre_ct }}
                                </td>

                                <td width="50%">
                                    <table class="table table-striped table-hover"
                                            width="100%">
                                        @foreach($ctsec as $key => $sec)
                                        @if($sec->idct_departamento==$dep->idct_departamento && $sec->idct_subdireccion==$sub->idct_subdireccion && $sec->idct_sector>1)
                                        <tr>
                                            <td width="50%">
                                                {{ $sec->cct_sector }} - {{ $sec->ctsec->onombre_ct }}
                                            </td>

                                            <td width="50%">
                                                <table class="table table-striped table-hover"
                                                        width="100%">
                                                    @foreach($ctsup as $key => $sup)
                                                    @if($sup->idct_subdireccion==$sub->idct_subdireccion || $sup->idct_departamento==$dep->idct_departamento || $sup->idct_sector==$sec->idct_sector && $sec->idct_supervicion>1)
                                                    <tr>
                                                        <td width="100%">
                                                            {{ $sup->cct_supervision }} - {{ $sup->ctsup->onombre_ct }}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $ctsub->links('vendor.pagination.bootstrap-5') }}

    </div>
</div>
@stop