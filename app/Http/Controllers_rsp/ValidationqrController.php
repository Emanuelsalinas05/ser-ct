<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

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
use App\Models\Plantillapersonal;

class ValidationqrController extends Controller
{
    public function edit(string $id)
    {
        $datosacta = DatosActa::whereId($id)->first();

        $datasct = CentrosTrabajo::whereId($datosacta->id_ct)->first();

        if($datasct->onamedir=='DIRECCIÓN DE EDUCACIÓN ELEMENTAL' && $datasct->omodalidad=='DPB'){
            $getct  = Organitation::select('idct_departamento', 'cct_departamento')
                        ->whereIdctEscuela($datosacta->id_ct)->first();
            $datasctx = CentrosTrabajo::whereKcvect($getct->idct_departamento)->first();

        }else if($datasct->onamedir=='DIRECCIÓN DE EDUCACIÓN ELEMENTAL' && $datasct->omodalidad!='DPB'){
            $getct  = Organitation::select('idct_subdireccion', 'cct_subdireccion')
                        ->whereIdctEscuela($datosacta->id_ct)->first();
            $datasctx = CentrosTrabajo::whereKcvect($getct->idct_subdireccion)->first();
        }
        

        return view('admin.validation-qr.edit',
                compact('datosacta', 'datasct', 'getct', 'datasctx',)
                );
    }
}
