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
use App\Models\Plantillapersonal;
use App\Models\Plantillacomisionados;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;

class FinalizadasController extends Controller
{

    public function index()
    {   
           
            if(Auth::user()->onivel=='ELEMENTAL'){
                $us=76;
            }else if(Auth::user()->onivel=='SECUNDARIA'){
                $us=89;
            }
            

            switch (Auth::user()->ocargo) 
            {
                case 'DIRECCIÓN':
                    require_once 'controllers/entregas/finalizadas/01direccion.php';
                    return view('admin.er.finalizadas.index',
                                compact('datosacta','datosacta2','datosacta3','us')
                                );
                break;   

                case 'SUBDIRECCIÓN':
                    require_once 'controllers/entregas/finalizadas/02subdireccion.php';
                    return view('admin.er.finalizadas.index',
                                compact('datosacta','datosacta2','datosacta3','us')
                                );
                break;

                case 'DEPARTAMENTO':
                    require_once 'controllers/entregas/finalizadas/03departamento.php';
                    return view('admin.er.finalizadas.index',
                                compact('datosacta','datosacta2','datosacta3','us')
                                );
                break;

                case 'SECTOR':
                    require_once 'controllers/entregas/finalizadas/04sector.php';
                    return view('admin.er.finalizadas.index2',
                                compact('datosacta2','datosacta3','us') 
                                );
                break;

                case 'SUPERVISIÓN':
                    require_once 'controllers/entregas/finalizadas/05supervision.php';
                    return view('admin.er.finalizadas.index3',
                                compact('datosacta3','us')
                                );
                break;         
            }




    }








    public function show()
    {
            //$datosacta = DatosActa::get();
            $datosacta   = DatosActa::whereIdCtorigen(Auth::user()->id_ct)->paginate(10);

            return view('admin.er.finalizadas.show',
                    compact('datosacta')
                    );
    }







    public function edit(string $id)
    {
            if(Auth::user()->onivel=='ELEMENTAL'){
                $us=76;
            }else if(Auth::user()->onivel=='SECUNDARIA'){
                $us=89;
            }

            $documentos  = Documentos::get();
            $datosacta   = DatosActa::whereId($id)->first();
            $avanceanexos = Avanceanexos::whereIdActa($id)->get();

            if($datosacta->id_tipoacta==2)
            {
                    $anexos = Anexos::whereNotIn('onum_anexo', [14,15])->OrderBy('onum_anexo', 'ASC')->get();
            }else if($datosacta->id_tipoacta==1){

                   $anexos  = Anexos::OrderBy('onum_anexo', 'ASC')->get(); 
            }

            require_once 'controllers/entregas/finalizadas/edit/index.php';

            return view('admin.er.finalizadas.edit',
                    compact('anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'us')
                    );
    }



    

}
