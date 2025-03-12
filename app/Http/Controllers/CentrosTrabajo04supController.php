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

class CentrosTrabajo04supController extends Controller
{

   public function index()
   {
      if(Auth::user()->onivel=='ELEMENTAL')
      {
         $odir='DIRECCION DE EDUCACION ELEMENTAL';
      }else if(Auth::user()->onivel=='SECUNDARIA'){
         $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
      }
         
      if(Auth::user()->ocargo=='DIRECCIÓN')
      {
         $cts = Organitation::select('idct_escuela', 'cct_escuela')
                     ->whereOdireccionnivel($odir)->take(100)->get();

      }else if(Auth::user()->ocargo=='SUBDIRECCIÓN'){
         $cts = Organitation::select('idct_escuela', 'cct_escuela')
                     ->whereOdireccionnivel($odir)->take(100)->get();

      }else if(Auth::user()->ocargo=='DEPARTAMENTO'){
         $cts = Organitation::select('idct_escuela', 'cct_escuela')
                     ->whereOdireccionnivel($odir)->take(100)->get();

      }else if(Auth::user()->ocargo=='SECTOR'){
         $cts = Organitation::select('idct_escuela', 'cct_escuela')
                     ->whereOdireccionnivel($odir)->take(100)->get();

      }else if(Auth::user()->ocargo=='SUPERVISIÓN'){
         $cts = Organitation::select('idct_supervicion', 'cct_supervision')
                     ->whereOdireccionnivel($odir)->take(100)->get();
      }

      //return view('admin.organitation.index', 
         return view('admin.ct.index', 
                  compact('cts', )
                  );
    }



   public function create()
   {
      if(Auth::user()->onivel=='ELEMENTAL')
      {
         $odir='DIRECCION DE EDUCACION ELEMENTAL';
      }else if(Auth::user()->onivel=='SECUNDARIA'){
         $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
      }

      $subdirs = Organitation::select('idct_subdireccion','cct_subdireccion')
               ->whereOdireccionnivel($odir)
               ->GroupBy('idct_subdireccion','cct_subdireccion')->get();

      $deptos = Organitation::select('idct_departamento','cct_departamento')
               ->whereOdireccionnivel($odir)
               ->GroupBy('idct_departamento','cct_departamento')->get();

      $sectors= Organitation::select('idct_sector','cct_sector')
               ->whereOdireccionnivel($odir)
               ->GroupBy('idct_sector','cct_sector')->get();

      $supers= Organitation::select('idct_supervicion','cct_supervision')
               ->whereOdireccionnivel($odir)
               ->GroupBy('idct_supervicion','cct_supervision')->get();

      return view('admin.ct.create',
               compact('subdirs','deptos','sectors','supers')
               );
   }



