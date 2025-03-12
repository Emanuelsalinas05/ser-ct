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

class _adgInfonivelesController extends Controller
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
        
        return view('adg.levels.info.index',
                compact('subdep')
                );
    }




    public function edit(string $id)
    {   

        $getitular = Ctitulares::whereIdCt($id)->first();
        
        return view('adg.titulares.edit',
                compact('getitular')
                );
    }




    public function update(Request $request, string $id)
    {

        if($request->action=='9')
        {   

            $gett = Ctitulares::whereId($id)->first();

            $avances_acta = Ctitulares::whereId($id);
            $avances_acta->update([
                                    'ooficio'   => $request->ooficio , 
                                    'ocargo'    => $request->ocargo ,
                                    'otitular'  => $request->otitular ,
                                    'ocorreo'   => $request->ocorreo ,
                                    'odireccion'=> $request->odireccion ,
                                    'oinformes' => $request->oinformes ,
                                ]);

            return redirect()->back()
                    ->with('success', 'Se actualizaron los datos del titular del '.$gett->oclave.' - '.$gett->onombre_ct);
        }

    }





}
