<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Datatables;
use App\Models\CentrosTrabajo;
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;
use App\Models\Rolesusers;
use App\Models\Organitation;

class Users03departamentoController extends Controller
{

    public function index()
    {
        if ( Auth::user()->orol==1)
        {
            if( Auth::user()->id==3 )
            {
                $usuarios = User::whereOcargo('DEPARTAMENTO')
                            ->whereOnivel(Auth::user()->onivel)
                            ->whereStatus('A')->get();
            }else{
                $usuarios = User::whereOcargo('DEPARTAMENTO')
                            ->whereOnivel(Auth::user()->onivel)
                            ->whereOvalle(Auth::user()->ovalle)
                            ->whereStatus('A')->get();
            }

                

            return view('admin.users-levels.departamento.index', compact('usuarios') );
        }
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


}
