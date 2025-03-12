@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ESTRUCTURA SECTOR')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                ESTRUCTURA SUPERVISIONES
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <table  class="table-striped table-sm"
                id="example130"
                style="font-size:12px;">
            <thead class="bg-lightblue"> 
                <tr >
                    <th width="25%"></th>
                    <th colspan="3" width="75%">
                    </th>
                </tr> 
            </thead>
            <tbody>
                @foreach($ctsub as $key => $sub)
                <tr >
                    <td width="25%" >
                        {{ $sub->cct_subdireccion }} - {{ $sub->ctsub->onombre_ct }}
                    </td>

                    <td colspan="3" width="75%" >
                        <table  class=" table-sm"
                                width="100%"
                                style="font-size:12px;">
                            @foreach($ctdep as $key => $dep)
                            @if($dep->idct_subdireccion==$sub->idct_subdireccion)
                            <tr>
                                <td width="50%">
                                    @if($dep->idct_departamento==0)
                                        SIN DEPARTAMENTO
                                    @else
                                        {{ $dep->cct_departamento }} - {{ $dep->ctdep->onombre_ct }}
                                    @endif
                                </td>

                                <td width="50%">
                                    <table  class="table table-striped table-hover"
                                            style="font-size:12px;"
                                            width="100%">
                                        @foreach($ctsec as $key => $sec)
                                        @if($sec->idct_departamento==$dep->idct_departamento && $sec->idct_subdireccion==$sub->idct_subdireccion )
                                        <tr>
                                            <td width="90%">
                                                @if($sec->idct_sector==0)
                                                    SIN SECTOR
                                                @else
                                                    {{ $sec->cct_sector }} - {{ $sec->ctsec->onombre_ct }}
                                                @endif
                                            </td>
                                            <td width="10%">
                                               
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