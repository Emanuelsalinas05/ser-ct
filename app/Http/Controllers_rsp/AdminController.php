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
use App\Models\Rolesusers;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check())
        { 
                if ( Auth::user()->orol<=2 )
                {
                        $usuarios = User::whereId(Auth::user()->id)->first();

                        $centrotrabajo = CentrosTrabajo::get();


                        if(Auth::user()->ocargo=='DIRECCIÓN')
                        {   

                                    $ussec  = Organitation::select('idct_sector','cct_sector')
                                                ->leftJoin('users', 'users.id_ct', 'idct_sector')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_direccion',$usuarios->oct)
                                                ->where('idct_sector','>',0)
                                                ->GroupBy('idct_sector','cct_sector')
                                                ->get();

                                    $ussup  = Organitation::select('idct_supervicion','cct_supervision')
                                                ->leftJoin('users', 'users.id_ct', 'idct_supervicion')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_direccion',$usuarios->oct)
                                                ->whereNotIn('idct_supervicion', [0])
                                                ->GroupBy('idct_supervicion','cct_supervision')
                                                ->get();

                                    $usct   = Organitation::select('idct_escuela','cct_escuela')
                                                ->leftJoin('users', 'users.id_ct', 'idct_escuela')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_direccion',$usuarios->oct)
                                                ->get();

                                    $ck = 1;

                                    return view('admin.users.index',
                                            compact('ck','usuarios', 'usct', 'ussup', 'ussec', )
                                                );

                        }else if(Auth::user()->ocargo=='SUBDIRECCIÓN'){


                                    $ussec  = Organitation::select('idct_sector','cct_sector')
                                                ->leftJoin('users', 'users.id_ct', 'idct_sector')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_subdireccion',$usuarios->oct)
                                                ->where('idct_sector','>',0)
                                                ->GroupBy('idct_sector','cct_sector')
                                                ->get();

                                    $ussup  = Organitation::select('idct_supervicion','cct_supervision')
                                                ->leftJoin('users', 'users.id_ct', 'idct_supervicion')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_subdireccion',$usuarios->oct)
                                                ->whereNotIn('idct_supervicion', [0])
                                                ->GroupBy('idct_supervicion','cct_supervision')
                                                ->get();

                                    $usct   = Organitation::select('idct_escuela','cct_escuela')
                                                ->leftJoin('users', 'users.id_ct', 'idct_escuela')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_subdireccion',$usuarios->oct)
                                                ->get();



                                    $ck = 2;

                                return view('admin.users.index',
                                        compact('ck','usuarios', 'usct', 'ussup', 'ussec', )
                                            );

                        }else if(Auth::user()->ocargo=='DEPARTAMENTO'){

                                
                                    $ussec  = Organitation::select('idct_sector','cct_sector')
                                                ->leftJoin('users', 'users.id_ct', 'idct_sector')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_departamento',$usuarios->oct)
                                                ->where('idct_sector','>',0)
                                                ->GroupBy('idct_sector','cct_sector')
                                                ->get();

                                    $ussup  = Organitation::select('idct_supervicion','cct_supervision')
                                                ->leftJoin('users', 'users.id_ct', 'idct_supervicion')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_departamento',$usuarios->oct)
                                                ->whereNotIn('idct_supervicion', [0])
                                                ->GroupBy('idct_supervicion','cct_supervision')
                                                ->get();

                                    $usct   = Organitation::select('idct_escuela','cct_escuela')
                                                ->leftJoin('users', 'users.id_ct', 'idct_escuela')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_departamento',$usuarios->oct)
                                                ->get();


                                    $ck = 3;

                                    return view('admin.users.index',
                                            compact('ck','usuarios', 'usct', 'ussup', 'ussec', )
                                                );

                        }else if(Auth::user()->ocargo=='SECTOR'){


                                    $ussup  = Organitation::select('idct_supervicion','cct_supervision')
                                                ->leftJoin('users', 'users.id_ct', 'idct_supervicion')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_sector',$usuarios->oct)
                                                ->whereNotIn('idct_supervicion', [0])
                                                ->GroupBy('idct_supervicion','cct_supervision')
                                                ->get();

                                    $usct   = Organitation::select('idct_escuela','cct_escuela')
                                                ->leftJoin('users', 'users.id_ct', 'idct_escuela')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_sector',$usuarios->oct)
                                                ->get();


                                    $ck = 4;

                                    return view('admin.users.index',
                                            compact('ck','usct','ussup',)
                                                );


                        }else if(Auth::user()->ocargo=='SUPERVISIÓN'){

                                    $usct   = Organitation::select('idct_escuela','cct_escuela')
                                                ->leftJoin('users', 'users.id_ct', 'idct_escuela')
                                                ->where('users.orol', '=', 3)
                                                ->where('cct_supervision',$usuarios->oct)
                                                ->get();


                                    $ck = 5;

                                    return view('admin.users.index',
                                            compact('ck','usct',)
                                                );

                        }





                }else if(Auth::user()->orol==3){

                        $datosacta = DatosActa::get();
                        return url('entrega-recepcion');

                }
        }
    }



    public function show(Request $request,$id)
    {

        $userx  = User::whereOct($request->elct)->whereOrol(3)->first();

        $user  = Organitation::where('cct_escuela',$userx->email)
                ->orWhere('cct_supervision',$userx->email)
                ->orWhere('cct_sector',$userx->email)->first();

        
        if($user)
        {
            $ban = 1;
        }else{
            $ban = 0;
        }
        $requeste = $request->elct;
        
        return view('admin.users.show',
                compact('userx', 'user', 'ban', 'requeste')
                );

    }





    public function edit($id)
    {
        $user = User::whereId($id)->first();
        $org  = Organitation::where('idct_escuela',$user->id_ct)
                ->orWhere('idct_supervicion',$user->id_ct)
                ->orWhere('idct_sector',$user->id_ct)->first();

        return view('admin.users.edit',
                compact('user','org',)
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

        return redirect()->back()->with("success", "Se ha actualizado la contraseña correctamente.");
           // ->route('usuarios.index')
            
    }



    public function create()
    {
        if ( Auth::user()->onivel=='ELEMENTAL')
        {
            $centrotrabajo = CentrosTrabajo::whereOdireccion(Auth::user()->onivel)->whereOstatus(1)->get();
        }else if ( Auth::user()->orol=='SECUNDARIA'){
            $centrotrabajo = CentrosTrabajo::whereOdireccion(Auth::user()->onivel)->whereOstatus(1)->get();
        }else if ( Auth::user()->orol=='SUPERIOR'){
            $centrotrabajo = CentrosTrabajo::whereOdireccion(Auth::user()->onivel)->whereOstatus(1)->get();
        }else{
            $centrotrabajo = CentrosTrabajo::whereOstatus(1)->get();
        }
       
        if ( Auth::user()->orol==1 )
        {
        $roles = Rolesusers::whereNotIn('id', [1])->OrderBy('id', 'DESC')->get();
        }else{
        $roles = Rolesusers::get();
        }
        return view('admin.users.create',
                compact('centrotrabajo', 'roles')
                );
    }



    public function store(Request $request)
    {
        $us = User::whereIdCt($request->oct)->first();

            function generateRandomString($length = 10){ 
                return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length); 
            }
            $elfolio = generateRandomString();
            $getct = CentrosTrabajo::whereKcvect($request->oct)->first();

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
                        'orol'      => 3,
                        'ocorreo'   => NULL,   
                        'onivel'    => $getct->odireccion,
                        'id_ctorigen'=> Auth::user()->id_ct,
                        'octorigen' => Auth::user()->email,
                    ]);

                return redirect()
                        ->route('usuarios.index')
                        ->with("success", "SE HA REGISTRADO CORRECTAMENTE EL USUARIO.");
            }
    }





}
