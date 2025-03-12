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

class CentrosTrabajo01xxController extends Controller
{

   public function index()
   {
         if(Auth::user()->onivel=='ELEMENTAL')
         {
            $odir='DIRECCION DE EDUCACION ELEMENTAL';
         }else if(Auth::user()->onivel=='SECUNDARIA'){
            $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         }
            
         $ctsub = Organitation::select('idct_subdireccion','cct_subdireccion')
                  ->whereOdireccionnivel($odir)
                  ->GroupBy('idct_subdireccion','cct_subdireccion')
                  ->paginate(1);

         $ctdep = Organitation::select('idct_subdireccion','idct_departamento','cct_departamento')
                  ->whereOdireccionnivel($odir)
                  ->GroupBy('idct_subdireccion','idct_departamento','cct_departamento')
                  ->get();

         $ctsec = Organitation::select('idct_subdireccion','idct_departamento','idct_sector','cct_sector')
                  ->whereOdireccionnivel($odir)
                  ->GroupBy('idct_subdireccion','idct_departamento','idct_sector','cct_sector')
                  ->get();

         $ctsup = Organitation::select('idct_subdireccion','idct_departamento','idct_sector','idct_supervicion','cct_supervision')
                  ->whereOdireccionnivel($odir)
                  ->GroupBy('idct_subdireccion','idct_departamento','idct_sector','idct_supervicion','cct_supervision')
                  ->get();

         $ctesc = Organitation::select('idct_subdireccion','idct_departamento','idct_sector','idct_supervicion','idct_escuela','cct_escuela')
                  ->whereOdireccionnivel($odir)
                  ->GroupBy('idct_subdireccion','idct_departamento','idct_sector','idct_supervicion','idct_escuela','cct_escuela')
                  ->get();

      //return view('admin.organitation.index', 
         return view('admin.ct.estructura.index', 
                  compact('ctsub','ctdep','ctsec','ctsup','ctesc' )
                  );
    }






}
