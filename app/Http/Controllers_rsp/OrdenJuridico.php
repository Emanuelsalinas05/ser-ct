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
use App\Models\Plantillapersonal;

class OrdenJuridico extends Controller
{


    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(1)->first();
        $documento  = Documentos::whereId(1)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)
                        ->whereNotIn('status', ['B'])
                        ->OrderBy('id', 'ASC')->get();
        $getjuridico= Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)
                        ->whereNotIn('status', ['B'])
                        ->OrderBy('id', 'ASC')->count();
        return view('documentos.marco-juridico.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'juridicos', 'getjuridico')
                );
    }



    public function store(Request $request)
    {
            $validatedData = $request->validate([
                'oordenamiento'     => 'required',
                'omediooficial'     => 'required',
                'ofechapublicacion' => 'required',
                'olocalizador'      => 'required',
            ],$message=[
                'oordenamiento.required'     => 'Escribe el nombre del orden jurídico',
                'omediooficial.required'     => 'Ingresa el medio oficial del orden jurídico',
                'ofechapublicacion.required' => 'Ingresa la fecha de publicación',
                'olocalizador.required'      => 'Ingresa la url del orden juridico',
            ]);


            Ordenamientojuridico::create([
                'id_ct'                     => Auth::user()->id_ct,
                'odenominacion_juridica'    => $request->oordenamiento,
                'omedio_oficial_publicacion'=> $request->omediooficial,
                'ofecha_publicacion'        => $request->ofechapublicacion,
                'ourl_publicacion'          => $request->olocalizador,
            ]);


            return redirect(url('marco-juridico'));

    }



    public function update(Request $request, string $id)
    {
        
        if($request->action==1){ 

            $update_mj = Ordenamientojuridico::whereId($id);
            $update_mj->update([ 
                                'odenominacion_juridica'    => $request->oordenamiento,
                                'omedio_oficial_publicacion'=> $request->omediooficial,
                                'ofecha_publicacion'        => $request->ofechapublicacion,
                                'ourl_publicacion'          => $request->olocalizador,
                            ]);

            return redirect(url('marco-juridico'));

        }else if($request->action==2){

            $update_mj = Ordenamientojuridico::whereId($id);
            $update_mj->update([ 'status' => 'B', ]);

            return redirect(url('marco-juridico'));

        }else if($request->action==9){

            $datosacta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

            $update_avances = Avanceanexos::whereId($datosacta->id);
            $update_avances->update([ 
                                    'omarco_juridico_d'      => 1,
                                    'omarco_juridico_a'      => 1,
                                    'ofecha_omarco_juridico' => date('Y-m-d'),
                                    'oopenanexo'             => 0,
                                    ]);

            $update_acta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0);
            $update_acta->update([  'oopenanexo' => 0 ]);

            return redirect(url('entrega-recepcion'))
                    ->with('success', 'Se ha registrado el marco jurídico correctamente');
        } 



    }



}
