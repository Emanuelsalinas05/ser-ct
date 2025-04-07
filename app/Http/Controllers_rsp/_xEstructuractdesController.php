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

use App\Models\Tipoacta;
use App\Models\DatosActa;

use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Plantillapersonal;

class _xEstructuractdesController extends Controller
{


    public function index()
    {
        

        $subdireccion = Organitation::select('idct_subdireccion', 'cct_subdireccion', 'g1centros_trabajo.onombre_ct')
                        ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_subdireccion')
                        ->whereOdireccionnivel('DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO')
                        ->GroupBy('idct_subdireccion', 'cct_subdireccion', 'g1centros_trabajo.onombre_ct')
                        ->OrderBy('cct_subdireccion', 'ASC')->get();

        $departamento = Organitation::select('idct_subdireccion', 'idct_departamento', 'cct_departamento', 'g1centros_trabajo.onombre_ct')
                        ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_departamento')
                        ->whereOdireccionnivel('DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO')
                        ->GroupBy('idct_subdireccion', 'idct_departamento', 'cct_departamento', 'g1centros_trabajo.onombre_ct')
                        ->OrderBy('cct_departamento', 'ASC')->get();
        
        $sector = Organitation::select('idct_subdireccion','idct_departamento','idct_sector', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct')
                        ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_sector')
                        ->whereOdireccionnivel('DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO')
                        ->GroupBy('idct_subdireccion','idct_departamento', 'idct_sector', 'g1organigrama.cct_sector','g1centros_trabajo.onombre_ct')
                        ->OrderBy('g1organigrama.cct_sector', 'ASC')->get();


        return view('_estructura.desysa.index', 
            compact('subdireccion', 'departamento', 'sector')
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
