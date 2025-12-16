<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Organitation;
use App\Models\CentrosTrabajo;
use App\Models\User;

/**
 * Controlador para el Organigrama Elemental
 * 
 * Permite buscar por CCT y mostrar:
 * - Usuarios bajo responsabilidad de un centro de trabajo
 * - Cadena de mando (superiores) de una escuela
 * Solo accesible para Rol 1 (Dirección).
 */
class OrganigramaElementalController extends Controller
{
    /**
     * Muestra el formulario de búsqueda del organigrama
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Validar que solo Rol 1 puede acceder
        if (Auth::user()->orol != 1) {
            return redirect()->route('home')
                ->with('error', 'No tiene permisos para acceder a esta sección.');
        }

        return view('admin.organigrama-elemental.index');
    }

    /**
     * Busca información del organigrama por CCT
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function buscar(Request $request)
    {
        // Validar que solo Rol 1 puede acceder
        if (Auth::user()->orol != 1) {
            return redirect()->route('home')
                ->with('error', 'No tiene permisos para acceder a esta sección.');
        }

        $request->validate([
            'cct' => 'required|string|max:50',
            'tipo_busqueda' => 'required|in:responsabilidad,superiores',
        ]);

        $cct = trim($request->cct);
        $tipoBusqueda = $request->tipo_busqueda;

        // Buscar el centro de trabajo
        $centroTrabajo = CentrosTrabajo::where('oclave', $cct)->first();

        if (!$centroTrabajo) {
            return redirect()->route('organigrama-elemental.index')
                ->with('error', 'No se encontró el centro de trabajo con CCT: ' . $cct);
        }

        $resultado = null;

        if ($tipoBusqueda === 'responsabilidad') {
            // Buscar usuarios bajo responsabilidad de este CCT
            $resultado = $this->buscarUsuariosBajoResponsabilidad($centroTrabajo);
        } else {
            // Buscar cadena de mando (superiores) de esta escuela
            $resultado = $this->buscarCadenaMando($centroTrabajo);
        }

        return view('admin.organigrama-elemental.index', compact('resultado', 'cct', 'tipoBusqueda', 'centroTrabajo'));
    }

    /**
     * Busca usuarios bajo responsabilidad de un centro de trabajo
     * 
     * @param CentrosTrabajo $centroTrabajo
     * @return array
     */
    private function buscarUsuariosBajoResponsabilidad($centroTrabajo)
    {
        $direccionNivel = 'DIRECCION DE EDUCACION ELEMENTAL';
        $idCt = $centroTrabajo->kcvect;

        // Determinar qué tipo de centro es y qué usuarios tiene bajo su responsabilidad
        $organizacion = Organitation::where('odireccionnivel', $direccionNivel)
            ->where(function($query) use ($idCt) {
                $query->where('idct_direccion', $idCt)
                      ->orWhere('idct_subdireccion', $idCt)
                      ->orWhere('idct_departamento', $idCt)
                      ->orWhere('idct_sector', $idCt)
                      ->orWhere('idct_supervicion', $idCt)
                      ->orWhere('idct_escuela', $idCt);
            })
            ->first();

        if (!$organizacion) {
            return null;
        }

        // Obtener todos los CCTs bajo responsabilidad
        $cctsBajoResponsabilidad = $this->obtenerCCTsBajoResponsabilidad($organizacion, $idCt, $direccionNivel);

        // Validar que hay CCTs bajo responsabilidad
        if (empty($cctsBajoResponsabilidad)) {
            return [
                'tipo' => 'responsabilidad',
                'centro_principal' => [
                    'id' => $centroTrabajo->kcvect,
                    'clave' => $centroTrabajo->oclave,
                    'nombre' => $centroTrabajo->onombre_ct,
                ],
                'usuarios' => collect(),
                'centros_trabajo' => [],
                'centros_paginados' => null,
                'total_usuarios' => 0,
                'total_centros' => 0,
            ];
        }

        // Obtener información de los centros de trabajo con paginación
        $centrosTrabajoQuery = CentrosTrabajo::whereIn('kcvect', $cctsBajoResponsabilidad)
            ->orderBy('onombre_ct', 'ASC');
        
        // Paginar los centros de trabajo (20 por página)
        $perPage = 20;
        $centrosTrabajoPaginated = $centrosTrabajoQuery->paginate($perPage);
        
        // Obtener IDs de los centros de la página actual
        $cctsPaginaActual = $centrosTrabajoPaginated->pluck('kcvect')->toArray();
        
        // Obtener usuarios solo de los CCTs de la página actual (si hay)
        $usuarios = collect();
        if (!empty($cctsPaginaActual)) {
            $usuarios = User::whereIn('id_ct', $cctsPaginaActual)
                ->whereIn('orol', [2, 3])
                ->where('status', 'A')
                ->select('id', 'id_ct', 'orol', 'name', 'email', 'opwd', 'ocargo', 'oct')
                ->get()
                ->groupBy('id_ct');
        }

        // Obtener información de los centros de trabajo como array
        $centrosTrabajo = $centrosTrabajoPaginated->pluck('onombre_ct', 'kcvect')->toArray();

        // Contar total de usuarios (de todos los CCTs, no solo la página actual)
        $totalUsuarios = User::whereIn('id_ct', $cctsBajoResponsabilidad)
            ->whereIn('orol', [2, 3])
            ->where('status', 'A')
            ->count();

        return [
            'tipo' => 'responsabilidad',
            'centro_principal' => [
                'id' => $centroTrabajo->kcvect,
                'clave' => $centroTrabajo->oclave,
                'nombre' => $centroTrabajo->onombre_ct,
            ],
            'usuarios' => $usuarios,
            'centros_trabajo' => $centrosTrabajo,
            'centros_paginados' => $centrosTrabajoPaginated,
            'total_usuarios' => $totalUsuarios,
            'total_centros' => count($cctsBajoResponsabilidad),
        ];
    }

