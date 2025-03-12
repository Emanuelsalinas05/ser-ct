@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ESTRUCTURA SUBDIRECCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-home"></i>&nbsp;
                ESTRUCTURA SUBDIRECCIÓN 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <table class="table table-sm"
                style="font-size:12px;">
            <thead>
                <tr>
                    <th>SUBDIRECCIÓN</th>
                    <th>DEPARTAMENTO</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($subdireccion as $key => $sub)
                <tr>
                    <td width="30%">
                        {{ $sub->cct_subdireccion.' - '.$sub->onombre_ct }}
                    </td>

                    <td width="70%">

                            <table class=" table-sm" width="100%">
                                @foreach($departamento as $key => $dep)
                                @if($sub->idct_subdireccion==$dep->idct_subdireccion)
                                <tr>
                                    <td width="40%">
                                            {{ $dep->cct_departamento!=1 ? $dep->cct_departamento.' - '.$dep->onombre_ct : '' }}
                                    </td>
                                    <td width="60%">
                                            <table class=" table-sm" width="100%">
                                                @foreach($sector as $key => $sec)
                                                @if($sec->idct_departamento==$dep->idct_departamento&&$sec->idct_subdireccion==$dep->idct_subdireccion)
                                                <tr>
                                                    <td width="90%">
                                                            {{ $sec->cct_sector!=1 ? $sec->cct_sector.' - '.$sec->onombre_ct : '' }}
                                                    </td>
                                                    <td width="10%">
                                                            <a  href="{{ route('estructura-elemental.edit', $sec->cct_sector) }}" 
                                                                class="btn btn-outline-info btn-xs"
                                                                title="ESTRUCTURADE {{ $sec->cct_sector.' '.$sec->idct_sector }}">
                                                                ESTRUCTURA
                                                            </a>
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
        
        

            

        

    </div>
</div>
@stop