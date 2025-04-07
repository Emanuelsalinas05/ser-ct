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

class UsersLevelsController extends Controller
{
    public function index()
    {
        /*
        if (Auth::check())
        { 
            if ( Auth::user()->orol<=2 )
            {
                $usuarios      = User::whereIn('onivel', [Auth::user()->onivel])
                                ->whereNotIn('status', ['B'])
                                ->whereIn('orol', [1,2])
                                ->whereNotIn('status', ['B'])
                                ->whereNotIn('id', [1,2,3, Auth::user()->id])->get();

                $centrotrabajo = CentrosTrabajo::get();

                return view('admin.users-levels.index',
                        compact('usuarios', 'centrotrabajo',)
                        );
            }else if(Auth::user()->orol==3){

                return url('entrega-recepcion');

            }
        }
       */
       

       /*

            $alumnodoc_sql="SELECT go.idct_supervicion, go.cct_supervision, 
                            ct.kcvect, ct.oclave, ct.onombre_ct, ct.odireccion
                            FROM g1organigrama go, g1centros_trabajo ct
                            WHERE go.cct_supervision=ct.oclave
                            AND ct.odireccion='SECUNDARIA'  
                            GROUP BY 
                            go.idct_supervicion, go.cct_supervision, 
                            ct.kcvect, ct.oclave, ct.onombre_ct, ct.odireccion
                            ORDER BY go.cct_supervision ;
                            ";
            $alumnodoc = DB::select($alumnodoc_sql);

            function generateRandomString($length = 10){ 
                    return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
                }
            foreach($alumnodoc as $user)
            {
    
                $elfolio = generateRandomString();

                User::create([
                        'name'      => $user->onombre_ct,
                        'orfc'      => NULL,
                        'ocurp'     => NULL,
                        'id_ct'     => $user->kcvect,
                        'oct'       => $user->cct_supervision,
                        'email'     => $user->cct_supervision,
                        'password'  => Hash::make($elfolio),
                        'opwd'      => $elfolio,
                        'orol'      => 3,
                        'ocorreo'   => NULL,  
                        'ocargo'    => 'ESCUELA',  
                        'onivel'    => $user->odireccion,
                        'id_ctorigen'=> 62,
                        'octorigen' => '15ADG0089K',
                    ]);


            }

            */
         
    }

    public function create()
    {
        

        if ( Auth::user()->onivel=='ELEMENTAL')
        {
            $centrotrabajo = CentrosTrabajo::whereOdireccion(Auth::user()->onivel)->whereOstatus(1)->get();
            $direccionx = 'DIRECCION DE EDUCACION ELEMENTAL';
        }else if ( Auth::user()->onivel=='SECUNDARIA'){
            $centrotrabajo = CentrosTrabajo::whereOdireccion(Auth::user()->onivel)->whereOstatus(1)->get();
            $direccionx = 'DIRECCION DE EDUCACION SECUNDARIA Y SERVICIOS DE APOYO';
        }else if ( Auth::user()->onivel=='SUPERIOR'){
            $centrotrabajo = CentrosTrabajo::whereOdireccion(Auth::user()->onivel)->whereOstatus(1)->get();
            $direccionx = 'DIRECCIÓN DE EDUCACIÓN ELEMENTAL';
        }else{
            $centrotrabajo = CentrosTrabajo::whereOstatus(1)->get();
        }

        $ex = Organitation::first();

        $organitationx = Organitation::select('g1organigrama.id', 'g1organigrama.cct_departamento', 'g1centros_trabajo.onombre_ct', 
                                              'g1centros_trabajo.kcvect', 'g1organigrama.ovalle')
                        ->where('g1organigrama.odireccionnivel',$direccionx)
                        ->GroupBy('g1organigrama.id', 'g1organigrama.cct_departamento', 'g1centros_trabajo.onombre_ct', 
                                  'g1centros_trabajo.kcvect', 'g1organigrama.ovalle')
                        ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_departamento')
                        ->whereNotIn('g1organigrama.cct_departamento', ['',0])->get();

        $organitationa = Organitation::select('g1organigrama.id', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct', 
                                              'g1centros_trabajo.kcvect', 'g1organigrama.ovalle')
                        ->where('g1organigrama.odireccionnivel',$direccionx)
                        ->GroupBy('g1organigrama.id', 'g1organigrama.cct_sector', 'g1centros_trabajo.onombre_ct', 
                                  'g1centros_trabajo.kcvect', 'g1organigrama.ovalle')
                        ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'g1organigrama.cct_sector')
                        ->whereNotIn('g1organigrama.cct_sector', ['',0])->get();

        $organitationb = Organitation::select('g1organigrama.id', 'g1organigrama.cct_supervision', 'g1centros_trabajo.onombre_ct', 
                                              'g1centros_trabajo.kcvect', 'g1organigrama.ovalle')
                        ->where('g1organigrama.odireccionnivel',$direccionx)
                        ->GroupBy('g1organigrama.id', 'g1organigrama.cct_supervision', 'g1centros_trabajo.onombre_ct', 
                                  'g1centros_trabajo.kcvect', 'g1organigrama.ovalle')
                        ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.oclave', 'cct_supervision')
                        ->whereNotIn('g1organigrama.cct_supervision', ['',0])->get();

        if ( Auth::user()->orol==1 )
        {
        $roles = Rolesusers::whereNotIn('id', [1])->OrderBy('id', 'DESC')->get();
        }else{
        $roles = Rolesusers::get();
        }
        return view('admin.users-levels.create',
            compact('centrotrabajo', 'roles', 'organitationx', 'organitationa', 'organitationb', 'ex')
                );
    }

    public function store(Request $request)
    {
        $us = User::whereIdCt($request->oct)->first();

            function generateRandomString($length = 10){ 
                return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
            }
            $elfolio = generateRandomString();
            $getct = CentrosTrabajo::whereId($request->oct)->first();

            if($us){

                return redirect()
                        ->route('usuarios.index')
                        ->with("warning", "ESTE USUARIO YA SE HA REGISTRADO");
            }else{
                
                    User::create([
                        'name'      => $getct->onombre_ct,
                        'orfc'      => NULL,
                        'ocurp'     => NULL,
                        'id_ct'     => $request->oct,
                        'oct'       => $getct->oclave,
                        'email'     => $getct->oclave,
                        'password'  => Hash::make($elfolio),
                        'opwd'      => $elfolio,
                        'orol'      => 2,
                        'ocorreo'   => NULL,   
                        'onivel'    => $getct->odireccion,
                        'id_ctorigen'=> Auth::user()->id_ct,
                        'octorigen' => Auth::user()->email,
                    ]);

                return redirect()
                        ->route('usuarios-niveles.index')
                        ->with("success", "SE HA REGISTRADO CORRECTAMENTE EL USUARIO.");
            }
    }



    public function edit($id)
    {
        $user          = User::whereId($id)->first();
        $centrotrabajo = CentrosTrabajo::get();
        $roles         = Rolesusers::get();
        return view('admin.users-levels.edit',
                compact('user', 'centrotrabajo', 'roles')
                );
    }



    public function update(Request $request, string $id)
    {
            function generateRandomString($length = 10){ 
                return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
            }
            $elfolio = generateRandomString();

            $usuario = User::find($id);
            $usuario->password  = Hash::make($elfolio);
            $usuario->opwd      = $elfolio;
            $usuario->save();

        return redirect()
            ->route('usuarios-niveles.index')
            ->with("success", "Se ha actualizado el usuario correctamente.");
    }


}
