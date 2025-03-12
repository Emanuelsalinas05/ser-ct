@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ESTRUCTURA SUPERVISIONES')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                ESTRUCTURA SECTORES
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <table  class="table  table-sm"
                width="100%" 
                id="example13"
                style="font-size:12px;">
            <thead class="bg-lightblue"> 
                <tr >
                    <th width="50%"></th>
                    <th  width="50%"> </th>
                </tr> 
            </thead>
            <tbody>
                @foreach($ctsec as $key => $sec)
                <tr >
                    <td width="50%" >
                        @if($sec->idct_sector==0)
                            SIN SECTOR
                        @else
                            {{ $sec->cct_sector }} - {{ $sec->ctsec->onombre_ct }}
                        @endif

                        
                    </td>
                    <td width="50%">
                        <table class="table table-striped table-hover"
                                width="100%">
                            @foreach($ctsup as $key => $sup)
                            @if($sup->idct_subdireccion==$sec->idct_subdireccion || $sup->idct_departamento==$sec->idct_departamento || $sup->idct_sector==$sec->idct_sector && $sec->idct_supervicion>1)
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
                @endforeach
            </tbody>
        </table>
        

    </div>
</div>
@stop