    /**
     * Obtiene los CCTs bajo responsabilidad de un centro de trabajo
     */
    private function obtenerCCTsBajoResponsabilidad($organizacion, $idCt, $direccionNivel)
    {
        $ccts = [$idCt]; // Incluir el propio CCT

        // Si es subdirección, obtener departamentos, sectores, supervisiones y escuelas
        if ($organizacion->idct_subdireccion == $idCt) {
            $orgs = Organitation::where('odireccionnivel', $direccionNivel)
                ->where('idct_subdireccion', $idCt)
                ->get();
            
            $ccts = array_merge($ccts, 
                $orgs->whereNotNull('idct_departamento')->pluck('idct_departamento')->unique()->toArray(),
                $orgs->whereNotNull('idct_sector')->pluck('idct_sector')->unique()->toArray(),
                $orgs->whereNotNull('idct_supervicion')->pluck('idct_supervicion')->unique()->toArray(),
                $orgs->whereNotNull('idct_escuela')->pluck('idct_escuela')->unique()->toArray()
            );
        }
        // Si es departamento, obtener sectores, supervisiones y escuelas
        elseif ($organizacion->idct_departamento == $idCt) {
            $orgs = Organitation::where('odireccionnivel', $direccionNivel)
                ->where('idct_departamento', $idCt)
                ->get();
            
            $ccts = array_merge($ccts,
                $orgs->whereNotNull('idct_sector')->pluck('idct_sector')->unique()->toArray(),
                $orgs->whereNotNull('idct_supervicion')->pluck('idct_supervicion')->unique()->toArray(),
                $orgs->whereNotNull('idct_escuela')->pluck('idct_escuela')->unique()->toArray()
            );
        }
        // Si es sector, obtener supervisiones y escuelas
        elseif ($organizacion->idct_sector == $idCt) {
            $orgs = Organitation::where('odireccionnivel', $direccionNivel)
                ->where('idct_sector', $idCt)
                ->get();
            
            $ccts = array_merge($ccts,
                $orgs->whereNotNull('idct_supervicion')->pluck('idct_supervicion')->unique()->toArray(),
                $orgs->whereNotNull('idct_escuela')->pluck('idct_escuela')->unique()->toArray()
            );
        }
        // Si es supervisión, obtener escuelas
        elseif ($organizacion->idct_supervicion == $idCt) {
            $orgs = Organitation::where('odireccionnivel', $direccionNivel)
                ->where('idct_supervicion', $idCt)
                ->get();
            
            $ccts = array_merge($ccts,
                $orgs->whereNotNull('idct_escuela')->pluck('idct_escuela')->unique()->toArray()
            );
        }
        // Si es escuela, solo ella misma
        elseif ($organizacion->idct_escuela == $idCt) {
            // Ya está incluida
        }

        return array_unique($ccts);
    }

