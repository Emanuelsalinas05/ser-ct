<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\CentrosTrabajo;
use App\Models\Organitation;
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;
use App\Models\Plantillapersonal;
use App\Models\Plantillacomisionados;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;

class FinalizadasController extends Controller
{

    public function index()
    {
        // Inicializar $us con un valor por defecto
        $us = 76; // Valor por defecto para ELEMENTAL
        
        if(Auth::user()->onivel=='ELEMENTAL'){
            $us=76;
        }else if(Auth::user()->onivel=='SECUNDARIA'){
            $us=89;
        }

        if (Auth::user()->role_id == 3) {
            require_once base_path('public/controllers/entregas/finalizadas/06escuela.php');
            return view('admin.er.finalizadas.index3', compact('datosacta3', 'us'));
        }

        // Manejar usuarios con orol == 1 (administradores)
        if (Auth::user()->orol == 1) {
            // Para usuarios con orol 1, consulta optimizada con paginación para evitar timeouts
            // Ordenar por fecha de finalización (ofecha_fin_a o ofecha_fin_ac) en lugar de created_at
            // Cargar relaciones necesarias para la vista
            // Calcular unidad administrativa usando organigrama
            $datosacta = DatosActa::select(
                        DB::raw('distinct(g1acta.id) as idd'), 
                        'g1acta.*',
                        'g1organigrama.idct_subdireccion',
                        'g1organigrama.idct_departamento',
                        DB::raw('CASE 
                                    WHEN g1organigrama.idct_departamento=0 OR g1organigrama.idct_departamento IS NULL
                                    THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=g1organigrama.idct_subdireccion LIMIT 1)
                                    ELSE (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect=g1organigrama.idct_departamento LIMIT 1)
                                END AS unidad')
                    )
                    ->leftJoin('g1organigrama', 'g1organigrama.idct_escuela', 'g1acta.id_ct')
                    ->where('g1acta.oconcluida', 1)
                    ->with(['tipoacta', 'elct']) // Cargar relaciones necesarias
                    ->orderByRaw('COALESCE(g1acta.ofecha_fin_a, g1acta.ofecha_fin_ac, g1acta.created_at) DESC')
                    ->paginate(20);

            // Variables vacías para compatibilidad con la vista
            $datosacta2 = collect();
            $datosacta3 = collect();
            
            return view('admin.er.finalizadas.index-improved', compact('datosacta', 'datosacta2', 'datosacta3', 'us'));
        }

        switch (Auth::user()->ocargo)
            {
                case 'DIRECCIÓN':
                    require_once base_path('public/controllers/entregas/finalizadas/01direccion.php');
                    return view('admin.er.finalizadas.index',
                                compact('datosacta','datosacta2','datosacta3','us')
                                );
                break;

                case 'SUBDIRECCIÓN':
                    require_once base_path('public/controllers/entregas/finalizadas/02subdireccion.php');
                    return view('admin.er.finalizadas.index',
                                compact('datosacta','datosacta2','datosacta3','us')
                                );
                break;

                case 'DEPARTAMENTO':
                    require_once base_path('public/controllers/entregas/finalizadas/03departamento.php');
                    return view('admin.er.finalizadas.index',
                                compact('datosacta','datosacta2','datosacta3','us')
                                );
                break;

                case 'SECTOR':
                    require_once base_path('public/controllers/entregas/finalizadas/04sector.php');
                    return view('admin.er.finalizadas.index2',
                                compact('datosacta2','datosacta3','us')
                                );
                break;

                case 'SUPERVISIÓN':
                    require_once base_path('public/controllers/entregas/finalizadas/05supervision.php.php');
                    return view('admin.er.finalizadas.index3',
                                compact('datosacta3','us')
                                );
                break;

                default:
                    // Caso por defecto: usuarios sin cargo específico o con otros cargos
                    // Obtener entregas finalizadas del centro de trabajo del usuario
                    // Ordenar por fecha de finalización (ofecha_fin_a o ofecha_fin_ac) en lugar de created_at
                    // Cargar relaciones necesarias para la vista
                    $datosacta = DatosActa::where('id_ct', Auth::user()->id_ct)
                        ->whereOconcluida(1)
                        ->with(['tipoacta', 'elct']) // Cargar relaciones necesarias
                        ->orderByRaw('COALESCE(ofecha_fin_a, ofecha_fin_ac, created_at) DESC')
                        ->get();
                    
                    $datosacta2 = collect();
                    $datosacta3 = collect();
                    
                    return view('admin.er.finalizadas.index-improved', 
                                compact('datosacta', 'datosacta2', 'datosacta3', 'us')
                                );
                break;
            }




    }




    public function show($id)
    {
        $acta = DatosActa::findOrFail($id);

        // Solo puede ver si pertenece al mismo centro de trabajo
        if (Auth::user()->role_id == 3 && $acta->id_ct != Auth::user()->id_ct) {
            abort(403, 'No tienes permiso para ver esta acta.');
        }

        return view('admin.er.finalizadas.show', compact('acta'));
    }








    public function edit(string $id)
    {
            if(Auth::user()->onivel=='ELEMENTAL'){
                $us=76;
            }else if(Auth::user()->onivel=='SECUNDARIA'){
                $us=89;
            }

            $documentos  = Documentos::get();
            $datosacta   = DatosActa::whereId($id)->first();
            
            // Validar que el acta existe
            if (!$datosacta) {
                return redirect()->back()->withErrors("Acta no encontrada.");
            }

            $avanceanexos = Avanceanexos::whereIdActa($id)->get();

            if($datosacta->id_tipoacta==2)
            {
                    $anexos = Anexos::whereNotIn('onum_anexo', [14,15])->OrderBy('onum_anexo', 'ASC')->get();
            }else if($datosacta->id_tipoacta==1){

                   $anexos  = Anexos::OrderBy('onum_anexo', 'ASC')->get();
            }

            require_once base_path('public/controllers/entregas/finalizadas/edit/index.php');

            return view('admin.er.finalizadas.edit',
                    compact('anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'us')
                    );
    }





}
