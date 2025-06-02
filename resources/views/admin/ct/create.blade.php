@extends('layouts.app')

@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'CENTROS DE TRABAJO')

@section('content')
    <div class="col-12 card card-secondary card-outline shadow">
        <div class="card-header bg-light shadow-sm d-flex justify-content-between align-items-center">
            <b>
                <i class="nav-icon fa fa-home"></i>&nbsp;
                CENTROS DE TRABAJO {{ Auth::user()->onivel == 'ELEMENTAL' ? 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL' : 'DIRECCIÓN DE EDUCACIÓN SECUNDARIA Y SERVICIOS DE APOYO' }}
            </b>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <a href="{{ url('/centros-de-trabajo') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Volver a CT Escuelas
                </a>
            </div>

            <form name="FrmCartel" id="FrmCartel" method="POST" action="{{ route('centros-de-trabajo.store') }}">
                @csrf

                <legend class="text-info fw-bold mb-3">REGISTRAR CENTRO DE TRABAJO</legend>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="oct" class="form-label">Clave de centro de trabajo</label>
                        <input type="text" name="oct" id="oct" class="form-control form-control-sm" value="{{ old('oct') }}">
                        @error('oct') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-8">
                        <label for="onombrect" class="form-label">Nombre del centro de trabajo</label>
                        <input type="text" name="onombrect" id="onombrect" class="form-control form-control-sm" value="{{ old('onombrect') }}">
                        @error('onombrect') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="ovalle" class="form-label">Valle</label>
                        <select name="ovalle" id="ovalle" class="form-control form-control-sm">
                            <option disabled selected>-- Selecciona --</option>
                            <option value="MEXICO">MÉXICO</option>
                            <option value="TOLUCA">TOLUCA</option>
                        </select>
                        @error('ovalle') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="osubdir" class="form-label">Subdirección</label>
                        <select name="osubdir" id="osubdir" class="form-control form-control-sm">
                            <option disabled selected>-- Selecciona --</option>
                            <option value="0">SIN SUBDIRECCIÓN</option>
                            @foreach($subdirs as $sub)
                                <option value="{{ $sub->idct_subdireccion }}">{{ $sub->cct_subdireccion }}</option>
                            @endforeach
                        </select>
                        @error('osubdir') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="odepto" class="form-label">Departamento</label>
                        <select name="odepto" id="odepto" class="form-control form-control-sm">
                            <option disabled selected>-- Selecciona --</option>
                            <option value="0">SIN DEPARTAMENTO</option>
                            @foreach($deptos as $dep)
                                <option value="{{ $dep->idct_departamento }}">{{ $dep->cct_departamento }}</option>
                            @endforeach
                        </select>
                        @error('odepto') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="osector" class="form-label">Sector</label>
                        <select name="osector" id="osector" class="form-select selectpicker" data-live-search="true" title="Buscar sector...">
                            <option value="0">SIN SECTOR</option>
                            @foreach($sectors as $sect)
                                <option value="{{ $sect->idct_sector }}">{{ $sect->cct_sector }}</option>
                            @endforeach
                        </select>
                        @error('osector') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="osuper" class="form-label">Supervisión</label>
                        <select name="osuper" id="osuper" class="form-select selectpicker" data-live-search="true" title="Buscar supervisión...">
                            <option value="0">SIN SUPERVISIÓN</option>
                            @foreach($supers as $sup)
                                <option value="{{ $sup->idct_supervicion }}">{{ $sup->cct_supervision }}</option>
                            @endforeach
                        </select>
                        @error('osuper') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-8">
                        <label for="odomicilio" class="form-label">Domicilio</label>
                        <input type="text" name="odomicilio" id="odomicilio" class="form-control form-control-sm" value="{{ old('odomicilio') }}">
                        @error('odomicilio') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="ocolonia" class="form-label">Colonia</label>
                        <input type="text" name="ocolonia" id="ocolonia" class="form-control form-control-sm" value="{{ old('ocolonia') }}">
                        @error('ocolonia') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="ocp" class="form-label">C.P.</label>
                        <input type="text" name="ocp" id="ocp" class="form-control form-control-sm" maxlength="5" value="{{ old('ocp') }}">
                        @error('ocp') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="otel" class="form-label">Teléfono</label>
                        <input type="text" name="otel" id="otel" class="form-control form-control-sm" maxlength="10" value="{{ old('otel') }}">
                        @error('otel') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ocorreo" class="form-label">Correo</label>
                        <input type="email" name="ocorreo" id="ocorreo" class="form-control form-control-sm" value="{{ old('ocorreo') }}">
                        @error('ocorreo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ompio" class="form-label">Municipio</label>
                        <input type="text" name="ompio" id="ompio" class="form-control form-control-sm" value="{{ old('ompio') }}">
                        @error('ompio') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save"></i> Guardar centro de trabajo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
