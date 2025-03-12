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
use App\Models\Inventariobienes;
use App\Models\Inventarioalmacen;
use App\Models\Relacioncustodias;
use App\Models\Archivostramite;
use App\Models\Archivoshistorico;
use App\Models\Documentoshemerograficos;
use App\Models\Certificadosnoadeudo;
use App\Models\Informegestion;
use App\Models\Compromisos90dias;

class Rmcompromisos90dias extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(13)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $icompromisos  = Compromisos90dias::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $icompromisosc = Compromisos90dias::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.informe-gestion.15-2.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'icompromisos', 'icompromisosc')
                );
    }

    public function create()
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(13)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        return view('documentos.informe-gestion.15-2.create', 
                compact('anexo', 'documento', 'datosacta', 'avances')
                );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'odescripcion_asunto'=> 'required',
            'oresponsable'       => 'required',
            'oacciones_realizar' => 'required',
            'olugar'             => 'required',
            'ofecha'             => 'required',
            'ohora'              => 'required',
        ],$message=[
            'odescripcion_asunto.required'=> 'Debes registrar la descripción',
            'oresponsable.required'       => 'Registra al responsable',
            'oacciones_realizar.required' => 'Ingresa las acciones a realizar',
            'olugar.required'             => 'Ingresa el lugar',
            'ofecha.required'             => 'Ingresa la fecha',
            'ohora.required'              => 'Ingresa la hora',
        ]);

        Compromisos90dias::create([
            'id_acta'=> $request->acta,
            'id_ct'  => Auth::user()->id_ct,
            'odescripcion_asunto'=> $request->odescripcion_asunto,
            'oresponsable'       => $request->oresponsable,
            'oacciones_realizar' => $request->oacciones_realizar,
            'olugar'             => $request->olugar,
            'ofecha'             => $request->ofecha,
            'ohora'              => $request->ohora,
            'oanio'              => date('Y-m-d'),     
        ]);    

        return redirect(url('informe-compromisos'))
                ->with('success', 'Se guardó el compromiso correctamente');
    }

    public function edit(string $id)
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(13)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $icompromisos  = Compromisos90dias::whereId($id)->first();

        return view('documentos.informe-gestion.15-2.edit', 
                    compact('anexo', 'documento', 'datosacta', 'avances', 'icompromisos',)
                    );
    }

    public function update(Request $request, string $id)
    {
        if($request->action=='0')
        {
            $update_compromisos = Compromisos90dias::find($id);
            $update_compromisos->odescripcion_asunto= $request->odescripcion_asunto;
            $update_compromisos->oresponsable       = $request->oresponsable;
            $update_compromisos->oacciones_realizar = $request->oacciones_realizar;
            $update_compromisos->olugar             = $request->olugar;
            $update_compromisos->ofecha             = $request->ofecha;
            $update_compromisos->ohora              = $request->ohora;
            $update_compromisos->save();

            return redirect(url('informe-compromisos'))
                ->with('success', 'Se modificó el compromiso correctamente');
        }else if($request->action=='1'){
            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['oinforme_compromisos_a' => 1]);  
  
            return redirect(url('informe-gestion'))
                    ->with("success", "Se ha finalizado el registro de compromisos");
        }
    }

}
