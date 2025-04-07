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
use App\Models\Plantillacomisionados;
use App\Models\Inventariobienes;
use App\Models\Inventarioalmacen;
use App\Models\Relacioncustodias;
use App\Models\Inventariocomputo;
use App\Models\Archivostramite;
use App\Models\Archivoshistorico;
use App\Models\Documentoshemerograficos;
use App\Models\Certificadosnoadeudo;
use App\Models\Informegestion;
use App\Models\Compromisos90dias;
use App\Models\Otroshechos;


class ReviewAvanceacta extends Controller
{
    public function index(){}

    public function marcjuridico($id)
    {
        $anexo      = Anexos::whereOnumAnexo(1)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->first();
        $datosacta  = DatosActa::whereId($id)->first();                // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();             // F
        $juridicos  = Ordenamientojuridico::whereIdCt($datosacta->id_ct)->OrderBy('id', 'ASC')->get();

        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'datosacta', 'avance', 'juridicos', ));
    }

    public function rhumanos($id)
    {
        $anexo          = Anexos::whereOnumAnexo(5)->first();
        $documentos     = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta      = DatosActa::whereId($id)->first();                             // F
        $avance         = Avanceanexos::whereIdActa($datosacta->id)->first();           // F
        $plantillap     = Plantillapersonal::whereIdActa($datosacta->id)->get();          
        $plantillac     = Plantillacomisionados::whereIdActa($datosacta->id)->get();               

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();

        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'plantillap', 'plantillac', ));
    }

    public function rmateriales($id)
    {
        $anexo      = Anexos::whereOnumAnexo(8)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta  = DatosActa::whereId($id)->first();                                 // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();               // F
        $ibienes    = Inventariobienes::whereIdActa($datosacta->id)->get();           
        $ialmacen   = Inventarioalmacen::whereIdActa($datosacta->id)->get();          

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();
        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'ibienes', 'ialmacen', ));
    }

    public function situaciontics($id)
    {
        $anexo      = Anexos::whereOnumAnexo(9)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta  = DatosActa::whereId($id)->first();                                 // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();               // F
        $icomputo      = Inventariocomputo::whereIdActa($datosacta->id)->get();          

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();
        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'icomputo', ));
    }

    public function carchivos($id)
    {
        $anexo      = Anexos::whereOnumAnexo(13)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta  = DatosActa::whereId($id)->first();                                 // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();               // F
        $iarchivos  = Archivostramite::whereIdActa($datosacta->id)->get();            
        $iarchivosh = Archivoshistorico::whereIdActa($datosacta->id)->get();     
        $iheme      = Documentoshemerograficos::whereIdActa($datosacta->id)->get();      

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();
        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'iarchivos', 'iarchivosh', 'iheme', ));
    }

    public function cernoadeudos($id)
    {
        $anexo      = Anexos::whereOnumAnexo(14)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta  = DatosActa::whereId($id)->first();                                 // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();               // F
        $inoadeudo  = Certificadosnoadeudo::whereIdActa($datosacta->id)->get();     

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();
        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'inoadeudo', ));
    }

    public function infogestion($id)
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta  = DatosActa::whereId($id)->first();                                 // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();               // F
        $igestion   = Informegestion::select('id', 'oi','oii','oiii','oiv',
                        DB::raw('CASE
                                WHEN 
                                    oi IS NOT NULL
                                THEN 
                                    "I. ACTIVIDADES Y FUNCIONES (DESCRIPCIÓN DE LAS ACTIVIDADES Y TEMAS ENCOMENDADOS A LA PERSONA SERVIDORA PÚBLICA, QUE FUERON ATENDIDOS DURANTE SU GESTIÓN, RELACIONADOS CON LAS FACULTADES O FUNCIONES QUE LE CORRESPONDAN):"
                                END AS roi'),
                        DB::raw('CASE
                                WHEN 
                                    oii IS NOT NULL
                                THEN 
                                    "II. RESULTADO DE LOS PROGRAMAS, PROYECTOS, ESTRATEGIAS Y ASPECTOS RELEVANTES O PRIORITARIOS (EN ESTE APARTADO SE DEBERÁ SEÑALAR EL GRADO DE CUMPLIMIENTO CUANTITATIVO, CON LA JUSTIFICACIÓN CORRESPONDIENTE QUE EXPLIQUE EL NIVEL ALCANZADO Y LAS RAZONES DE AQUELLO QUE QUEDÓ PENDIENTE DE ALCANZAR SOBRE LOS OBJETIVOS, METAS, POLÍTICAS, PROGRAMAS, PROYECTOS, ESTRATEGIAS Y ASPECTOS RELEVANTES O PRIORITARIOS QUE CORRESPONDAN AL ÁREA O FUNCIONES DE LA PERSONA QUE ENTREGA):"
                                END AS roii'),
                        DB::raw('CASE
                                WHEN 
                                    oiii IS NOT NULL
                                THEN 
                                    "III. PRINCIPALES LOGROS ALCANZADOS (SE DEBERÁ SEÑALAR LOS PRINCIPALES LOGROS ALCANZADOS Y SUS IMPACTOS, IDENTIFICANDO LOS PROGRAMAS, PROYECTOS O ACCIONES QUE SE CONSIDEREN DEBAN TENER CONTINUIDAD CON LA JUSTIFICACIÓN CORRESPONDIENTE, ASÍ COMO INDICAR LAS RECOMENDACIONES O PROPUESTAS DE POLÍTICAS Y ESTRATEGIAS QUE CONTRIBUYAN A SU SEGUIMIENTO):"
                                END AS roiii'),
                        DB::raw('CASE
                                WHEN 
                                    oiv IS NOT NULL
                                THEN 
                                    "IV. TEMAS PRIORITARIOS, PRINCIPALES PROBLEMÁTICAS Y ESTADO QUE GUARDAN LOS ASUNTOS (SE DEBERÁ IDENTIFICAR LAS PRINCIPALES PROBLEMÁTICAS Y TEMAS PRIORITARIOS, SEÑALANDO EL GRADO DE ATENCIÓN DE LOS MISMOS, LOS PLAZOS O FECHAS DE VENCIMIENTO, EL PRESUPUESTO AUTORIZADO, LA ÚLTIMA ACTIVIDAD REALIZADA SOBRE LOS MISMOS, INDICANDO LA FECHA Y LAS RECOMENDACIONES A SEGUIR. SE DEBERÁ REPORTAR EL ESTADO DE LOS ASUNTOS A CARGO SEÑALANDO LOS QUE SE ENCUENTRAN CONCLUIDOS, EN PROCESO Y AQUELLOS QUE OCURREN CON CIERTA PERIODICIDAD, ASÍ COMO LOS QUE REQUIEREN DE ATENCIÓN ESPECIAL E INMEDIATA EN EL MOMENTO DE LA ENTREGA):"
                                END AS roiv'))->whereIdActa($datosacta->id)
                        ->whereNotIn('status',['B'])->first();
        $icompromisos     = Compromisos90dias::whereIdActa($datosacta->id)->get();     

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();
        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'igestion', 'icompromisos', ));
    }

    public function otrosh($id)
    {
        $anexo      = Anexos::whereOnumAnexo(18)->first();
        $documentos = Documentos::whereIdAnexo($anexo->id)->get();
        $datosacta  = DatosActa::whereId($id)->first();                                 // F
        $avance     = Avanceanexos::whereIdActa($datosacta->id)->first();               // F
        $iotroshechos = Otroshechos::whereIdActa($datosacta->id)->get();     

        $juridicos  = Ordenamientojuridico::whereIdCt(Auth::user()->id_ct)->OrderBy('id', 'ASC')->get();
        return view('admin.er.acta-content.anexos.index', 
                compact('anexo', 'documentos', 'juridicos', 'datosacta', 'avance', 'iotroshechos', ));
    }
}
