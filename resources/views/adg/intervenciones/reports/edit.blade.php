@extends('layouts.app')

@section('title', 'REPORTES DE INTERVENCIÓN ')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' REPORTES DE INTERVENCIÓN ')

@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-file-alt"></i>&nbsp; REPORTES DE INTERVENCIÓN</b>
        </div>
    </div>

    <div class="card-body table-responsive">
        @if($intervencionesc > 0)
            <table class="table table-sm table-striped table-bordered" style="font-size:12px;">
                <thead class="bg-lightblue disabled" align="center">
                    <tr>
                        <th>UNIDAD ADMINISTRATIVA</th>
                        <th>FECHA DEL REPORTE</th>
                        <th>FORMATO GENERADO (SIN FIRMA)</th>
                        <th>FORMATO ESCANEADO</th>
                        <th>CANCELAR</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($intervenciones as $i)
                    @php($finId = \Illuminate\Support\Str::slug($i->ofechafin, '_'))
                    <tr>
                        <td width="40%">{{ $i->oct_nivel.' - '.$i->onivel_educativo }}</td>
                        <td width="15%" align="center">{{ $i->fechaentrega }}</td>

                        <td width="20%" align="center">
                            <a  href="https://entregasrecepcion.seiem.gob.mx/reportes/intervencionx0.php?id3p={{ $i->idct_departamento }}&f3c4={{ $i->ofechafin }}"
                                class="btn btn-outline-info btn-xs" target="_blank" style="font-size:12px;">
                                VER &nbsp;<i class="fa fa-file-alt"></i>
                            </a>
                        </td>

                        <td width="15%" align="center">
                            @if($i->ofile == 0)
                                @if(Auth::user()->ocargo=='SUBDIRECCIÓN' || Auth::user()->ocargo=='DEPARTAMENTO')
                                    <x-adminlte-button
                                        data-bs-toggle="modal" data-toggle="modal"
                                        data-bs-target="#modaldeditx{{ $finId }}" data-target="#modaldeditx{{ $finId }}"
                                        icon="fa fa-plus" label="CARGAR ARCHIVO" class="bg-warning btn-xs"/>
                                    @include('adg.intervenciones.reports.modal-carga', ['finId'=>$finId, 'i'=>$i])
                                @else
                                    <b class="text-warning" style="font-size:10px;">EN ESPERA DE NOTIFICAR A LA DEE</b>
                                @endif
                            @else
                                <a  href="https://entregasrecepcion.seiem.gob.mx/{{ $i->ourl }}"
                                    class="btn btn-outline-dark btn-xs" target="_blank" style="font-size:12px;">
                                    VER &nbsp;<i class="fa fa-file"></i>
                                </a>
                            @endif
                        </td>

                        <td width="10%" align="center">
                            @if($i->ofile == 0)
                                @if(Auth::user()->ocargo=='SUBDIRECCIÓN' || Auth::user()->ocargo=='DEPARTAMENTO')
                                    <x-adminlte-button
                                        data-bs-toggle="modal" data-toggle="modal"
                                        data-bs-target="#modaldedit{{ $finId }}" data-target="#modaldedit{{ $finId }}"
                                        icon="fa fa-minus" class="bg-danger btn-xs"/>
                                    @include('adg.intervenciones.reports.modal-edit', ['finId'=>$finId, 'i'=>$i])
                                @else
                                    <b class="text-warning" style="font-size:12px;">-----</b>
                                @endif
                            @else
                                <i class="text-success">ARCHIVO CARGADO</i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <center><h3><b class="text-warning">AÚN NO HAY REPORTES DE INTERVENCIONES</b></h3></center>
        @endif
    </div>
</div>

{{-- Fallback para BS4/BS5: abre/cierra modales aunque falten data-* correctos --}}
@push('js')
<script>
document.addEventListener('click', function(e){
  const t = e.target.closest('[data-bs-target],[data-target]');
  if(!t) return;
  const sel = t.getAttribute('data-bs-target') || t.getAttribute('data-target');
  const el = document.querySelector(sel);
  if(!el) return;
  if (window.bootstrap && bootstrap.Modal) {
    bootstrap.Modal.getOrCreateInstance(el).show();
  } else if (window.$ && $.fn.modal) {
    $(el).modal('show');
  }
});
document.querySelectorAll('[data-bs-dismiss="modal"],[data-dismiss="modal"]').forEach(btn=>{
  btn.addEventListener('click', function(){
    const m = btn.closest('.modal');
    if(!m) return;
    if (window.bootstrap && bootstrap.Modal) {
      bootstrap.Modal.getOrCreateInstance(m).hide();
    } else if (window.$ && $.fn.modal) {
      $(m).modal('hide');
    }
  });
});
</script>
@endpush
@endsection