   public function store(Request $request)
   {
      $validatedData = $request->validate([
            'oct'       => 'required',
            'onombrect' => 'required',
            'osubdir'   => 'required',
            'odepto'    => 'required',
            'osector'   => 'required',
            'osuper'    => 'required',
            'ovalle'    => 'required',
            'odomicilio'=> 'required',
            'ocolonia'  => 'required',
            'ocp'       => 'required',
            'otel'      => 'required',
            'ocorreo'   => 'required',
            'ompio'     => 'required',
      ],$message=[
            'oct.required'       => 'INGRESA LA CLAVE DE CENTRO DE TRABAO',
            'onombrect.required' => 'INGRESA EL NOMBRE DEL CENTRO DE TRABAJO',
            'osubdir.required'   => 'SELECCIONA LA SUBDIRECCIÓN',
            'odepto.required'    => 'SELECCIONA EL DEPARTAMENTO',
            'osector.required'   => 'SELECCIONA EL SECTOR',
            'osuper.required'    => 'SELECCIONA LA SUPERVISIÓN',
            'ovalle.required'    => 'Selecciona la categoría/plaza',
            'odomicilio.required'=> 'Elije el total de plazas (ocupadas y vacantes)',
            'ocolonia.required'  => 'Elije el total de plazas ocupadas',
            'ocp.required'       => 'Selecciona la categoría/plaza',
            'otel.required'      => 'Elije el total de plazas (ocupadas y vacantes)',
            'ocorreo.required'   => 'Elije el total de plazas ocupadas',
            'ompio.required'     => 'Selecciona la categoría/plaza', 
      ]);

      if(Auth::user()->onivel=='ELEMENTAL')
      {
         $odir='DIRECCION DE EDUCACION ELEMENTAL';
      }else if(Auth::user()->onivel=='SECUNDARIA'){
         $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
      }

      $getSub = Organitation::select('cct_subdireccion')->whereIdctSubdireccion($request->osubdir)
               ->whereOdireccionnivel($odir)->GroupBy('cct_subdireccion')->first();
      $getDpto= Organitation::select('cct_departamento')->whereIdctDepartamento($request->odepto)
               ->whereOdireccionnivel($odir)->GroupBy('cct_departamento')->first();
      $getSec = Organitation::select('cct_sector')->whereIdctSector($request->osector)
               ->whereOdireccionnivel($odir)->GroupBy('cct_sector')->first();
      $getSup = Organitation::select('cct_supervision')->whereIdctSupervicion($request->osuper)
               ->whereOdireccionnivel($odir)->GroupBy('cct_supervision')->first();

      $last = CentrosTrabajo::select('kcvect')->OrderBy('kcvect','DESC')->first();

            CentrosTrabajo::create([
                        'kcvect'       => $last->kcvect+1,
                        'oclave'       => $request->oct,
                        'onombre_ct'   => $request->onombrect,
                        'ovalle'       => $request->ovalle,
                        'odomicilio'   => $request->odomicilio,
                        'nombre_col'   => $request->ocolonia,
                        'ocodigopostal'=> $request->ocp,
                        'otelefono'    => $request->otel,
                        'oemail'       => $request->ocorreo,
                        'nombre_loc'   => $request->ompio,
                        'odireccion'   => Auth::user()->onivel, 
                        'onamedir'     => $odir,                        
                  ]);

            Organitation::create([
                        'idct_direccion'     => Auth::user()->id_ctorigen,
                        'cct_direccion'      => Auth::user()->octorigen,
                        'idct_subdireccion'  => $request->osubdir,
                        'cct_subdireccion'   => $getSub->cct_subdireccion,
                        'idct_departamento'  => $request->odepto,
                        'cct_departamento'   => $getDpto->cct_departamento,
                        'idct_sector'        => $request->osector,
                        'cct_sector'         => $getSec->cct_sector,
                        'idct_supervicion'   => $request->osuper,
                        'cct_supervision'    => $getSup->cct_supervision,
                        'idct_escuela'       => $last->kcvect+1,
                        'cct_escuela'        => $request->oct,
                        'ovalle'             => $request->ovalle,
                        'odireccionnivel'    => $odir,                       
                  ]);

            function generateRandomString($length = 10){ 
                       return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
            }
            $elfolio = generateRandomString();

            User::create([
                     'name'      => $request->onombrect,
                     'orfc'      => NULL,
                     'ocurp'     => NULL,
                     'id_ct'     => $last->kcvect+1,
                     'oct'       => $request->oct,
                     'email'     => $request->oct,
                     'password'  => Hash::make($elfolio),
                     'opwd'      => $elfolio,
                     'orol'      => 3,
                     'ocorreo'   => NULL,  
                     'ocargo'    => 'ESCUELA',  
                     'onivel'    => Auth::user()->onivel,
                     'id_ctorigen'=> Auth::user()->id_ctorigen,
                     'octorigen' => Auth::user()->octorigen,
                     'ovalle'    => $request->ovalle,
                  ]);
      
      return redirect(url('centros-de-trabajo'))
                ->with("success", "Se ha registrado correctamente el centro de trabajo");  
   }


}
