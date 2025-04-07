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

class _adgIntervencionesgeneradasController extends Controller
{


        public function index()
        {   
                if(Auth::user()->onivel='ELEMENTAL')
                {
                    $nivel = 'DIRECCION DE EDUCACION ELEMENTAL';
                }else{
                    $nivel = 'DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
                }

                $subdirecciones = Organitation::select('idct_subdireccion','cct_subdireccion', 'oorden_sub')
                                ->whereOdireccionnivel($nivel)
                                ->where('cct_subdireccion', '>', 1)
                                ->where('idct_direccion', Auth::user()->id_ct)
                                ->orWhere('idct_subdireccion', Auth::user()->id_ct)
                                ->GroupBy('idct_subdireccion','cct_subdireccion', 'oorden_sub')
                                ->OrderBy('oorden_sub','ASC')
                                ->get();

                $departamantos = Organitation::select('idct_departamento','cct_departamento', 'oorden_dep')
                                ->whereOdireccionnivel($nivel)
                                ->where('cct_departamento','>',1)
                                ->where('idct_direccion', Auth::user()->id_ct)
                                ->orWhere('idct_departamento', Auth::user()->id_ct)
                                ->GroupBy('idct_departamento','cct_departamento', 'oorden_dep')
                                ->OrderBy('oorden_dep','ASC')
                                ->get();
                
                return view('adg.levels.generadas.index',
                        compact('subdirecciones', 'departamantos')
                        );
        }




        public function edit(string $id)
        {   

            //$intervenciones = Intervencion::whereIdctDepartamento($id)->whereOfin(1)->get();

            $intervencionesc= Intervencion::select('idct_departamento', 'oct_nivel', 'onivel_educativo')
                            ->where('idct_departamento',$id)->whereOfin(1)->whereNotIn('istatus',['B'])
                            ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo')->count();

            $intervenciones = Intervencion::select('idct_departamento', 'oct_nivel', 'onivel_educativo', 'ofechafin',
                            DB::raw('date_format(ofechafin, "%d-%m-%Y") as fechaentrega')) 
                            ->where('idct_departamento',$id)->whereOfin(1)->whereNotIn('istatus',['B'])
                            ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo','ofechafin')->get();

            return view('adg.levels.generadas.edit',
                        compact('intervencionesc', 'intervenciones')
                        );
        }

}
