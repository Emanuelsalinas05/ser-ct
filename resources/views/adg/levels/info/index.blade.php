@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'SOLICITUD DE INTERVENCIONES')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' SOLICITUD DE INTERVENCIONES')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp;
                SOLICITUD DE INTERVENCIONES 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <table  class="table table-sm table-striped"
                style="font-size:12px;">
            <thead  class="bg-lightblue disabled"
                    align="center">
                <tr>
                    <th>
                        ESTRUCTUDA DE LA  {{ Auth::user()->onivel=='ELEMENTAL' ? 'DEE' : 'DESySA' }}
                    </th>
                    <th>
                        INFORMACIÓN
                    </th>

                    <th> 
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($subdep as $key => $sd)
                <tr>
                    <td width="70%"
                        align="right">
                        {{ $sd->oclave }} - {{ $sd->onombre_ct }}  
                    </td>
                    
                    <td width="10%"
                        align="center">
                            <a href="{{ route('informacion-niveles.edit', $sd->id_ct) }}"
                                class="btn btn-outline-info btn-xs"
                                style="font-size:12px;">
                                editar &nbsp; <i class="fa fa-edit"></i>
                            </a>
                    </td>

                    <td width="20%"
                        align="center">

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        

    </div>
</div>
@stop