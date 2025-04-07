<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Ctitulares;
use App\Models\Intervencion;

class _adgIntervencionesgeneradasController extends Controller
{


        public function index()
        {   
                if(Auth::user()->onivel='ELEMENTAL')
                {
                    $nivel = 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL';
                }else{
                    $nivel = 'DIRECCIÓN DE EDUCACIÓN SECUNDARIA Y SERVICIOS DE APOYO';
                }

                $subdep = Ctitulares::whereOnivel($nivel)->OrderBy('oorden','ASC')->get();

                
                return view('adg.levels.generadas.index',
                        compact('subdep')
                        );
        }




        public function edit(string $id)
        {   

            //$intervenciones = Intervencion::whereIdctDepartamento($id)->whereOfin(1)->get();

            $intervencionesc= Intervencion::select('idct_departamento', 'oct_nivel', 'onivel_educativo')
                            ->where('idct_departamento',$id)->whereOfin(1)->whereNotIn('istatus',['B'])
                            ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo')->count();

            $intervenciones = Intervencion::select('idct_departamento', 'oct_nivel', 'onivel_educativo', 'ofechafin',
                                DB::raw('date_format(ofechafin, "%d-%m-%Y") as fechaentrega'), 'ourl', 'oarchivo') 
                            ->where('idct_departamento',$id)->whereOfin(1)->whereNotIn('istatus',['B'])
                            ->GroupBy('idct_departamento', 'oct_nivel', 'onivel_educativo','ofechafin', 'ourl', 'oarchivo')
                            ->OrderBy(DB::raw('date_format(ofechafin, "%d-%m-%Y")'),'DESC')->get();

            return view('adg.levels.generadas.edit',
                        compact('intervencionesc', 'intervenciones')
                        );
        }

}
