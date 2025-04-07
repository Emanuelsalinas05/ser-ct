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
use App\Models\Solicitudnoadeudo;

class _xCaoehController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $nivel =  Auth::user()->onivel=='SECUNDARIA' ;


        $solicitudesc = Solicitudnoadeudo::whereIdTipocert(2)->whereOgestion(1)->count();
            //$solicitudes  = Solicitudnoadeudo::select('*',  DB::raw('date_format(ofecha, "%d-%m-%Y") as fecha'), B::raw('date_format(ofecha_acta, "%d-%m-%Y") as fechaacta')) ->whereIdTipocert(2)->whereOfinalizado(1)->whereOgestion(0)->get(); -- og.cct_sector, ct.omodalidad, og.cct_supervision, ctt.omodalidad, og.cct_escuela, cttt.omodalidad
            $solicitudesx="select 
                            n.id as idsol, n.id_tipocert, n.id_acta, c.omodalidad as modct, a.oct_a, n.oficio,
                            c.onombre_ct AS ct_entrega, a.orfc_entrega_a, a.onombre_entrega_a,
                            a.id as idacta, a.id_ct, 
                            case when c.omodalidad='dpr' 
                                then concat(og.cct_subdireccion,' - ',ce.onombre_ct)
                                else concat(og.cct_departamento,' - ', cee.onombre_ct)
                            end as ctlevel, a.*
                            from 
                            g1solicitudes_noadeudos n , g1centros_trabajo c,  
                            g1acta a
                            left join g1organigrama og
                            on og.idct_sector = a.id_ct or og.idct_supervicion = a.id_ct or og.idct_escuela = a.id_ct
                            left join g1centros_trabajo ct
                            on ct.oclave = og.cct_sector  
                            left join g1centros_trabajo ctt
                            on ctt.oclave = og.cct_supervision
                            left join g1centros_trabajo cttt
                            on cttt.oclave = og.cct_escuela
                            left join g1centros_trabajo ce
                            on ce.oclave = og.cct_subdireccion
                            left join g1centros_trabajo cee
                            on ce.oclave = og.cct_departamento
                            where n.id_acta = a.id
                            and     a.id_ct = c.id 
                            and     n.id_tipocert = 2 
                            and     n.ofinalizado = 1 
                            and     n.ogestion = 1
                            and     c.odireccion='$nivel' ";
            $solicitudes = DB::select($solicitudesx); 

            return view('caoe.historico.index',
                    compact('solicitudesc', 'solicitudes')
                    );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
