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


/**
 * Controlador para el registro y actualización de actas de entrega-recepción
 * 
 * Maneja dos tipos de actas:
 * - Tipo 1: Acta de Entrega y Recepción (normal)
 * - Tipo 2: Acta Circunstanciada de Entrega y Recepción
 */
class RegistroActaController extends Controller
{
    /**
     * Muestra el formulario de edición de datos del acta
     * 
     * @param string $id ID del acta a editar
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $centrotrabajo = CentrosTrabajo::whereOstatus(1)->get();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
/*
                if($datosacta->id_tipoacta==1){
                }else if($datosacta->id_tipoacta==2){
                }

                $detpres = Avanceanexos::whereId($avances->id)->whereOaprobacion(0);
                $detpres->update([ 'orequisitos' => 0 ]);
                omarco_juridico_d
                orecursos_humanos_d
                oplantilla_personal_a
                oplantilla_comisionados_a
                osituacion_recursos_materiales_d
                oinventario_bienes_a
                oinventario_almacen_a
                orelacion_bienes_custodia_a
                osituacion_tics_d
                oinventario_equipo_a
                oarchivos_d
                orelacion_archivos_a
                orelacion_archivos_historico_a
                orelacion_documentos_noconvencionles_a
                ocertificados_no_adeudos_d
                ocertificados_no_adeudo_a
                oinforme_gestion_d
                oinforme_gestion_a
                oinforme_compromisos_a
                ootros_hechos_d
                ootros_hechos_a
*/

