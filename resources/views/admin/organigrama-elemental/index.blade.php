@extends('layouts.app')

@section('title', 'ORGANIGRAMA ELEMENTAL')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'ORGANIGRAMA ELEMENTAL')

@section('content')
<div class="col-12 card card-secondary card-outline shadow">
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between w-100 align-items-center">
            <b><i class="nav-icon fa fa-sitemap"></i>&nbsp; ORGANIGRAMA ELEMENTAL</b>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <x-adminlte-callout theme="success" title="Listo" icon="fas fa-check">
                {{ session('success') }}
            </x-adminlte-callout>
        @endif
        @if(session('error'))
            <x-adminlte-callout theme="danger" title="Error" icon="fas fa-times">
                {{ session('error') }}
            </x-adminlte-callout>
        @endif

        {{-- Formulario de búsqueda --}}
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-search"></i> Búsqueda de Organigrama</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('organigrama-elemental.buscar') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cct"><strong>CCT (Clave de Centro de Trabajo)</strong></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="cct" 
                                       name="cct" 
                                       value="{{ $cct ?? '' }}"
                                       placeholder="Ejemplo: 15ADG0088L-2" 
                                       required>
                                <small class="form-text text-muted">Ingresa la clave completa del centro de trabajo</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_busqueda"><strong>Tipo de Búsqueda</strong></label>
                                <select class="form-control" id="tipo_busqueda" name="tipo_busqueda" required>
                                    <option value="responsabilidad" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'responsabilidad') ? 'selected' : '' }}>
                                        Usuarios bajo responsabilidad
                                    </option>
                                    <option value="superiores" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'superiores') ? 'selected' : '' }}>
                                        Cadena de mando (superiores)
                                    </option>
                                </select>
                                <small class="form-text text-muted">
                                    <strong>Responsabilidad:</strong> Muestra usuarios bajo su responsabilidad<br>
                                    <strong>Superiores:</strong> Muestra la cadena de mando desde la escuela
                                </small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Resultados de búsqueda --}}
        @if(isset($resultado))
            @if($resultado['tipo'] === 'responsabilidad')
                {{-- Mostrar usuarios bajo responsabilidad --}}
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-users"></i> 
                            Usuarios bajo responsabilidad de: 
                            <strong>{{ $resultado['centro_principal']['clave'] }} - {{ $resultado['centro_principal']['nombre'] }}</strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Total de usuarios:</strong> {{ $resultado['total_usuarios'] }} | 
                            <strong>Total de centros:</strong> {{ $resultado['total_centros'] }}
                        </div>

                        @if(isset($resultado['centros_paginados']) && $resultado['centros_paginados']->count() > 0)
                            {{-- Mostrar solo los centros de la página actual --}}
                            @foreach($resultado['centros_paginados'] as $centro)
                                @php
                                    $idCt = $centro->kcvect;
                                    $usuariosCt = isset($resultado['usuarios'][$idCt]) ? $resultado['usuarios'][$idCt] : collect();
                                @endphp
                                <div class="card card-outline card-info mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-building"></i> 
                                            <strong>{{ $centro->onombre_ct ?? 'Sin nombre' }}</strong>
                                            ({{ $usuariosCt->count() }} usuario(s))
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($usuariosCt->count() > 0)
                                            <table class="table table-sm table-bordered table-striped">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Usuario</th>
                                                        <th>Contraseña</th>
                                                        <th>Nombre</th>
                                                        <th>Cargo</th>
                                                        <th>Rol</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($usuariosCt as $usuario)
                                                        <tr>
                                                            <td>{{ $usuario->email }}</td>
                                                            <td><code>{{ $usuario->opwd ?? 'No asignada' }}</code></td>
                                                            <td>{{ $usuario->name }}</td>
                                                            <td>{{ $usuario->ocargo ?? '' }}</td>
                                                            <td>
                                                                @if($usuario->orol == 2)
                                                                    <span class="badge badge-warning">Supervisión</span>
                                                                @elseif($usuario->orol == 3)
                                                                    <span class="badge badge-info">Escuela</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p class="text-muted mb-0">Sin usuarios asignados</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            {{-- Paginación mejorada --}}
                            @if(isset($resultado['centros_paginados']) && $resultado['centros_paginados']->hasPages())
                                <div class="row mt-4 mb-3">
                                    <div class="col-md-6">
                                        <div class="text-muted small">
                                            <i class="fas fa-info-circle"></i> 
                                            Mostrando <strong>{{ $resultado['centros_paginados']->firstItem() ?? 0 }}</strong> a 
                                            <strong>{{ $resultado['centros_paginados']->lastItem() ?? 0 }}</strong> de 
                                            <strong>{{ $resultado['centros_paginados']->total() }}</strong> centros
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end">
                                            {{ $resultado['centros_paginados']->appends([
                                                'cct' => $cct,
                                                'tipo_busqueda' => $tipoBusqueda
                                            ])->links('vendor.pagination.bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif(isset($resultado['centros_paginados']) && $resultado['centros_paginados']->count() == 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 
                                No se encontraron centros de trabajo bajo la responsabilidad de este centro.
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 
                                No se encontraron usuarios bajo la responsabilidad de este centro de trabajo.
                            </div>
                        @endif
                    </div>
                </div>

            @elseif($resultado['tipo'] === 'superiores')
                {{-- Mostrar cadena de mando --}}
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-sitemap"></i> 
                            Cadena de Mando de: 
                            <strong>{{ $resultado['cadena_mando']['escuela']['clave'] }} - {{ $resultado['cadena_mando']['escuela']['nombre'] }}</strong>
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Escuela --}}
                        <div class="card card-outline card-secondary mb-3">
                            <div class="card-header bg-secondary">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-school"></i> <strong>ESCUELA</strong>
                                </h6>
                            </div>
                            <div class="card-body">
                                <p><strong>CCT:</strong> {{ $resultado['cadena_mando']['escuela']['clave'] }}</p>
                                <p><strong>Nombre:</strong> {{ $resultado['cadena_mando']['escuela']['nombre'] }}</p>
                                @if(count($resultado['cadena_mando']['escuela']['usuarios']) > 0)
                                    <h6>Usuarios:</h6>
                                    <table class="table table-sm table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Contraseña</th>
                                                <th>Nombre</th>
                                                <th>Cargo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($resultado['cadena_mando']['escuela']['usuarios'] as $usuario)
                                                <tr>
                                                    <td>{{ $usuario['usuario'] }}</td>
                                                    <td><code>{{ $usuario['contraseña'] }}</code></td>
                                                    <td>{{ $usuario['nombre'] }}</td>
                                                    <td>{{ $usuario['cargo'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">Sin usuarios asignados</p>
                                @endif
                            </div>
                        </div>

                        {{-- Supervisión --}}
                        @if(isset($resultado['cadena_mando']['supervision']))
                            <div class="card card-outline card-warning mb-3">
                                <div class="card-header bg-warning">
                                    <h6 class="mb-0">
                                        <i class="fas fa-eye"></i> <strong>SUPERVISIÓN</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>CCT:</strong> {{ $resultado['cadena_mando']['supervision']['clave'] }}</p>
                                    <p><strong>Nombre:</strong> {{ $resultado['cadena_mando']['supervision']['nombre'] }}</p>
                                    @if(count($resultado['cadena_mando']['supervision']['usuarios']) > 0)
                                        <h6>Usuarios:</h6>
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Nombre</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resultado['cadena_mando']['supervision']['usuarios'] as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario['usuario'] }}</td>
                                                        <td><code>{{ $usuario['contraseña'] }}</code></td>
                                                        <td>{{ $usuario['nombre'] }}</td>
                                                        <td>{{ $usuario['cargo'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Sector --}}
                        @if(isset($resultado['cadena_mando']['sector']))
                            <div class="card card-outline card-success mb-3">
                                <div class="card-header bg-success">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-map-marked-alt"></i> <strong>JEFATURA DE SECTOR</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>CCT:</strong> {{ $resultado['cadena_mando']['sector']['clave'] }}</p>
                                    <p><strong>Nombre:</strong> {{ $resultado['cadena_mando']['sector']['nombre'] }}</p>
                                    @if(count($resultado['cadena_mando']['sector']['usuarios']) > 0)
                                        <h6>Usuarios:</h6>
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Nombre</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resultado['cadena_mando']['sector']['usuarios'] as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario['usuario'] }}</td>
                                                        <td><code>{{ $usuario['contraseña'] }}</code></td>
                                                        <td>{{ $usuario['nombre'] }}</td>
                                                        <td>{{ $usuario['cargo'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Departamento --}}
                        @if(isset($resultado['cadena_mando']['departamento']))
                            <div class="card card-outline card-info mb-3">
                                <div class="card-header bg-info">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-building"></i> <strong>DEPARTAMENTO</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>CCT:</strong> {{ $resultado['cadena_mando']['departamento']['clave'] }}</p>
                                    <p><strong>Nombre:</strong> {{ $resultado['cadena_mando']['departamento']['nombre'] }}</p>
                                    @if(count($resultado['cadena_mando']['departamento']['usuarios']) > 0)
                                        <h6>Usuarios:</h6>
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Nombre</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resultado['cadena_mando']['departamento']['usuarios'] as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario['usuario'] }}</td>
                                                        <td><code>{{ $usuario['contraseña'] }}</code></td>
                                                        <td>{{ $usuario['nombre'] }}</td>
                                                        <td>{{ $usuario['cargo'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Subdirección --}}
                        @if(isset($resultado['cadena_mando']['subdireccion']))
                            <div class="card card-outline card-primary mb-3">
                                <div class="card-header bg-primary">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-university"></i> <strong>SUBDIRECCIÓN</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>CCT:</strong> {{ $resultado['cadena_mando']['subdireccion']['clave'] }}</p>
                                    <p><strong>Nombre:</strong> {{ $resultado['cadena_mando']['subdireccion']['nombre'] }}</p>
                                    @if(count($resultado['cadena_mando']['subdireccion']['usuarios']) > 0)
                                        <h6>Usuarios:</h6>
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Nombre</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resultado['cadena_mando']['subdireccion']['usuarios'] as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario['usuario'] }}</td>
                                                        <td><code>{{ $usuario['contraseña'] }}</code></td>
                                                        <td>{{ $usuario['nombre'] }}</td>
                                                        <td>{{ $usuario['cargo'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Dirección --}}
                        @if(isset($resultado['cadena_mando']['direccion']))
                            <div class="card card-outline card-danger mb-3">
                                <div class="card-header bg-danger">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-crown"></i> <strong>DIRECCIÓN</strong>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>CCT:</strong> {{ $resultado['cadena_mando']['direccion']['clave'] }}</p>
                                    <p><strong>Nombre:</strong> {{ $resultado['cadena_mando']['direccion']['nombre'] }}</p>
                                    @if(count($resultado['cadena_mando']['direccion']['usuarios']) > 0)
                                        <h6>Usuarios:</h6>
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Contraseña</th>
                                                    <th>Nombre</th>
                                                    <th>Cargo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($resultado['cadena_mando']['direccion']['usuarios'] as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario['usuario'] }}</td>
                                                        <td><code>{{ $usuario['contraseña'] }}</code></td>
                                                        <td>{{ $usuario['nombre'] }}</td>
                                                        <td>{{ $usuario['cargo'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                <strong>Instrucciones:</strong> Ingresa un CCT y selecciona el tipo de búsqueda para ver la información del organigrama.
            </div>
        @endif
    </div>
</div>

@stop
