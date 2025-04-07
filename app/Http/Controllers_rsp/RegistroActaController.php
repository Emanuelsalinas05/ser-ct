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
use App\Models\Otroshechos;


class RegistroActaController extends Controller
{
    public function edit(string $id)
    {
        $centrotrabajo = CentrosTrabajo::whereOstatus(1)->get();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        return view('documentos.acta-datos.edit', 
                compact('centrotrabajo', 'datosacta','avances',)
                );
    }

    public function update(Request $request, string $id)
    {   
        $ct = CentrosTrabajo::whereKcvect(Auth::user()->id_ct)->first();

        if($request->acta_tipo=='1')
        {
            $validatedData = $request->validate([
                'olugar_a'              => 'required',
                'ohora_inicio_a'        => 'required',
                'ofecha_inicio_a'       => 'required',
                'odomicilio_ct_a'       => 'required',
                'oidentificacion_entrega_a'     => 'required',
                'onumero_identificacion_entrega_a' => 'required',
                'oidentificacion_url_entrega_a' => 'required',
                'oidentificacion_recibe_a'      => 'required',
                'onumero_identificacion_recibe_a' => 'required',
                'oidentificacion_url_recibe_a'  => 'required',
                'onombre_testigo_a'     => 'required',
                'oct_testigo_a'         => 'required',
                'ocargo_testigo_a'      => 'required',
                'oidentificacion_testigo'     => 'required',
                'onumero_identificacion_testigo_a' => 'required',
                'oidentificacion_url_testigo' => 'required',
                'orfc_testigo'                => 'required',
                'onombre_testigo2_a'    => 'required',
                'oct_testigo2_a'        => 'required',
                'ocargo_testigo2_a'     => 'required',
                'oidentificacion_testigo2'     => 'required',
                'onumero_identificacion_testigo2_a' => 'required',
                'oidentificacion_url_testigo2' => 'required',
                'orfc_testigo2'                => 'required',
                'oidentificacion_testigo2'     => 'required',
                'oidentificacion_url_testigo2' => 'required',
                'orfc_testigo2'                => 'required',
                'orepresentante_a'        => 'required|in:1,2',
                'ohora_fin_a'   => 'required',
                'ofecha_fin_a'  => 'required',
            ],$message=[
                'olugar_a.required'          => 'INGRESE EL LUGAR',
                'ohora_inicio_a.required'    => 'INGRESE LA HORA',
                'ofecha_inicio_a.required'   => 'INGRESE LA FECHA',
                'odomicilio_ct_a.required'   => 'INGRESA EL DOMICILIO',
                'oidentificacion_entrega_a.required'    => 'SELECCIONA EL TIPO DE IDENTIFICACION',
                'onumero_identificacion_entrega_a.required'    => 'INGRESA EL NÚM DE IDENTIFICACION',
                'oidentificacion_url_entrega_a.required'=> 'SELECCIONA EL ARCHIVO A SUBIR',
                'oidentificacion_recibe_a.required'     => 'SELECCIONA EL TIPO DE IDENTIFICACION',
                'onumero_identificacion_recibe_a.required'    => 'INGRESA EL NÚM DE IDENTIFICACION',
                'oidentificacion_url_recibe_a.required' => 'SELECCIONA EL ARCHIVO A SUBIR',
                'onombre_testigo_a.required' => 'INGRESA EL NOMBRE DEL TESTIGO 1',
                'oct_testigo_a.required'     => 'SELECCIONA EL C.T. DEL TESTIGO 1',
                'ocargo_testigo_a.required'  => 'INGRESA EL CARGO DEL TESTIGO 1',
                'onombre_testigo2_a.required'=> 'INGRESA EL NOMBRE DEL TESTIGO 2',
                'oct_testigo2_a.required'    => 'SELECCIONA EL C.T. DEL TESTIGO 2',
                'ocargo_testigo2_a.required' => 'INGRESA EL CARGO DEL TESTIGO 1',
                'orepresentante_a.required'  => 'SELECIONA SI HAY REPRESENTANTE DE OIC O SECOGEM',
                'oidentificacion_testigo.required'      => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN PARA EL TESTIGO 1',
                'oidentificacion_url_testigo.required'  => 'SELECCIONA EL ARCHIVO DE IDENTIFICACIÍN TESTIGO 1',
                'onumero_identificacion_testigo_a.required'    => 'INGRESA EL NÚM DE IDENTIFICACION TESTIGO 1',
                'orfc_testigo.required'                 => 'INGRESA EL RFC DEL TESTIGO 1',
                'oidentificacion_testigo2.required'     => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN PARA EL TESTIGO 2',
                'onumero_identificacion_testigo2_a.required'    => 'INGRESA EL NÚM DE IDENTIFICACION TESTIGO 2',
                'oidentificacion_url_testigo2.required' => 'SELECCIONA EL ARCHIVO DE IDENTIFICACIÍN TESTIGO 2',
                'orfc_testigo2.required'                => 'INGRESA EL RFC DEL TESTIGO 2',
                'ohora_fin_a.required'      => 'INGRESE LA HORA DE FINALIZACIÓN DEL ACTA', 
                'ofecha_fin_a.required'     => 'INGRESE LA FECHA DE FINALIZACIÓN DEL ACTA',
            ]);

            $ct1= CentrosTrabajo::whereKcvect($request->oct_testigo_a)->first();
            $ct2= CentrosTrabajo::whereKcvect($request->oct_testigo2_a)->first();

            $file = $request->file('oidentificacion_url_entrega_a');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-entrega.pdf', 'public');

            $file = $request->file('oidentificacion_url_recibe_a');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-recibe.pdf', 'public');

            $file = $request->file('oidentificacion_url_testigo');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo1.pdf', 'public');

            $file = $request->file('oidentificacion_url_testigo2');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo2.pdf', 'public');

            $url = 'identifications/'.$ct->oclave.'/'.$request->idacta.'/';

            $update_acta = DatosActa::find($id);
            $update_acta->olugar_a       = strtoupper($request->olugar_a);
            $update_acta->ohora_inicio_a = $request->ohora_inicio_a;
            $update_acta->ofecha_inicio_a= $request->ofecha_inicio_a;
            $update_acta->odomicilio_ct_a= strtoupper($request->odomicilio_ct_a);
            $update_acta->oidentificacion_entrega_a    = $request->oidentificacion_entrega_a;
            $update_acta->onumero_identificacion_entrega_a    = $request->onumero_identificacion_entrega_a;
            $update_acta->oidentificacion_url_entrega_a= $url.'id-entrega.pdf';

            $update_acta->oidentificacion_recibe_a     = $request->oidentificacion_recibe_a;
            $update_acta->onumero_identificacion_recibe_a     = $request->onumero_identificacion_recibe_a;
            $update_acta->oidentificacion_url_recibe_a = $url.'id-recibe.pdf';

            $update_acta->onombre_testigo_a          = strtoupper($request->onombre_testigo_a);
            $update_acta->oct_testigo_a              = $request->oct_testigo_a;
            $update_acta->ocargo_testigo_a           = strtoupper($request->ocargo_testigo_a);
            $update_acta->orfc_testigo               = strtoupper($request->orfc_testigo);
            $update_acta->oidentificacion_testigo    = $request->oidentificacion_testigo;
            $update_acta->onumero_identificacion_testigo_a    = $request->onumero_identificacion_testigo_a;
            $update_acta->oidentificacion_url_testigo= $url.'id-testigo1.pdf';

            $update_acta->onombre_testigo2_a          = strtoupper($request->onombre_testigo2_a);
            $update_acta->oct_testigo2_a              = $request->oct_testigo2_a;
            $update_acta->ocargo_testigo2_a           = strtoupper($request->ocargo_testigo2_a);
            $update_acta->orfc_testigo2               = strtoupper($request->orfc_testigo2);
            $update_acta->oidentificacion_testigo2    = $request->oidentificacion_testigo2;
            $update_acta->onumero_identificacion_testigo2_a    = $request->onumero_identificacion_testigo2_a;
            $update_acta->oidentificacion_url_testigo2= $url.'id-testigo2.pdf';

            $update_acta->orepresentante_a  = $request->orepresentante_a;
            $update_acta->onombre_representante_contraloria_a = strtoupper($request->onombre_representante_contraloria_a);
            $update_acta->ooficio_designacion_er_a       = $request->ooficio_designacion_er_a;
            $update_acta->ofecha_ofocio_designacion_er_a = $request->ofecha_ofocio_designacion_er_a;
            $update_acta->ohechos_a = strtoupper($request->ohechos_a);
            if($request->hasFile('ourl_hechos'))
            {
                $file = $request->file('ourl_hechos');
                $file->storeAs('actas-hechos/'.$ct->oclave.'/'.$request->idacta, 'acta-hechos.pdf', 'public');
                $urlx = 'actas-hechos/'.$ct->oclave.'/'.$request->idacta.'/';
            $update_acta->ohechos     = 1;
            $update_acta->ourl_hechos = $urlx.'acta-hechos.pdf';
            }else{
            $update_acta->ohechos     = 2;   
            $update_acta->ourl_hechos = NULL;
            }
            $update_acta->ohora_fin_a   = $request->ohora_fin_a;
            $update_acta->ofecha_fin_a  = $request->ofecha_fin_a;
            $update_acta->owaitacta         = 2;
            if(Auth::user()->onivel=='SECUNDARIA')
            {
            $update_acta->ocheckactaa = 1 ;
            }
            $update_acta->oestado       = 1; 
            $update_acta->save();

            if(Auth::user()->onivel=='SECUNDARIA')
            {
                $avanceUpdate = Avanceanexos::whereIdActa($request->idavance);
                $avanceUpdate->update([ 'oestado' => 1, 'ocheckacta'=> 1,]);
            }else{
                $avanceUpdate = Avanceanexos::whereIdActa($request->idavance);
                $avanceUpdate->update([ 'oestado' => 1 ]);
            }

            

            return redirect(url('entrega-recepcion'))
                    ->with("success", "Datos registrados. Ya puedes descargar el Acta de Entrega y Recepción");
        
        }else if($request->acta_tipo=='2'){

            $validatedData = $request->validate([
                'olugar_ac'                         => 'required',
                'ohora_inicio_ac'                   => 'required',
                'ofecha_inicio_ac'                  => 'required',
                'odomicilio_ct_ac'                  => 'required',
                'otelefono_ct_ac'                   => 'required',
                'odepartamento_ac'                  => 'required',
                'oidentificacion_recibe_ac'         => 'required',
                'onumero_identificacion_recibe_ac'  => 'required',
                'oidentificacion_url_recibe_ac'     => 'required',
                'onumero_identificacion_testigo1_ac'=> 'required',
                'onombre_testigo1_ac'               => 'required',
                'orfc_testigo1_ac'                  => 'required',
                'oidentificacion_testigo1_ac'       => 'required',
                'oidentificacion_testigo1_url_ac'   => 'required',
                'onombre_testigo2_ac'               => 'required',
                'orfc_testigo2_ac'                  => 'required',
                'oidentificacion_testigo2_ac'       => 'required',
                'onumero_identificacion_testigo2_ac'=> 'required',
                'oidentificacion_testigo2_url_ac'   => 'required',
                'ohechos_ac'                        => 'required', 
                'omanifestacion_recibe_ac'          => 'required',
                'omanifiestan_representante_organo_ac'  => 'required',
                'orepresentante_ac'                 => 'required|in:1,2',
                'ohora_fin_ac'      => 'required', 
                'ofecha_fin_ac'     => 'required',
            ],$message=[
                'olugar_ac.required'                     => 'INGRESE EL LUGAR',
                'ohora_inicio_ac.required'               => 'INGRESE LA HORA DE INICIO',
                'ofecha_inicio_ac.required'              => 'INGRESE LA FECHA DE INICIO',
                'odomicilio_ct_ac.required'              => 'INGRESA EL DOMICILIO',
                'otelefono_ct_ac.required'               => 'REGISTRA EL TÉLEFONO',
                'odepartamento_ac.required'              => 'INGRESA EL NOMBRE DEL DEPARTAMENTO',
                'oidentificacion_recibe_ac.required'     => 'SELECCIONA EL TIPO DE IDENTIFICACION',
                'oidentificacion_url_recibe_ac.required' => 'SELECCIONA EL ARCHIVO A SUBIR',
                'onombre_testigo1_ac.required'           => 'INGRESA EL NOMBRE DEL PRIMER TESTIGO',
                'orfc_testigo1_ac.required'              => 'INGRESA EL RFC DEL PRIMER TESTIGO',
                'oidentificacion_testigo1_ac.required'   => 'SELECCIONA EL TIPO DE IDENTIFICACION',
                'onumero_identificacion_recibe_ac.required'=> 'INGRESA EL NÚM. DE IDENTIFICACION',
                'onumero_identificacion_testigo1_ac.required'=> 'INGRESA EL NÚM. DE IDENTIFICACION',
                'onumero_identificacion_testigo2_ac.required'=> 'INGRESA EL NÚM. DE IDENTIFICACION',
                'oidentificacion_testigo1_url_ac.required' => 'SELECCIONA EL ARCHIVO A SUBIR',
                'onombre_testigo2_ac.required'           => 'INGRESA EL NOMBRE DEL SEGUNDO TESTIGO',
                'orfc_testigo2_ac'                       => 'INGRESA EL RFC DEL SEGUNDO TESTIGO', 
                'oidentificacion_testigo2_ac.required'   => 'SELECCIONA EL TIPO DE IDENTIFICACION',
                'oidentificacion_testigo2_url_ac.required'=> 'SELECCIONA EL ARCHIVO A SUBIR',
                'ohechos_ac.required'                     => 'REGISTRE LOS HECHOS',
                'omanifestacion_recibe_ac.required'       => 'ESCRIBA SU MANIFESTACIÓN',
                'omanifiestan_representante_organo_ac.required' => 'ESCRIBA SU MANIFESTACIÓN',
                'orepresentante_ac.required'=> 'SELECCIONA SI HAY REPRESENTANTE DEL OIC' ,
                'ohora_fin_ac.required'     => 'INGRESE LA HORA DE TÉRMIMO',
                'ofecha_fin_ac.required'    =>  'INGRESE LA FECHA DE TÉRMINO',
            ]);

            $file = $request->file('oidentificacion_url_recibe_ac');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-recibe.pdf', 'public');

            $file = $request->file('oidentificacion_testigo1_url_ac');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo1.pdf', 'public');

            $file = $request->file('oidentificacion_testigo2_url_ac');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo2.pdf', 'public');

            $url = 'identifications/'.$ct->oclave.'/'.$request->idacta.'/';

            $update_acta = DatosActa::find($id);
            $update_acta->olugar_ac         = strtoupper($request->olugar_ac);
            $update_acta->ohora_inicio_ac   = $request->ohora_inicio_ac;
            $update_acta->ofecha_inicio_ac  = $request->ofecha_inicio_ac;
            $update_acta->odomicilio_ct_ac  = strtoupper($request->odomicilio_ct_ac);
            $update_acta->otelefono_ct_ac   = $request->otelefono_ct_ac;
            $update_acta->odepartamento_ac  = $request->odepartamento_ac;
            $update_acta->oidentificacion_recibe_ac     = $request->oidentificacion_recibe_ac;
            $update_acta->onumero_identificacion_recibe_ac = $request->onumero_identificacion_recibe_ac;
            $update_acta->oidentificacion_url_recibe_ac = $url.'id-recibe.pdf';

            $update_acta->orepresentante_ac = $request->orepresentante_ac;
            if($request->orepresentante_ac=='2')
            {
            $update_acta->orepresentante_contraloria_ac          = NULL;
            $update_acta->orfc_orepresentante_contraloria_ac     = NULL;
            $update_acta->oidentificacion_representante_ac       = NULL;
            $update_acta->onumero_identificacion_representante_ac= NULL;
            $update_acta->oidentificacion_representante_url_ac   = NULL;

            }else if($request->orepresentante_ac=='1'){

            $file = $request->file('oidentificacion_representante_url_ac');
            $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-representante.pdf', 'public');

            $update_acta->orepresentante_contraloria_ac          = strtoupper($request->orepresentante_contraloria_ac);
            $update_acta->orfc_orepresentante_contraloria_ac     = $request->orfc_orepresentante_contraloria_ac;
            $update_acta->oidentificacion_representante_ac       = $request->oidentificacion_representante_ac;
            $update_acta->onumero_identificacion_representante_ac= $request->onumero_identificacion_representante_ac;
            $update_acta->oidentificacion_representante_url_ac   = $url.'id-representante.pdf';
            
            }
            $update_acta->omanifiestan_representante_organo_ac = strtoupper($request->omanifiestan_representante_organo_ac);
            
            $update_acta->orepresentante_contraloria_ac = strtoupper($request->orepresentante_contraloria_ac);
            $update_acta->orfc_orepresentante_contraloria_ac  = $request->orfc_orepresentante_contraloria_ac;
            $update_acta->oidentificacion_representante_ac    = $request->oidentificacion_representante_ac;
            $update_acta->oidentificacion_representante_url_ac= $url.'id-representante.pdf';

            $update_acta->onombre_testigo1_ac           = strtoupper($request->onombre_testigo1_ac);
            $update_acta->orfc_testigo1_ac              = $request->orfc_testigo1_ac;
            $update_acta->oidentificacion_testigo1_ac   = $request->oidentificacion_testigo1_ac;
            $update_acta->onumero_identificacion_testigo1_ac   = $request->onumero_identificacion_testigo1_ac;
            $update_acta->oidentificacion_testigo1_url_ac=$url.'id-testigo1.pdf';

            $update_acta->onombre_testigo2_ac           = strtoupper($request->onombre_testigo2_ac);
            $update_acta->orfc_testigo2_ac              = $request->orfc_testigo2_ac;
            $update_acta->oidentificacion_testigo2_ac   = $request->oidentificacion_testigo2_ac;
            $update_acta->onumero_identificacion_testigo2_ac   = $request->onumero_identificacion_testigo2_ac;
            $update_acta->oidentificacion_testigo2_url_ac= $url.'id-testigo2.pdf';

            $update_acta->ohechos_ac                    = strtoupper($request->ohechos_ac);
            $update_acta->omanifestacion_recibe_ac      = strtoupper($request->omanifestacion_recibe_ac);
            
            if($request->hasFile('ourl_hechosac'))
            {
                $file = $request->file('ourl_hechosac');
                $file->storeAs('actas-hechos/'.$ct->oclave.'/'.$request->idacta, 'acta-hechos.pdf', 'public');
                $urlx = 'actas-hechos/'.$ct->oclave.'/'.$request->idacta.'/';
            $update_acta->odoc_hechos = 1;
            $update_acta->ourl_hechos = $urlx.'acta-hechos.pdf';
            }else{
            $update_acta->odoc_hechos = 0;
            $update_acta->ourl_hechos = NULL;
            }

            $update_acta->ohora_fin_ac      = $request->ohora_fin_ac;
            $update_acta->ofecha_fin_ac     = $request->ofecha_fin_ac;
            $update_acta->owaitacta         = 2;
            $update_acta->oestado     = 1; 

            if(Auth::user()->onivel=='SECUNDARIA')
            {
            $update_acta->ocheckactaa = 1 ;
            }

            $update_acta->save();


            if(Auth::user()->onivel=='SECUNDARIA')
            {
                $avanceUpdate = Avanceanexos::whereIdActa($request->idavance);
                $avanceUpdate->update([ 'oestado' => 1, 'ocheckacta'=> 1,]);
            }else{
                $avanceUpdate = Avanceanexos::whereIdActa($request->idavance);
                $avanceUpdate->update([ 'oestado' => 1 ]);
            }


            return redirect(url('entrega-recepcion'))
                    ->with("success", "Datos registrados. Ya puedes descargar el Acta Circunstanciada");
        }
    }


}
