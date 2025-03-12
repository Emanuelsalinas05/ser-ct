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
                @foreach($supervision as $key => $sup)
                <tr>
                    <td width="30%">
                        {{ $sup->cct_supervision }}
                    </td>

                    <td width="70%">

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        

            

        

    </div>
</div>
@stop