@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'REGISTRO DE USUARIOS')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REGISTGRO DE USUARIOS')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-users"></i>&nbsp;
                REGISTRO DE USUARIOS 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >

        <form   name="FrmCartel" id="FrmCartel" method="post" 
                action="{{ route('usuarios.store') }}" >
        @method('POST')
        @csrf
        <table  class="table table-sm"
                style="font-size:14px;"
                id="example13">
            <tbody>
                <tr>
                    <td align="right"><b>* CENTRO DE TRABAJO</b></td>
                    <td colspan="3">
                        <select id="oct" 
                                name="oct"
                                class="selectpicker" 
                                data-live-search="true" style="cursor: pointer;"  
                                data-width="500" required 
                                title="Escribe el CT ">
                            @foreach($centrotrabajo as $ct)
                            <option value="{{$ct->id}}">
                                {{$ct->oclave.' - '.$ct->onombre_ct}}
                            </option>
                            @endforeach
                        </select>
                        @error('oct') <span style="color:red;">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>* TIPO DE USUARIO</b></td>
                    <td colspan="3">
                        USUARIO DE ENTREGA-RECEPCIÓN
                        <!--
                        <select id="orol" 
                                name="orol"
                                class="selectpicker" 
                                data-live-search="true" style="cursor: pointer;"  
                                data-width="500" required 
                                title="Elije el tipo de usuario ">
                            @foreach($roles as $rol)
                            <option value="{{$rol->id}}">
                                {{$rol->orol.' - ('.$rol->odescripcion.')'}}
                            </option>
                            @endforeach
                        </select>
                        @error('orol') <span style="color:red;">{{ $message }}</span> @enderror
                    -->
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" align="center">
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            style="border: none;">
                            <a  href="/usuarios"
                                class="btn btn-secondary btn-sm col-sm-2">
                                <i class="fas fa-reply-all"></i>
                                Regresar
                            </a>
                            <button type="submit"
                                class="btn btn-outline-dark bg-teal btn-sm">
                            CREAR USUARIO&nbsp;
                            <i class="fa fa-save"></i>
                        </button>
                        </li>
                    </td>
                </tr>
            </tfoot>
        </table>
        </form>
<br><br><br><br><br>
        
    </div>
</div>
@stop