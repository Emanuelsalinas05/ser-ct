@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'MODIFICAR INFORME DE GESTIÓN PLANTILLA')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' MODIFICAR INFORME DE GESTIÓN PLANTILLA')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                {{ ' MODIFICAR '.$anexo->oanexo}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >


        <form   name="FrmCartel" id="FrmCartel" method="post" 
                        action="{{ route($documento->ourl_documentos.'.update', $igestion->id ) }}" >
            @method('PATCH')
            @csrf
            
            <input  type="hidden" 
                    name="action" 
                    id="action"
                    value="0">

        <table  class="table table-striped table-sm"
                style="font-size: 13px;">
        <thead>
        <tbody>
            <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>{{$igestion->roi}}</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea   name="oi" 
                                id="oi"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oi', $igestion->oi) }}</textarea>
                    @error('oi') <span style="color:red;">{{ $message }}</span> @enderror                
                </td>
            </tr>
             <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>{{$igestion->roii}}</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea   name="oii" 
                                id="oii"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oii', $igestion->oii) }}</textarea> 
                    @error('oii') <span style="color:red;">{{ $message }}</span> @enderror                       
                </td>
            </tr>
            <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>{{$igestion->roiii}}</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <textarea   name="oiii" 
                                id="oiii"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oiii', $igestion->oiii) }}</textarea>  
                    @error('oiii') <span style="color:red;">{{ $message }}</span> @enderror                      
                </td>
            </tr>
            <tr class="text-secondary">
                <td style="text-align: justify;">
                    <p>
                    <b>{{$igestion->roiv}}</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                     <textarea   name="oiv" 
                                id="oiv"
                                class="form-control " rows="6"  minlength="50" 
                                style="resize: none; font-size:13px;">{{ old('oiv', $igestion->oiv) }}</textarea>  
                    @error('oiv') <span style="color:red;">{{ $message }}</span> @enderror 
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="right">
                    <button class="btn btn-outline-success btn-sm">
                        MODIFICAR REGISTRO
                    </button>
                </td>
            </tr>
        </tfoot>
        </table>
        </form>

        
    </div>
</div>
@stop