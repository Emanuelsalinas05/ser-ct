<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ctitulares;
use App\Models\Intervencion;

class _adgIntervencionesgeneradasController extends Controller
{
    public function index()
    {
        $nivel = (Auth::user()->onivel === 'ELEMENTAL')
            ? 'DIRECCION DE EDUCACION ELEMENTAL'
            : 'DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';

        $subdep = Ctitulares::where('onivel', $nivel)
            ->orderBy('oorden', 'ASC')
            ->get();

        return view('adg.levels.generadas.index', compact('subdep'));
    }

    public function edit(string $id)
    {
        $intervencionesc = Intervencion::select('idct_departamento','oct_nivel','onivel_educativo')
            ->where('idct_departamento', $id)
            ->where('ofin', 1)
            ->where('istatus', '!=', 'B')
            ->groupBy('idct_departamento','oct_nivel','onivel_educativo')
            ->count();

        $intervenciones = Intervencion::select(
                'idct_departamento','oct_nivel','onivel_educativo','ofechafin','ourl','oarchivo',
                DB::raw('DATE_FORMAT(ofechafin, "%d-%m-%Y") as fechaentrega')
            )
            ->where('idct_departamento', $id)
            ->where('ofin', 1)
            ->where('istatus', '!=', 'B')
            ->groupBy('idct_departamento','oct_nivel','onivel_educativo','ofechafin','ourl','oarchivo')
            ->orderBy('ofechafin', 'DESC') // ordena por fecha real, no por cadena formateada
            ->get();

        return view('adg.levels.generadas.edit', compact('intervencionesc','intervenciones'));
    }
}
