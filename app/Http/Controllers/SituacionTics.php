<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
use App\Models\Inventariocomputo;

class SituacionTics extends Controller
{


    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(9)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(7)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances     = Avanceanexos::whereIdActa($datosacta->id)->first();
        $icomputo   = Inventariocomputo::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->get();
        $icomputoc  = Inventariocomputo::whereIdActa($datosacta->id)->whereNotIn('status', ['B'])->count();

        return view('documentos.situacion-tics.9-1.index',
            compact('anexo', 'documento', 'datosacta', 'avances', 'icomputo', 'icomputoc')
        );
    }

    public function store(Request $request)
    {
        $user           = User::whereId(Auth::user()->id)->first();
        $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
        $elct           = $centrotrabajo->oclave;
        $iddoc          = $request->iddoc;
        $idacta         = $request->idacta;
        $nombredoc      = str_replace(' ', '',$request->onombre_documento);
        $file           = $request->file('onombre_archivo');

        if($request->actiontic=='1')
        {
            if($request->hasFile('onombre_archivo'))
            {
                $file->storeAs('inventario-equipo/9-1/'.$elct, $nombredoc.'.'.$file->extension(), 'public');
                Inventariocomputo::create([
                    'id_acta'           => $idacta,
                    'id_ct'             => Auth::user()->id_ct,
                    'onombre_documento' => $nombredoc,
                    'ourl'              => 'inventario-equipo/9-1/'.$elct.'/',
                    'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                    'oanio'             => date('Y-m-d'),
                    'ofile'             => 1,
                ]);
                return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");
            }else{
                return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
            }

        }else if($request->actiontic=='9'){

            $update_almacen = Inventariocomputo::whereIdActa($idacta)->whereOfile(1);
            $update_almacen->update([ 'status' => 'B' ]);

            Inventariocomputo::create([
                'id_acta'           => $idacta,
                'id_ct'             => Auth::user()->id_ct,
                'onombre_documento' => 'N/A',
                'ourl'              => 'N/A',
                'oarchivo_adjunto'  => 'N/A',
                'oanio'             => date('Y-m-d'),
            ]);

            return redirect()->back()->with("success", "Se ha registrado correctamente la información");
        }

    }


    public function update(Request $request, string $id)
    {
        if($request->actionplantilla==1)
        {
            $almacen = Inventariocomputo::whereId($id)->first();
            $update_almacen = Inventariocomputo::whereId($id);
            $update_almacen->update([ 'status' => 'B' ]);
            unlink(storage_path('app/public/'.$almacen->ourl.$almacen->oarchivo_adjunto));

            return redirect()->back()->with("success", "Se ha removido el archivo correctamente");

        }else if($request->actionplantilla==2){

            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update([ 'oinventario_equipo_a' => 1 ,
                'oopenanexo' => 1,
            ]);

            return redirect()->route('documentos.situacion-tics.index')
                ->with("success", "Se ha finalizado inventario de equipo de cómputo y comunicaciones.");
        }
    }
    public function edit($id)
    {
        $inventario = Inventariocomputo::findOrFail($id);
        return view('documentos.situacion-tics.9-1.edit', compact('inventario'));
    }
    public function actualizar(Request $request, $id)
    {
        $inventario = Inventariocomputo::findOrFail($id);

        // Validar nombre
        $request->validate([
            'onombre_documento' => 'required|string|max:255',
            'onombre_archivo' => 'nullable|file|max:10240' // máximo 10MB
        ]);

        // Actualiza nombre del documento
        $inventario->onombre_documento = str_replace(' ', '', $request->onombre_documento);

        // Si hay nuevo archivo, lo guarda y reemplaza
        if ($request->hasFile('onombre_archivo')) {
            // Elimina el archivo anterior si existe
            Storage::disk('public')->delete($inventario->ourl . $inventario->oarchivo_adjunto);

            $archivo = $request->file('onombre_archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();

            // Guarda nuevo archivo
            $archivo->storeAs($inventario->ourl, $nombreArchivo, 'public');

            // Actualiza nombre del archivo en DB
            $inventario->oarchivo_adjunto = $nombreArchivo;
        }

        $inventario->save();

        return redirect()->route('documentos.situacion-tics.index')
            ->with('success', 'Documento actualizado correctamente.');
    }


}
