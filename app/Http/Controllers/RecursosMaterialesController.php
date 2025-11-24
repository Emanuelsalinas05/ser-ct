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

class RecursosMaterialesController extends Controller
{

    public function index()
    {
        $anexo        = Anexos::whereOnumAnexo(8)->first();
        $documentos   = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta    = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        
        // Validar existencia de acta activa
        if (!$datosacta) {
            return redirect()->route('entrega-recepcion.index')
                ->with('warning', 'No tienes un acta de entrega-recepción activa. Por favor, crea una nueva acta primero.');
        }
        
        $avanceanexos = Avanceanexos::whereIdActa($datosacta->id)->get();

        return view('documentos.situacion-recursos-materiales.index', 
                compact('anexo', 'documentos', 'datosacta', 'avanceanexos')
                );
    }

    public function create(){   }

    public function store(Request $request){    }

    public function show(string $id){   }

    public function edit(string $id){   }

    public function update(Request $request, string $id){   }

    public function destroy(string $id){    }

}
