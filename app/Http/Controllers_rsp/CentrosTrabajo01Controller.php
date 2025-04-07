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

class CentrosTrabajo01Controller extends Controller
{

   public function index()
   {
         if(Auth::user()->onivel=='ELEMENTAL')
         {
            $odir='DIRECCION DE EDUCACION ELEMENTAL';
         }else if(Auth::user()->onivel=='SECUNDARIA'){
            $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         }
            
         $cts = Organitation::select(DB::raw('users.id as idus'),'idct_subdireccion','cct_subdireccion','users.id_ct','users.email','users.opwd','users.name','users.oct')
                  ->whereOdireccionnivel($odir)
                  ->leftJoin('users', 'users.id_ct', 'idct_subdireccion')
                  ->GroupBy(DB::raw('users.id'),'idct_subdireccion','cct_subdireccion','users.id_ct','users.email','users.opwd','users.name','users.oct')
                  ->get(1);

         return view('admin.users.users-levels.02subdireccion.index', 
                  compact('cts' )
                  );
    }



   public function ussub()
   {
         if(Auth::user()->onivel=='ELEMENTAL')
         {
            $odir='DIRECCION DE EDUCACION ELEMENTAL';
         }else if(Auth::user()->onivel=='SECUNDARIA'){
            $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         }

         switch (Auth::user()->ocargo ) 
         {
            case 'DIRECCIÓN':
               $param = 'idct_direccion';
            break;

            case 'SUBDIRECCIÓN':
               $param = 'idct_subdireccion';
            break;

            case 'DEPARTAMENTO':
               $param = 'idct_departamento';
            break;

            case 'SECTOR':
               $param = 'idct_sector';
            break;

            case 'SUPERVISIÓN':
               $param = 'idct_supervicion';
            break;
         }  

         $cts = Organitation::select(DB::raw('users.id as idus'),'idct_subdireccion','cct_subdireccion', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->leftJoin('users', 'users.id_ct', 'idct_subdireccion')
                  ->whereNotIn($param, [0])
                  ->where($param, Auth::user()->id_ct)
                  ->where('users.orol', 2)
                  ->GroupBy(DB::raw('users.id'),'idct_subdireccion','cct_subdireccion', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->get();
         /*
         $cts = Organitation::select('idct_subdireccion','cct_subdireccion')->whereNotIn('cct_subdireccion',[1])->where('idct_direccion',Auth::user()->id_ct)->Orwhere('idct_subdireccion',Auth::user()->id_ct)->Orwhere('idct_departamento',Auth::user()->id_ct)->Orwhere('idct_sector',Auth::user()->id_ct)->Orwhere('idct_supervicion',Auth::user()->id_ct)->GroupBy('idct_subdireccion','cct_subdireccion')>get();
         */

         return view('admin.users.users-levels.02subdireccion.index', 
                  compact('cts' )
                  );
    }




   public function usdep()
   {
         if(Auth::user()->onivel=='ELEMENTAL')
         {
            $odir='DIRECCION DE EDUCACION ELEMENTAL';
         }else if(Auth::user()->onivel=='SECUNDARIA'){
            $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         }
            
         /*
         $cts = Organitation::select('idct_departamento','cct_departamento')->whereNotIn('cct_departamento',[1])->where('idct_direccion',Auth::user()->id_ct)>Orwhere('idct_subdireccion',Auth::user()->id_ct)->Orwhere('idct_departamento',Auth::user()->id_ct)->Orwhere('idct_sector',Auth::user()->id_ct)->Orwhere('idct_supervicion',Auth::user()->id_ct)->GroupBy('idct_departamento','cct_departamento'->get();
         */

         switch (Auth::user()->ocargo ) 
         {
            case 'DIRECCIÓN':
               $param = 'idct_direccion';
            break;

            case 'SUBDIRECCIÓN':
               $param = 'idct_subdireccion';
            break;

            case 'DEPARTAMENTO':
               $param = 'idct_departamento';
            break;

            case 'SECTOR':
               $param = 'idct_sector';
            break;

            case 'SUPERVISIÓN':
               $param = 'idct_supervicion';
            break;
         }  

         $cts = Organitation::select(DB::raw('users.id as idus'),'idct_departamento','cct_departamento', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->leftJoin('users', 'users.id_ct', 'idct_departamento')
                  ->whereNotIn($param, [0])
                  ->where($param, Auth::user()->id_ct)
                  ->where('users.orol', 2)
                  ->GroupBy(DB::raw('users.id'),'idct_departamento','cct_departamento', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->get();
      //return view('admin.organitation.index', 
         return view('admin.users.users-levels.03departamento.index', 
                  compact('cts')
                  );
    }



   public function ussec()
   {
         if(Auth::user()->onivel=='ELEMENTAL')
         {
            $odir='DIRECCION DE EDUCACION ELEMENTAL';
         }else if(Auth::user()->onivel=='SECUNDARIA'){
            $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         }

         switch (Auth::user()->ocargo ) 
         {
            case 'DIRECCIÓN':
               $param = 'idct_direccion';
            break;

            case 'SUBDIRECCIÓN':
               $param = 'idct_subdireccion';
            break;

            case 'DEPARTAMENTO':
               $param = 'idct_departamento';
            break;

            case 'SECTOR':
               $param = 'idct_sector';
            break;

            case 'SUPERVISIÓN':
               $param = 'idct_supervicion';
            break;
         }  

         $cts = Organitation::select(DB::raw('users.id as idus'),'idct_sector','cct_sector', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->leftJoin('users', 'users.id_ct', 'idct_sector')
                  ->whereNotIn($param, [0])
                  ->where($param, Auth::user()->id_ct)
                  ->where('users.orol', 2)
                  ->GroupBy(DB::raw('users.id'),'idct_sector','cct_sector', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->get();

         /*
         $cts = Organitation::select('idct_sector','cct_sector')->whereNotIn('cct_sector',[1])->where('idct_direccion',Auth::user()->id_ct)->Orwhere('idct_subdireccion',Auth::user()->id_ct)->Orwhere('idct_departamento',Auth::user()->id_ct)->Orwhere('idct_sector',Auth::user()->id_ct)->Orwhere('idct_supervicion',Auth::user()->id_ct)->GroupBy('idct_sector','cct_sector')->get();
         */

         return view('admin.users.users-levels.04sector.index', 
                  compact('cts', )
                  );
   }




   public function ussup()
   {
         if(Auth::user()->onivel=='ELEMENTAL')
         {
            $odir='DIRECCION DE EDUCACION ELEMENTAL';
         }else if(Auth::user()->onivel=='SECUNDARIA'){
            $odir='DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
         }
         
         switch (Auth::user()->ocargo ) 
         {
            case 'DIRECCIÓN':
               $param = 'idct_direccion';
            break;

            case 'SUBDIRECCIÓN':
               $param = 'idct_subdireccion';
            break;

            case 'DEPARTAMENTO':
               $param = 'idct_departamento';
            break;

            case 'SECTOR':
               $param = 'idct_sector';
            break;

            case 'SUPERVISIÓN':
               $param = 'idct_supervicion';
            break;
         }  

         $cts = Organitation::select(DB::raw('users.id as idus'),'idct_supervicion','cct_supervision', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->leftJoin('users', 'users.id_ct', 'idct_supervicion')
                  ->whereNotIn($param, [0])
                  ->where($param, Auth::user()->id_ct)
                  ->where('users.orol', 2)
                  ->GroupBy(DB::raw('users.id'),'idct_supervicion','cct_supervision', 'users.id_ct', 'users.oct', 'users.name', 'users.email','users.opwd','users.ovalle')
                  ->get();


         return view('admin.users.users-levels.05supervision.index', 
                  compact('cts', 'param' )
                  );
    }








    public function edit($id)
    {
        $user = User::whereId($id)->first();

        switch ($user->ocargo) {
            case 'DIRECCIÓN':
               $level = 'idct_direccion';
               $nivel = 1;
               $ruta  = 'usuarios-direccion';
            break;

            case 'SUBDIRECCIÓN':
               $level = 'idct_subdireccion';
               $nivel = 2;
               $ruta  = 'usuarios-subdireccion';
            break;

            case 'DEPARTAMENTO':
               $level = 'idct_departamento';
               $nivel = 3;
               $ruta  = 'usuarios-departamento';
            break;

            case 'SECTOR':
               $level = 'idct_sector';
               $nivel = 4;
               $ruta  = 'usuarios-sector ';
            break;

            case 'SUPERVISIÓN':
               $level = 'idct_supervicion';
               $nivel = 5;
               $ruta  = 'usuarios-supervision';
            break;
        }

        $org  = Organitation::where($level, $user->id_ct)->first();

        return view('admin.users.users-levels.edit',
                compact('user','org','nivel','ruta')
                );
    }



}
