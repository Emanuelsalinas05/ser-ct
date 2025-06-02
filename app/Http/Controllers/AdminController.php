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
        if (!Auth::check()) return redirect('/');

        $usuario = Auth::user();

        if ($usuario->orol > 2) {
            return redirect('entrega-recepcion');
        }

        $ck = match($usuario->ocargo) {
            'DIRECCIÓN'     => 1,
            'SUBDIRECCIÓN'  => 2,
            'DEPARTAMENTO'  => 3,
            'SECTOR'        => 4,
            'SUPERVISIÓN'   => 5,
            default         => 0,
        };

        $orgQuery = Organitation::query();

        // Filtro jerárquico según cargo
        match($usuario->ocargo) {
            'DIRECCIÓN' => $orgQuery->where('cct_direccion', $usuario->oct),
            'SUBDIRECCIÓN' => $orgQuery->where('cct_subdireccion', $usuario->oct),
            'DEPARTAMENTO' => $orgQuery->where('cct_departamento', $usuario->oct),
            'SECTOR' => $orgQuery->where('cct_sector', $usuario->oct),
            'SUPERVISIÓN' => $orgQuery->where('cct_supervision', $usuario->oct),
            default => null,
        };

        // Obtener IDs de centros de trabajo subordinados
        $idsCT = $orgQuery->pluck('idct_escuela')
            ->merge($orgQuery->pluck('idct_supervicion'))
            ->merge($orgQuery->pluck('idct_sector'))
            ->unique()
            ->filter(fn($id) => $id > 0);

        // Obtener usuarios finales
        $usuariosFinales = User::where('orol', 3)
            ->whereIn('id_ct', $idsCT)
            ->get();

        return view('admin.users.index', compact('ck', 'usuariosFinales'));
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
