@extends('layouts.app')

@section('title', 'Editar Documento')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Editar Documento del Inventario de Equipo de Cómputo')

@section('content')
<div class="col-12 card card-outline card-primary shadow">
    <div class="card-header">
        <h5 class="m-0">Editar Documento</h5>
    </div>
    <div class="card-body">

        <form method="POST"
              action="{{ route('inventario-equipo.actualizar', $inventario->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="onombre_documento">Nombre del Documento</label>
                <input type="text"
                       class="form-control"
                       name="onombre_documento"
                       value="{{ $inventario->onombre_documento }}"
                       required>
            </div>

            <div class="form-group">
                <label for="onombre_archivo">Archivo (opcional)</label>
                <input type="file"
                       class="form-control"
                       name="onombre_archivo">
                <small class="form-text text-muted">Archivo actual: {{ $inventario->oarchivo_adjunto }}</small>
            </div>

            <button type="submit" class="btn btn-success">
                Guardar Cambios
            </button>
            <a href="{{ route('documentos.situacion-tics.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>

    </div>
</div>
@endsection
