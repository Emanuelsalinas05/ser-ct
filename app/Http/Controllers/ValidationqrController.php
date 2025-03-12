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
        $datosacta = DatosActa::select('g1acta.*',
                    DB::raw('g1centros_trabajo.onombre_ct AS dir'),
                    DB::raw('CASE 
                                WHEN g1acta.id_dep > 0 THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect = g1acta.id_dep ) 
                                WHEN g1acta.id_dep = 0 THEN (SELECT CONCAT(oclave," - ",onombre_ct) FROM g1centros_trabajo WHERE kcvect = g1acta.id_sub ) 
                            END AS nivelx'))
                    ->leftJoin('g1centros_trabajo', 'g1centros_trabajo.kcvect', 'g1acta.id_dir')
                    ->where('g1acta.id',$id)->first();


        return view('admin.validation-qr.edit',
                compact('datosacta',)
                );
    }
}
