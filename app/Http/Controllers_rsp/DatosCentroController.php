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

class DatosCentroController extends Controller
{

    public function index()
    {
        $datas_ct = CentrosTrabajo::whereKcvect(Auth::user()->id_ct)->first();
        return view('centro-trabajo.index', 
                    compact('datas_ct')
                );
    }


    public function edit(string $id)
    {
        $datas_ct = CentrosTrabajo::whereKcvect($id)->first();
        return view('centro-trabajo.edit', 
                    compact('datas_ct')
                );
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'callenumero'   => 'required',
            'colonia'       => 'required',
            'codigopostal'  => 'required',
            'telefono'      => 'required', 
        ],$message=[
            'callenumero.required'  => 'Registra la calle y número',
            'colonia.required'      => 'Ingresa la colonia (solo colonia)',
            'codigopostal.required' => 'Ingresa el Codigo Postal',
            'telefono.required'     => 'Ingresa el télefono (solo telefono principal)',
        ]);

        $update_ct = CentrosTrabajo::whereKcvect($id);
        $update_ct->update([ 
            'odomicilio'    => $request->callenumero ,
            'nombre_col'    => $request->colonia ,
            'ocodigopostal' => $request->codigopostal ,
            'otelefono'     => $request->telefono ,
        ]);
  
            return redirect()->route('centro-trabajo.index')
                    ->with("success", "Se actualizó el Centro de Trabajo correctamente"); 
    }

}