    /**
     * Busca la cadena de mando (superiores) de una escuela
     * 
     * @param CentrosTrabajo $centroTrabajo
     * @return array
     */
    private function buscarCadenaMando($centroTrabajo)
    {
        $direccionNivel = 'DIRECCION DE EDUCACION ELEMENTAL';
        $idCt = $centroTrabajo->kcvect;

        // Buscar la organización de esta escuela
        $organizacion = Organitation::where('odireccionnivel', $direccionNivel)
            ->where('idct_escuela', $idCt)
            ->first();

        if (!$organizacion) {
            return null;
        }

        $cadenaMando = [
            'escuela' => [
                'id' => $idCt,
                'clave' => $centroTrabajo->oclave,
                'nombre' => $centroTrabajo->onombre_ct,
                'usuarios' => $this->obtenerUsuarios($idCt, 3),
            ],
        ];

        // Obtener supervisión
        if ($organizacion->idct_supervicion > 0) {
            $supervision = $this->obtenerInfoCentro($organizacion->idct_supervicion);
            if ($supervision) {
                $cadenaMando['supervision'] = $supervision;
            }
        }

        // Obtener sector
        if ($organizacion->idct_sector > 0) {
            $sector = $this->obtenerInfoCentro($organizacion->idct_sector);
            if ($sector) {
                $cadenaMando['sector'] = $sector;
            }
        }

        // Obtener departamento
        if ($organizacion->idct_departamento > 0) {
            $departamento = $this->obtenerInfoCentro($organizacion->idct_departamento);
            if ($departamento) {
                $cadenaMando['departamento'] = $departamento;
            }
        }

        // Obtener subdirección
        if ($organizacion->idct_subdireccion > 0) {
            $subdireccion = $this->obtenerInfoCentro($organizacion->idct_subdireccion);
            if ($subdireccion) {
                $cadenaMando['subdireccion'] = $subdireccion;
            }
        }

        // Obtener dirección
        if ($organizacion->idct_direccion > 0) {
            $direccion = $this->obtenerInfoCentro($organizacion->idct_direccion);
            if ($direccion) {
                $cadenaMando['direccion'] = $direccion;
            }
        }

        return [
            'tipo' => 'superiores',
            'cadena_mando' => $cadenaMando,
        ];
    }

    /**
     * Obtiene información de un centro de trabajo con sus usuarios
     */
    private function obtenerInfoCentro($idCt)
    {
        $ct = CentrosTrabajo::where('kcvect', $idCt)->first();
        if (!$ct) {
            return null;
        }

        // Obtener usuarios de todos los roles posibles para este centro
        $usuariosRol2 = $this->obtenerUsuarios($idCt, 2);
        $usuariosRol1 = $this->obtenerUsuarios($idCt, 1);
        
        // Combinar usuarios
        $usuarios = array_merge($usuariosRol1, $usuariosRol2);

        return [
            'id' => $idCt,
            'clave' => $ct->oclave,
            'nombre' => $ct->onombre_ct,
            'usuarios' => $usuarios,
        ];
    }

    /**
     * Obtiene los usuarios de un centro de trabajo
     * 
     * @param int $idCt
     * @param int $rol
     * @return array
     */
    private function obtenerUsuarios($idCt, $rol)
    {
        return User::where('id_ct', $idCt)
            ->where('orol', $rol)
            ->where('status', 'A')
            ->select('id', 'name', 'email', 'opwd', 'ocargo')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nombre' => $user->name,
                    'usuario' => $user->email,
                    'contraseña' => $user->opwd ?? 'No asignada',
                    'cargo' => $user->ocargo ?? '',
                ];
            })
            ->toArray();
    }
}
