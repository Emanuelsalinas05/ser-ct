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

use App\Models\Intervencion;
use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Rolesusers;
use App\Models\Solicitudnoadeudo;
use App\Models\Ctitulares;

class _deeintervencionesController extends Controller
{
 
    public function index()
    {
            $intervenciones = Intervencion::select('idct_departamento','oct_nivel','onivel_educativo','ourl','oarchivo', 
                            DB::raw('date_format(ofechafin, "%d-%m-%Y") as fechafin'),'ofile', 'onotificado', 'ofechafin', 
                            DB::raw('count(idct_escuela) as totalct'))
                            ->whereOfile(1)
                            ->GroupBy('idct_departamento','oct_nivel','onivel_educativo','ourl','oarchivo','ofechafin','ofile', 'onotificado')
                            ->OrderBy('ofechafin', 'DESC')
                            ->get();

             $getmensual = Intervencion::select(DB::raw('date_format(ofechafin, "%Y-%m") as fecha'), 
                                                DB::raw('date_format(ofechafin, "%m-%Y") as fechax'))
                            ->whereOnotificado(1)
                            ->GroupBy(DB::raw('date_format(ofechafin, "%Y-%m")'), 
                                      DB::raw('date_format(ofechafin, "%m-%Y")'))
                            ->OrderBy(DB::raw('date_format(ofechafin, "%Y-%m")'),'ASC')->get();


            $intervencionesc = Intervencion::whereOnotificado(1)->count();

            return view('admin.intervenciones.index',
                        compact('intervenciones', 'intervencionesc','getmensual')
                        );
    }

 
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

 
    public function show(string $id)
    {
        //
    }

 
    public function edit(string $id)
    {
        //
    }

 
    public function update(Request $request, string $id)
    {
        //
    }

 
    public function destroy(string $id)
    {
        //
    }
}
