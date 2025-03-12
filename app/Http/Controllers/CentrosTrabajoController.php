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

class CentrosTrabajoController extends Controller
{

   public function index()
   {
      if(Auth::user()->onivel=='ELEMENTAL')
      {
         $odir='DIRECCION DE EDUCACION ELEMENTAL';
         $cts = Organitation::whereOdireccionnivel($odir)->OrderBy('cct_escuela')->paginate(50);
      }else if(Auth::user()->onivel=='SECUNDARIA'){
         $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         $cts = Organitation::whereOdireccionnivel($odir)->OrderBy('cct_escuela')->paginate(50);
      }
         
      

         return view('admin.ct.index', 
                  compact('cts', )
                  );
    }



   public function show(Request $request,$id)
   {
      if(Auth::user()->onivel=='ELEMENTAL')
      {
         $odir='DIRECCION DE EDUCACION ELEMENTAL';
         $cts = Organitation::whereCctEscuela($request->elct)->whereOdireccionnivel($odir)->OrderBy('cct_escuela')->get();
      }else if(Auth::user()->onivel=='SECUNDARIA'){
         $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         $cts = Organitation::whereCctEscuela($request->elct)->whereOdireccionnivel($odir)->OrderBy('cct_escuela')->get();
      }
      
      if($cts)
      {
         $ban = 1;
      }else{
         $ban = 0;
      }
      $requeste = $request->elct;
      

         return view('admin.ct.show', 
                  compact('cts', 'ban','requeste' )
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
               ->whereNotIn('cct_departamento',[1])
               ->GroupBy('idct_departamento','cct_departamento')->get();

      $sectors= Organitation::select('idct_sector','cct_sector')
               ->whereOdireccionnivel($odir)
               ->whereNotIn('cct_sector',[1])
               ->GroupBy('idct_sector','cct_sector')->get();

      $supers= Organitation::select('idct_supervicion','cct_supervision')
               ->whereOdireccionnivel($odir)
               ->whereNotIn('cct_supervision',[1])
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
                  'ocp.required'       => 'Selecciona el valle',
                  'otel.required'      => 'Elije el total de plazas (ocupadas y vacantes)',
                  'ocorreo.required'   => 'Elije el total de plazas ocupadas',
                  'ompio.required'     => 'Selecciona la categoría/plaza', 
            ]);

            if(Auth::user()->onivel=='ELEMENTAL')
            {
               $odir='DIRECCIÓN DE EDUCACIÓN ELEMENTAL';
            }else if(Auth::user()->onivel=='SECUNDARIA'){
               $odir='DIRECCIÓN DE EDUCACIÓN SECUNDARIA Y SERVICIOS DE APOYO';
            }

            if($request->osubdir>0){
               $getSub = Organitation::select('cct_subdireccion')->whereIdctSubdireccion($request->osubdir)
                        ->whereOdireccionnivel($odir)->GroupBy('cct_subdireccion')->first();
               $subdir = $request->osubdir;
               $gsubdir= $getSub->cct_subdireccion;

            }else{
               $subdir = $request->osubdir;
               $gsubdir=1;
            }

            if($request->odepto>0){
               $getDpto= Organitation::select('cct_departamento')->whereIdctDepartamento($request->odepto)
                        ->whereOdireccionnivel($odir)->GroupBy('cct_departamento')->first();
               $depto  = $request->odepto; 
               $gdepto = $getDpto->cct_departamento;

            }else{
               $depto = $request->odepto; 
               $gdepto=1;             
            }

            if($request->osector>0){
               $getSec = Organitation::select('cct_sector')->whereIdctSector($request->osector)
                        ->whereOdireccionnivel($odir)->GroupBy('cct_sector')->first();
               $sector = $request->osector;
               $gsector= $getSec->cct_sector;

            }else{
               $sector = $request->osector;
               $gsector=1;
            }

            if($request->osuper>0){
               $getSup = Organitation::select('cct_supervision')->whereIdctSupervicion($request->osuper)
                        ->whereOdireccionnivel($odir)->GroupBy('cct_supervision')->first();
               $super  = $request->osuper;
               $gsuper = $getSup->cct_supervision;

            }else{
               $super = $request->osuper;  
               $gsuper=1; 
            }


      $checkact = CentrosTrabajo::whereOclave($request->oct)->first();

      if($checkact){
         return redirect(url('centros-de-trabajo'))
                      ->with("info", "Atención este CT ya está registrado");  
      }else{


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
                              'idct_subdireccion'  => $subdir,
                              'cct_subdireccion'   => $gsubdir,
                              'idct_departamento'  => $depto,
                              'cct_departamento'   => $gdepto,
                              'idct_sector'        => $sector,
                              'cct_sector'         => $gsector,
                              'idct_supervicion'   => $super,
                              'cct_supervision'    => $gsuper,
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



}
