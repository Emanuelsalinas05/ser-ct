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
        
        // Validar existencia de acta activa
        if (!$datosacta) {
            return redirect()->route('entrega-recepcion.index')
                ->with('warning', 'No tienes un acta de entrega-recepción activa. Por favor, crea una nueva acta primero.');
        }
        
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        // IMPORTANTE: Filtrar por id_acta para que cada acta tenga sus propios datos
        // No mezclar datos de diferentes actas del mismo centro de trabajo
        $juridicos  = Ordenamientojuridico::whereIdActa($datosacta->id)
                        ->whereNotIn('status', ['B'])
                        ->OrderBy('id', 'ASC')->get();
        $getjuridico= Ordenamientojuridico::whereIdActa($datosacta->id)
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

            // Obtener la acta activa del usuario
            $datosacta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
            
            if (!$datosacta) {
                return redirect()->route('entrega-recepcion.index')
                    ->with('warning', 'No tienes un acta de entrega-recepción activa. Por favor, crea una nueva acta primero.');
            }

            // IMPORTANTE: Guardar el id_acta para asociar el registro a la acta específica
            Ordenamientojuridico::create([
                'id_ct'                     => Auth::user()->id_ct,
                'id_acta'                   => $datosacta->id, // Asociar a la acta activa
                'odenominacion_juridica'    => mb_strtoupper($request->oordenamiento, 'UTF-8'),
                'omedio_oficial_publicacion'=> mb_strtoupper($request->omediooficial, 'UTF-8'),
                'ofecha_publicacion'        => $request->ofechapublicacion,
                'ourl_publicacion'          => $request->olocalizador,
            ]);


            return redirect(url('marco-juridico'));

    }



    public function update(Request $request, string $id)
    {
        // Obtener la acta activa del usuario
        $datosacta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        
        if (!$datosacta) {
            return redirect()->route('entrega-recepcion.index')
                ->with('warning', 'No tienes un acta de entrega-recepción activa.');
        }
        
        if($request->action==1){ 
            // Validar que el registro pertenezca a la acta activa
            $update_mj = Ordenamientojuridico::whereId($id)
                            ->whereIdActa($datosacta->id)
                            ->first();
            
            if (!$update_mj) {
                return redirect(url('marco-juridico'))
                    ->with('error', 'El registro no pertenece a tu acta activa.');
            }

            $update_mj->update([ 
                                'odenominacion_juridica'    => mb_strtoupper($request->oordenamiento, 'UTF-8'),
                                'omedio_oficial_publicacion'=> mb_strtoupper($request->omediooficial, 'UTF-8'),
                                'ofecha_publicacion'        => $request->ofechapublicacion,
                                'ourl_publicacion'          => $request->olocalizador,
                            ]);

            return redirect(url('marco-juridico'));

        }else if($request->action==2){
            // Validar que el registro pertenezca a la acta activa
            $update_mj = Ordenamientojuridico::whereId($id)
                            ->whereIdActa($datosacta->id)
                            ->first();
            
            if (!$update_mj) {
                return redirect(url('marco-juridico'))
                    ->with('error', 'El registro no pertenece a tu acta activa.');
            }

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
