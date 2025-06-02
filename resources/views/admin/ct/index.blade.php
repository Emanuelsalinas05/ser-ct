@extends('layouts.app')

@section('title', 'CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' CENTROS DE TRABAJO')

@section('content')
    <div class="col-12 card card-secondary card-outline shadow">
        <div class="card-header bg-light shadow-sm d-flex justify-content-between align-items-center mb-2">
            <b>
                <i class="nav-icon fa fa-home"></i>&nbsp;
                CENTROS DE TRABAJO {{ Auth::user()->onivel == 'ELEMENTAL' ? 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL' : 'DIRECCIÓN DE EDUCACIÓN SECUNDARIA Y SERVICIOS DE APOYO' }}
            </b>
        </div>

        <div class="card-body table-responsive">

            {{-- Botón agregar nuevo --}}
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('centros-de-trabajo.create') }}" class="btn btn-outline-success btn-sm">
                    <i class="fas fa-plus"></i> Agregar nuevo CT
                </a>
            </div>

            {{-- Filtro visible solo para rol 1 --}}
            @if(Auth::user()->orol == 1)
                <x-adminlte-callout>
                    <form method="GET" action="{{ route('centros-de-trabajo.show', 0) }}" class="row g-2 align-items-center">
                        @method('PATCH')
                        @csrf
                        <div class="col-md-3 text-end">
                            <label for="elct" class="col-form-label text-info fw-bold">Centro de trabajo:</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="elct" id="elct" class="form-control" required value="{{ old('elct') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                <i class="fa fa-search"></i> Buscar CT
                            </button>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="{{ url('/centros-de-trabajo') }}" class="btn btn-outline-info btn-sm w-100">
                                Ver todos los CT
                            </a>
                        </div>
                    </form>
                </x-adminlte-callout>
            @endif

            {{-- Tabla --}}
            <table class="table table-striped table-bordered table-sm text-center align-middle" id="example130" style="font-size:13px;">
                <thead class="bg-lightblue">
                <tr>
                    <th>Nombre del centro de trabajo</th>
                    <th>Descripción modalidad</th>
                    <th>Valle</th>
                    <th>Supervisión</th>
                    <th>Sector</th>
                    <th>Departamento</th>
                    <th>Subdirección</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cts as $ct)
                    <tr>
                        <td class="text-start">{{ $ct->cct_escuela }} - {{ $ct->cct->onombre_ct }}</td>
                        <td>{{ $ct->cct->desc_modal }}</td>
                        <td>{{ $ct->ovalle }}</td>
                        <td>{{ $ct->cct_supervision > 1 ? $ct->cct_supervision : '---' }}</td>
                        <td>{{ $ct->cct_sector > 1 ? $ct->cct_sector : '---' }}</td>
                        <td>{{ $ct->cct_departamento > 1 ? $ct->cct_departamento : '---' }}</td>
                        <td>{{ $ct->cct_subdireccion }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="d-flex justify-content-center">
                {{ $cts->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
