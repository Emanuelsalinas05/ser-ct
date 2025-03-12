@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ESTRUCTURA DEPARTAMENTOS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                ESTRUCTURA DEPARTAMENTOS
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
                    <th width="40%"></th>
                    <th width="60%"></th>
                </tr> 
            </thead>
            <tbody>
                @foreach($ctdep as $key => $dep)
                <tr >
                    <td width="40%" >
                        @if($dep->idct_departamento==0)
                            SIN DEPARTAMENTO
                        @else
                            {{ $dep->cct_departamento }} - {{ $dep->ctdep->onombre_ct }}
                        @endif
                    </td>

                    <td  width="60%" >
                        <table  class="table table-striped table-hover table-sm"
                                width="100%"
                                style="font-size:12px;">
                            @foreach($ctsec as $key => $sec)
                            @if($sec->idct_departamento==$dep->idct_departamento  )
                            <tr>
                                <td width="80%">
                                    @if($sec->idct_sector==0)
                                        SIN SECTOR
                                    @else
                                        {{ $sec->cct_sector }} - {{ $sec->ctsec->onombre_ct }}
                                    @endif
                                </td>

                                <td width="20%">

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