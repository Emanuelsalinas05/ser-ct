@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', '8. SITUACIÓN DE LOS RECURSOS MATERIALES')
@section('content_header_title', 'Home')
@section('content_header_subtitle', '  <?php echo "2";?>REGISTRO DE RECURSOS MATERIALES')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                {{$anexo->onum_anexo.'. '.$anexo->oanexo}}
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive" >




        
    </div>
</div>
@stop