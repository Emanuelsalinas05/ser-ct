@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'ACTO DE ENTREGA-RECEPCIÓN')
@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ACTO DE ENTREGA - RECEPCIÓN')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2 justify-content-between ">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-paste"></i>&nbsp;
                    {{ $ban==0 ? '' : $datosacta->tipoacta->otipoacta.'.' }}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive">

        @if($ban==0)

                <x-adminlte-callout theme="info" 
                        title="SELECCIONA EL TIPO DE ENTREGA - RECEPCIÓN A REALIZAR"
                        class="text-info"
                        icon="fa fa-file">
                    <br>
                    <div class="container">
                        <div class="row text-center">
                            @foreach($tipoacta as $acta)
                                <form   name="FrmCartel" id="FrmCartel" method="post" 
                                        action="{{ route('entrega-recepcion.store') }}" >
                                    @method('POST')
                                    @csrf
                                    <input type="hidden" name="tipoacta" value="{{$acta->id}}">
                                        <div class="col-sm">
                                            <button class="btn btn-outline-success btn-sm btn-block shadow"
                                                    type="submit">
                                                <b>{{ $acta->otipoacta }}</b> 
                                            </button>
                                        </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </x-adminlte-callout>


        @elseif($ban==1)

                @if($datosacta->ock==0)

                        <p class="text-info">
                                INGRESA LOS SIGUIENTES DATOS PARA COMENZAR CON EL REGISTRO DEL  {{ $datosacta->tipoacta->otipoacta }}
                        </p>

                        @if($datosacta->id_tipoacta==1)

                            @include('acta.00-form-acta')

                        @elseif($datosacta->id_tipoacta==2)

                            @include('acta.00-form-actac')
                            
                        @endif

                @else
                        <!-- include('acta.00-form-acta') include('acta.00-form-actac') -->
                        @include('acta.01-avances')
                    
                @endif

        @endif 

        

    </div>
</div>
@stop