        return view('documentos.acta-datos.edit', 
                compact('centrotrabajo', 'datosacta','avances',)
                );
    }







    /**
     * Actualiza los datos del acta según su tipo
     * 
     * Valida campos obligatorios sin bloquear el guardado.
     * Preserva datos existentes y solo actualiza campos presentes en el request.
     * 
     * @param Request $request Datos del formulario
     * @param string $id ID del acta a actualizar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {   
            $ct = CentrosTrabajo::whereKcvect(Auth::user()->id_ct)->first();

                if($request->acta_tipo=='1')
                {
                        $update_acta = DatosActa::find($id);
                        
                        $camposRequeridos = [
                                'olugar_a'              => 'INGRESE EL LUGAR',
                                'ohora_inicio_a'        => 'INGRESE LA HORA',
                                'ofecha_inicio_a'       => 'INGRESE LA FECHA',
                                'odomicilio_ct_a'       => 'INGRESA EL DOMICILIO',
                                'oidentificacion_entrega_a'     => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN',
                                'onumero_identificacion_entrega_a' => 'INGRESA EL NÚMERO DE IDENTIFICACIÓN',
                                'oidentificacion_url_entrega_a' => 'SELECCIONA EL ARCHIVO A SUBIR',
                                'oidentificacion_recibe_a'      => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN',
                                'onumero_identificacion_recibe_a' => 'INGRESA EL NÚMERO DE IDENTIFICACIÓN',
                                'oidentificacion_url_recibe_a'  => 'SELECCIONA EL ARCHIVO A SUBIR',
                                'onombre_testigo_a'     => 'INGRESA EL NOMBRE DEL TESTIGO 1',
                                'oct_testigo_a'         => 'SELECCIONA EL C.T. DEL TESTIGO 1',
                                'ocargo_testigo_a'      => 'INGRESA EL CARGO DEL TESTIGO 1',
                                'oidentificacion_testigo'     => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN PARA EL TESTIGO 1',
                                'onumero_identificacion_testigo_a' => 'INGRESA EL NÚMERO DE IDENTIFICACIÓN DEL TESTIGO 1',
                                'oidentificacion_url_testigo' => 'SELECCIONA EL ARCHIVO DE IDENTIFICACIÓN TESTIGO 1',
                                'orfc_testigo'                => 'INGRESA EL RFC DEL TESTIGO 1',
                                'onombre_testigo2_a'    => 'INGRESA EL NOMBRE DEL TESTIGO 2',
                                'oct_testigo2_a'        => 'SELECCIONA EL C.T. DEL TESTIGO 2',
                                'ocargo_testigo2_a'     => 'INGRESA EL CARGO DEL TESTIGO 2',
                                'oidentificacion_testigo2'     => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN PARA EL TESTIGO 2',
                                'onumero_identificacion_testigo2_a' => 'INGRESA EL NÚMERO DE IDENTIFICACIÓN DEL TESTIGO 2',
                                'oidentificacion_url_testigo2' => 'SELECCIONA EL ARCHIVO DE IDENTIFICACIÓN TESTIGO 2',
                                'orfc_testigo2'                => 'INGRESA EL RFC DEL TESTIGO 2',
                                'orepresentante_a'        => 'SELECCIONA SI HAY REPRESENTANTE DE OIC O SECOGEM',
                                'ohora_fin_a'   => 'INGRESE LA HORA DE FINALIZACIÓN DEL ACTA',
                                'ofecha_fin_a'  => 'INGRESE LA FECHA DE FINALIZACIÓN DEL ACTA',
                        ];

                        // Validar campos y recopilar los faltantes (sin bloquear)
                        $camposFaltantes = [];
                        foreach ($camposRequeridos as $campo => $mensaje) {
                                // Para archivos, verificar si existe el archivo nuevo o si ya existe en BD
                                if (strpos($campo, 'url') !== false) {
                                        $campoBD = $campo;
                                        $archivoExiste = $request->hasFile($campo) || 
                                                       ($update_acta && !empty($update_acta->$campoBD));
                                        if (!$archivoExiste) {
                                                $camposFaltantes[] = $mensaje;
                                        }
                                } 
                                // Para representante, verificar que sea 1 o 2
                                elseif ($campo == 'orepresentante_a') {
                                        if (!$request->filled($campo) || !in_array($request->$campo, ['1', '2'])) {
                                                $camposFaltantes[] = $mensaje;
                                        } 
                                        // Si el representante es "1" (SÍ), validar campos adicionales
                                        elseif ($request->orepresentante_a == '1') {
                                                if (!$request->filled('onombre_representante_contraloria_a') && empty($update_acta->onombre_representante_contraloria_a)) {
                                                        $camposFaltantes[] = 'INGRESA EL NOMBRE DEL REPRESENTANTE';
                                                }
                                                if (!$request->filled('ooficio_designacion_er_a') && empty($update_acta->ooficio_designacion_er_a)) {
                                                        $camposFaltantes[] = 'INGRESA EL NÚMERO DE OFICIO DE DESIGNACIÓN';
                                                }
                                                if (!$request->filled('ofecha_ofocio_designacion_er_a') && empty($update_acta->ofecha_ofocio_designacion_er_a)) {
                                                        $camposFaltantes[] = 'INGRESA LA FECHA DEL OFICIO DE DESIGNACIÓN';
                                                }
                                        }
                                }
                                // Para otros campos, verificar que estén llenos (en request o en BD)
                                else {
                                        if (!$request->filled($campo) && empty($update_acta->$campo)) {
                                                $camposFaltantes[] = $mensaje;
                                        }
                                }
                        }

                        $url = 'identifications/'.$ct->oclave.'/'.$request->idacta.'/';

                        // Guardar archivos solo si están presentes (no sobrescribir si ya existen)
                        if ($request->hasFile('oidentificacion_url_entrega_a')) {
                                $file = $request->file('oidentificacion_url_entrega_a');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-entrega.pdf', 'public');
                        }

                        if ($request->hasFile('oidentificacion_url_recibe_a')) {
                                $file = $request->file('oidentificacion_url_recibe_a');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-recibe.pdf', 'public');
                        }

                        if ($request->hasFile('oidentificacion_url_testigo')) {
                                $file = $request->file('oidentificacion_url_testigo');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo1.pdf', 'public');
                        }

                        if ($request->hasFile('oidentificacion_url_testigo2')) {
                                $file = $request->file('oidentificacion_url_testigo2');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo2.pdf', 'public');
                        }

                        // Guardar solo los campos que están presentes en el request (preservar los existentes)
                        if ($request->filled('olugar_a')) {
                                $update_acta->olugar_a = mb_strtoupper($request->olugar_a, 'UTF-8');
                        }
                        if ($request->filled('ohora_inicio_a')) {
                                $update_acta->ohora_inicio_a = $request->ohora_inicio_a;
                        }
                        if ($request->filled('ofecha_inicio_a')) {
                                $update_acta->ofecha_inicio_a = $request->ofecha_inicio_a;
                        }
                        if ($request->filled('odomicilio_ct_a')) {
                                $update_acta->odomicilio_ct_a = mb_strtoupper($request->odomicilio_ct_a, 'UTF-8');
                        }
                        
                        if ($request->filled('onombre_entrega_a')) {
                                $update_acta->onombre_entrega_a = mb_strtoupper($request->onombre_entrega_a, 'UTF-8');
                        }
                        if ($request->filled('orfc_entrega_a')) {
                                $update_acta->orfc_entrega_a = $request->orfc_entrega_a;
                        }
                        if ($request->filled('ocargo_entrega_a')) {
                                $update_acta->ocargo_entrega_a = mb_strtoupper($request->ocargo_entrega_a, 'UTF-8');
                        }
                        if ($request->filled('oidentificacion_entrega_a')) {
                                $update_acta->oidentificacion_entrega_a = $request->oidentificacion_entrega_a;
                        }
                        if ($request->filled('onumero_identificacion_entrega_a')) {
                                $update_acta->onumero_identificacion_entrega_a = $request->onumero_identificacion_entrega_a;
                        }
                        if ($request->hasFile('oidentificacion_url_entrega_a')) {
                                $update_acta->oidentificacion_url_entrega_a = $url.'id-entrega.pdf';
                        }

                        if ($request->filled('onombre_recibe_a')) {
                                $update_acta->onombre_recibe_a = mb_strtoupper($request->onombre_recibe_a, 'UTF-8');
                        }
                        if ($request->filled('orfc_recibe_a')) {
                                $update_acta->orfc_recibe_a = $request->orfc_recibe_a;
                        }
                        if ($request->filled('oidentificacion_recibe_a')) {
                                $update_acta->oidentificacion_recibe_a = $request->oidentificacion_recibe_a;
                        }
                        if ($request->filled('onumero_identificacion_recibe_a')) {
                                $update_acta->onumero_identificacion_recibe_a = $request->onumero_identificacion_recibe_a;
                        }
                        if ($request->hasFile('oidentificacion_url_recibe_a')) {
                                $update_acta->oidentificacion_url_recibe_a = $url.'id-recibe.pdf';
                        }

                        if ($request->filled('onombre_testigo_a')) {
                                $update_acta->onombre_testigo_a = mb_strtoupper($request->onombre_testigo_a, 'UTF-8');
                        }
                        if ($request->filled('oct_testigo_a')) {
                                $update_acta->oct_testigo_a = $request->oct_testigo_a;
                        }
                        if ($request->filled('ocargo_testigo_a')) {
                                $update_acta->ocargo_testigo_a = mb_strtoupper($request->ocargo_testigo_a, 'UTF-8');
                        }
                        if ($request->filled('orfc_testigo')) {
                                $update_acta->orfc_testigo = mb_strtoupper($request->orfc_testigo, 'UTF-8');
                        }
                        if ($request->filled('oidentificacion_testigo')) {
                                $update_acta->oidentificacion_testigo = $request->oidentificacion_testigo;
                        }
                        if ($request->filled('onumero_identificacion_testigo_a')) {
                                $update_acta->onumero_identificacion_testigo_a = $request->onumero_identificacion_testigo_a;
                        }
                        if ($request->hasFile('oidentificacion_url_testigo')) {
                                $update_acta->oidentificacion_url_testigo = $url.'id-testigo1.pdf';
                        }

                        if ($request->filled('onombre_testigo2_a')) {
                                $update_acta->onombre_testigo2_a = mb_strtoupper($request->onombre_testigo2_a, 'UTF-8');
                        }
                        if ($request->filled('oct_testigo2_a')) {
                                $update_acta->oct_testigo2_a = $request->oct_testigo2_a;
                        }
                        if ($request->filled('ocargo_testigo2_a')) {
                                $update_acta->ocargo_testigo2_a = mb_strtoupper($request->ocargo_testigo2_a, 'UTF-8');
                        }
                        if ($request->filled('orfc_testigo2')) {
                                $update_acta->orfc_testigo2 = mb_strtoupper($request->orfc_testigo2, 'UTF-8');
                        }
                        if ($request->filled('oidentificacion_testigo2')) {
                                $update_acta->oidentificacion_testigo2 = $request->oidentificacion_testigo2;
                        }
                        if ($request->filled('onumero_identificacion_testigo2_a')) {
                                $update_acta->onumero_identificacion_testigo2_a = $request->onumero_identificacion_testigo2_a;
                        }
                        if ($request->hasFile('oidentificacion_url_testigo2')) {
                                $update_acta->oidentificacion_url_testigo2 = $url.'id-testigo2.pdf';
                        }

                        if ($request->filled('orepresentante_a')) {
                                $update_acta->orepresentante_a = $request->orepresentante_a;
                        }
                        if ($request->filled('onombre_representante_contraloria_a')) {
                                $update_acta->onombre_representante_contraloria_a = mb_strtoupper($request->onombre_representante_contraloria_a, 'UTF-8');
                        }
                        if ($request->filled('ooficio_designacion_er_a')) {
                                $update_acta->ooficio_designacion_er_a = $request->ooficio_designacion_er_a;
                        }
                        if ($request->filled('ofecha_ofocio_designacion_er_a')) {
                                $update_acta->ofecha_ofocio_designacion_er_a = $request->ofecha_ofocio_designacion_er_a;
                        }
                        if ($request->filled('ohechos_a')) {
                                $update_acta->ohechos_a = mb_strtoupper($request->ohechos_a, 'UTF-8');
                        }

                        if($request->hasFile('ourl_hechos'))
                        {
                                $file = $request->file('ourl_hechos');
                                $file->storeAs('actas-hechos/'.$ct->oclave.'/'.$request->idacta, 'acta-hechos.pdf', 'public');
                                $urlx = 'actas-hechos/'.$ct->oclave.'/'.$request->idacta.'/';
                                $update_acta->ohechos     = 1;
                                $update_acta->ourl_hechos = $urlx.'acta-hechos.pdf';
                        }else{
                                // Solo cambiar ohechos si no hay archivo y no hay texto
                                if (!$request->filled('ohechos_a') && empty($update_acta->ohechos_a)) {
                                        $update_acta->ohechos = 2;
                                }
                                // No borrar ourl_hechos si ya existe
                        }
                        
                        if ($request->filled('ohora_fin_a')) {
                                $update_acta->ohora_fin_a = $request->ohora_fin_a;
                        }
                        if ($request->filled('ofecha_fin_a')) {
                                $update_acta->ofecha_fin_a = $request->ofecha_fin_a;
                        }
                        
                        $update_acta->owaitacta = 2;
                        if(Auth::user()->onivel=='SECUNDARIA')
                        {
                                $update_acta->ocheckactaa = 1 ;
                        }
                        $update_acta->oestado = 1; 
                        $update_acta->save();


                        if(Auth::user()->onivel=='SECUNDARIA')
                        {
                                $avanceUpdate = Avanceanexos::whereIdActa($request->idavance);
                                $avanceUpdate->update([ 'oestado' => 1, 'ocheckacta'=> 1,]);
                        }else{
                                $avanceUpdate = Avanceanexos::whereIdActa($request->idavance);
                                $avanceUpdate->update([ 'oestado' => 1 ]);
                        }

                        if (count($camposFaltantes) > 0) {
                                $mensaje = "Datos guardados parcialmente.\n\nFaltan los siguientes campos por completar:\n\n";
                                foreach ($camposFaltantes as $index => $campo) {
                                        $mensaje .= ($index + 1) . ". " . $campo . "\n";
                                }
                                return redirect()->route('datos-acta.edit', $id)
                                        ->withInput()
                                        ->with("warning", $mensaje);
                        } else {
                                return redirect(url('entrega-recepcion'))
                                        ->with("success", "Datos registrados correctamente. Ya puedes descargar el Acta de Entrega y Recepción");
                        }
        
                }else if($request->acta_tipo=='2'){

                        $update_acta = DatosActa::find($id);
                        
                        $camposRequeridos = [
                                'olugar_ac'                         => 'INGRESE EL LUGAR',
                                'ohora_inicio_ac'                   => 'INGRESE LA HORA DE INICIO',
                                'ofecha_inicio_ac'                  => 'INGRESE LA FECHA DE INICIO',
                                'odomicilio_ct_ac'                  => 'INGRESA EL DOMICILIO',
                                'otelefono_ct_ac'                   => 'REGISTRA EL TELÉFONO',
                                'odepartamento_ac'                  => 'INGRESA EL NOMBRE DEL DEPARTAMENTO',
                                'oidentificacion_recibe_ac'         => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN',
                                'onumero_identificacion_recibe_ac'  => 'INGRESA EL NÚMERO DE IDENTIFICACIÓN',
                                'oidentificacion_url_recibe_ac'     => 'SELECCIONA EL ARCHIVO A SUBIR',
                                'onumero_identificacion_testigo1_ac'=> 'INGRESA EL NÚMERO DE IDENTIFICACIÓN DEL TESTIGO 1',
                                'onombre_testigo1_ac'               => 'INGRESA EL NOMBRE DEL PRIMER TESTIGO',
                                'orfc_testigo1_ac'                  => 'INGRESA EL RFC DEL PRIMER TESTIGO',
                                'oidentificacion_testigo1_ac'       => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN',
                                'oidentificacion_testigo1_url_ac'   => 'SELECCIONA EL ARCHIVO A SUBIR',
                                'onombre_testigo2_ac'               => 'INGRESA EL NOMBRE DEL SEGUNDO TESTIGO',
                                'orfc_testigo2_ac'                  => 'INGRESA EL RFC DEL SEGUNDO TESTIGO',
                                'oidentificacion_testigo2_ac'       => 'SELECCIONA EL TIPO DE IDENTIFICACIÓN',
                                'onumero_identificacion_testigo2_ac'=> 'INGRESA EL NÚMERO DE IDENTIFICACIÓN DEL TESTIGO 2',
                                'oidentificacion_testigo2_url_ac'   => 'SELECCIONA EL ARCHIVO A SUBIR',
                                'ohechos_ac'                        => 'REGISTRE LOS HECHOS',
                                'omanifestacion_recibe_ac'          => 'ESCRIBA SU MANIFESTACIÓN',
                                'omanifiestan_representante_organo_ac'  => 'ESCRIBA SU MANIFESTACIÓN',
                                'orepresentante_ac'                 => 'SELECCIONA SI HAY REPRESENTANTE DEL OIC',
                                'ohora_fin_ac'                      => 'INGRESE LA HORA DE TERMINO',
                                'ofecha_fin_ac'                     => 'INGRESE LA FECHA DE TERMINO',
                        ];

                        $camposFaltantes = [];
                        $erroresValidacion = [];
                        
                        foreach ($camposRequeridos as $campo => $mensaje) {
                                if (strpos($campo, 'url') !== false) {
                                        $campoBD = $campo;
                                        $archivoExiste = $request->hasFile($campo) || 
                                                       ($update_acta && !empty($update_acta->$campoBD));
                                        if (!$archivoExiste) {
                                                $camposFaltantes[] = $mensaje;
                                                $erroresValidacion[$campo] = $mensaje;
                                        }
                                } 
                                elseif ($campo == 'orepresentante_ac') {
                                        if (!$request->filled($campo) || !in_array($request->$campo, ['1', '2'])) {
                                                $camposFaltantes[] = $mensaje;
                                                $erroresValidacion[$campo] = $mensaje;
                                        } 
                                        elseif ($request->orepresentante_ac == '1') {
                                                if (!$request->filled('orepresentante_contraloria_ac') && empty($update_acta->orepresentante_contraloria_ac)) {
                                                        $camposFaltantes[] = 'INGRESA EL NOMBRE DEL REPRESENTANTE';
                                                        $erroresValidacion['orepresentante_contraloria_ac'] = 'INGRESA EL NOMBRE DEL REPRESENTANTE';
                                                }
                                                if (!$request->filled('orfc_orepresentante_contraloria_ac') && empty($update_acta->orfc_orepresentante_contraloria_ac)) {
                                                        $camposFaltantes[] = 'INGRESA EL RFC DEL REPRESENTANTE';
                                                        $erroresValidacion['orfc_orepresentante_contraloria_ac'] = 'INGRESA EL RFC DEL REPRESENTANTE';
                                                }
                                                if (!$request->filled('oidentificacion_representante_ac') && empty($update_acta->oidentificacion_representante_ac)) {
                                                        $camposFaltantes[] = 'SELECCIONA EL TIPO DE IDENTIFICACIÓN DEL REPRESENTANTE';
                                                        $erroresValidacion['oidentificacion_representante_ac'] = 'SELECCIONA EL TIPO DE IDENTIFICACIÓN DEL REPRESENTANTE';
                                                }
                                                if (!$request->filled('onumero_identificacion_representante_ac') && empty($update_acta->onumero_identificacion_representante_ac)) {
                                                        $camposFaltantes[] = 'INGRESA EL NÚMERO DE IDENTIFICACIÓN DEL REPRESENTANTE';
                                                        $erroresValidacion['onumero_identificacion_representante_ac'] = 'INGRESA EL NÚMERO DE IDENTIFICACIÓN DEL REPRESENTANTE';
                                                }
                                                $archivoRepExiste = $request->hasFile('oidentificacion_representante_url_ac') || 
                                                                   ($update_acta && !empty($update_acta->oidentificacion_representante_url_ac));
                                                if (!$archivoRepExiste) {
                                                        $camposFaltantes[] = 'SELECCIONA EL ARCHIVO DE IDENTIFICACIÓN DEL REPRESENTANTE';
                                                        $erroresValidacion['oidentificacion_representante_url_ac'] = 'SELECCIONA EL ARCHIVO DE IDENTIFICACIÓN DEL REPRESENTANTE';
                                                }
                                        }
                                }
                                else {
                                        if (!$request->filled($campo) && empty($update_acta->$campo)) {
                                                $camposFaltantes[] = $mensaje;
                                                $erroresValidacion[$campo] = $mensaje;
                                        }
                                }
                        }

                        $url = 'identifications/'.$ct->oclave.'/'.$request->idacta.'/';

                        if ($request->hasFile('oidentificacion_url_recibe_ac')) {
                                $file = $request->file('oidentificacion_url_recibe_ac');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-recibe.pdf', 'public');
                        }

                        if ($request->hasFile('oidentificacion_testigo1_url_ac')) {
                                $file = $request->file('oidentificacion_testigo1_url_ac');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo1.pdf', 'public');
                        }

                        if ($request->hasFile('oidentificacion_testigo2_url_ac')) {
                                $file = $request->file('oidentificacion_testigo2_url_ac');
                                $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-testigo2.pdf', 'public');
                        }

                        if ($request->filled('olugar_ac')) {
                                $update_acta->olugar_ac = mb_strtoupper($request->olugar_ac, 'UTF-8');
                        }
                        if ($request->filled('ohora_inicio_ac')) {
                                $update_acta->ohora_inicio_ac = $request->ohora_inicio_ac;
                        }
                        if ($request->filled('ofecha_inicio_ac')) {
                                $update_acta->ofecha_inicio_ac = $request->ofecha_inicio_ac;
                        }
                        if ($request->filled('odomicilio_ct_ac')) {
                                $update_acta->odomicilio_ct_ac = mb_strtoupper($request->odomicilio_ct_ac, 'UTF-8');
                        }
                        if ($request->filled('otelefono_ct_ac')) {
                                $update_acta->otelefono_ct_ac = $request->otelefono_ct_ac;
                        }
                        if ($request->filled('odepartamento_ac')) {
                                $update_acta->odepartamento_ac = $request->odepartamento_ac;
                        }
                        if ($request->filled('oidentificacion_recibe_ac')) {
                                $update_acta->oidentificacion_recibe_ac = $request->oidentificacion_recibe_ac;
                        }
                        if ($request->filled('onumero_identificacion_recibe_ac')) {
                                $update_acta->onumero_identificacion_recibe_ac = $request->onumero_identificacion_recibe_ac;
                        }
                        if ($request->hasFile('oidentificacion_url_recibe_ac')) {
                                $update_acta->oidentificacion_url_recibe_ac = $url.'id-recibe.pdf';
                        }
                        if ($request->filled('orepresentante_ac')) {
                                $update_acta->orepresentante_ac = $request->orepresentante_ac;
                        }

                        if($request->filled('orepresentante_ac') && $request->orepresentante_ac=='2')
                        {
                                $update_acta->orepresentante_contraloria_ac          = NULL;
                                $update_acta->orfc_orepresentante_contraloria_ac     = NULL;
                                $update_acta->oidentificacion_representante_ac       = NULL;
                                $update_acta->onumero_identificacion_representante_ac= NULL;
                                $update_acta->oidentificacion_representante_url_ac   = NULL;
                        }else if($request->filled('orepresentante_ac') && $request->orepresentante_ac=='1'){

                                if ($request->hasFile('oidentificacion_representante_url_ac')) {
                                        $file = $request->file('oidentificacion_representante_url_ac');
                                        $file->storeAs('identifications/'.$ct->oclave.'/'.$request->idacta, 'id-representante.pdf', 'public');
                                }

                                if ($request->filled('orepresentante_contraloria_ac')) {
                                        $update_acta->orepresentante_contraloria_ac = mb_strtoupper($request->orepresentante_contraloria_ac, 'UTF-8');
                                }
                                if ($request->filled('orfc_orepresentante_contraloria_ac')) {
                                        $update_acta->orfc_orepresentante_contraloria_ac = $request->orfc_orepresentante_contraloria_ac;
                                }
                                if ($request->filled('oidentificacion_representante_ac')) {
                                        $update_acta->oidentificacion_representante_ac = $request->oidentificacion_representante_ac;
                                }
                                if ($request->filled('onumero_identificacion_representante_ac')) {
                                        $update_acta->onumero_identificacion_representante_ac = $request->onumero_identificacion_representante_ac;
                                }
                                if ($request->hasFile('oidentificacion_representante_url_ac')) {
                                        $update_acta->oidentificacion_representante_url_ac = $url.'id-representante.pdf';
                                }
                        }

                        if ($request->filled('omanifiestan_representante_organo_ac')) {
                                $update_acta->omanifiestan_representante_organo_ac = mb_strtoupper($request->omanifiestan_representante_organo_ac, 'UTF-8');
                        }

                        if ($request->filled('onombre_testigo1_ac')) {
                                $update_acta->onombre_testigo1_ac = mb_strtoupper($request->onombre_testigo1_ac, 'UTF-8');
                        }
                        if ($request->filled('orfc_testigo1_ac')) {
                                $update_acta->orfc_testigo1_ac = $request->orfc_testigo1_ac;
                        }
                        if ($request->filled('oidentificacion_testigo1_ac')) {
                                $update_acta->oidentificacion_testigo1_ac = $request->oidentificacion_testigo1_ac;
                        }
                        if ($request->filled('onumero_identificacion_testigo1_ac')) {
                                $update_acta->onumero_identificacion_testigo1_ac = $request->onumero_identificacion_testigo1_ac;
                        }
                        if ($request->hasFile('oidentificacion_testigo1_url_ac')) {
                                $update_acta->oidentificacion_testigo1_url_ac = $url.'id-testigo1.pdf';
                        }

                        if ($request->filled('onombre_testigo2_ac')) {
                                $update_acta->onombre_testigo2_ac = mb_strtoupper($request->onombre_testigo2_ac, 'UTF-8');
                        }
                        if ($request->filled('orfc_testigo2_ac')) {
                                $update_acta->orfc_testigo2_ac = $request->orfc_testigo2_ac;
                        }
                        if ($request->filled('oidentificacion_testigo2_ac')) {
                                $update_acta->oidentificacion_testigo2_ac = $request->oidentificacion_testigo2_ac;
                        }
                        if ($request->filled('onumero_identificacion_testigo2_ac')) {
                                $update_acta->onumero_identificacion_testigo2_ac = $request->onumero_identificacion_testigo2_ac;
                        }
                        if ($request->hasFile('oidentificacion_testigo2_url_ac')) {
                                $update_acta->oidentificacion_testigo2_url_ac = $url.'id-testigo2.pdf';
                        }

                        if ($request->filled('ohechos_ac')) {
                                $update_acta->ohechos_ac = mb_strtoupper($request->ohechos_ac, 'UTF-8');
                        }
                        if ($request->filled('omanifestacion_recibe_ac')) {
                                $update_acta->omanifestacion_recibe_ac = mb_strtoupper($request->omanifestacion_recibe_ac, 'UTF-8');
                        }
                        
                        if($request->hasFile('ourl_hechosac'))
                        {
                                $file = $request->file('ourl_hechosac');
                                $file->storeAs('actas-hechos/'.$ct->oclave.'/'.$request->idacta, 'acta-hechos.pdf', 'public');
                                $urlx = 'actas-hechos/'.$ct->oclave.'/'.$request->idacta.'/';
                                $update_acta->odoc_hechos = 1;
                                $update_acta->ourl_hechos = $urlx.'acta-hechos.pdf';
                        }else{
                                // Solo cambiar odoc_hechos si no hay archivo y no hay texto
                                if (!$request->filled('ohechos_ac') && empty($update_acta->ohechos_ac)) {
                                        $update_acta->odoc_hechos = 0;
                                }
                                // No borrar ourl_hechos si ya existe
                        }

                        if ($request->filled('ohora_fin_ac')) {
                                $update_acta->ohora_fin_ac = $request->ohora_fin_ac;
                        }
                        if ($request->filled('ofecha_fin_ac')) {
                                $update_acta->ofecha_fin_ac = $request->ofecha_fin_ac;
                        }
                        
                        $update_acta->owaitacta = 2;
                        $update_acta->oestado = 1; 

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

                        // Construir mensaje de respuesta
                        if (count($camposFaltantes) > 0) {
                                $mensaje = "Datos guardados parcialmente.\n\nFaltan los siguientes campos por completar:\n\n";
                                foreach ($camposFaltantes as $index => $campo) {
                                        $mensaje .= ($index + 1) . ". " . $campo . "\n";
                                }
                                return redirect()->route('datos-acta.edit', $id)
                                        ->withInput()
                                        ->withErrors($erroresValidacion)
                                        ->with("warning", $mensaje);
                        } else {
                                return redirect(url('entrega-recepcion'))
                                        ->with("success", "Datos registrados correctamente. Ya puedes descargar el Acta Circunstanciada");
                        }
                }
    }


}
