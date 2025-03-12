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
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tipoacta   = Tipoacta::get();
        $anexos     = Anexos::OrderBy('onum_anexo', 'ASC')->get();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->first();
        
        if (Auth::check())
        { 
            if( Auth::user()->orol<3 || Auth::user()->orol==99){

                $datosacta = DatosActa::get();
                 return redirect(url('entregas-recepcion'));

            }else if ( Auth::user()->orol==3 ){
             
                return redirect(url('entrega-recepcion'));

            }else if ( Auth::user()->orol>3 ){

                return redirect(url('certificados-emitidos'));

            }
        }
    }
}
