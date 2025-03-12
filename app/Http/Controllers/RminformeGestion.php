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

class RminformeGestion extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(12)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
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

        $igestionc  = Informegestion::whereIdActa($datosacta->id)->whereNotIn('status',['B'])->count();

        return view('documentos.informe-gestion.15-1.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'igestion', 'igestionc')
                );
    }

    public function create()
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(12)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();

        return view('documentos.informe-gestion.15-1.create', 
                compact('anexo', 'documento', 'datosacta', 'avances')
                );
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'oi'    => 'required',
            'oii'   => 'required',
            'oiii'  => 'required',
            'oiv'   => 'required',
        ],$message=[
            'oi.required'   => 'Registra las actividades y funciones',
            'oii.required'  => 'Registra resultado de los programas, proyectos, etc..',
            'oiii.required' => 'Registra principales logros alcanzados',
            'oiv.required' => 'Registra temas prioritarios, principales problemáticas, etc.. ',
        ]);

        Informegestion::create([
            'id_acta'=> $request->acta,
            'id_ct'  => Auth::user()->id_ct,
            'oi'     => $request->oi,
            'oii'    => $request->oii,
            'oiii'   => $request->oiii,
            'oiv'    => $request->oiv,
            'oanio'  => date('Y-m-d'),     
        ]);    

        return redirect(url('informe-gestion-plantilla'))
                ->with('success', 'Se guardó el registro de informe de gestión correctamente');
    }


    public function edit(string $id)
    {
        $anexo      = Anexos::whereOnumAnexo(15)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(12)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $igestfind  = Informegestion::whereIdActa($datosacta->id)->first();
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
                                END AS roiv'))
                        ->whereId($igestfind->id)->first();

        $igestionc  = Informegestion::whereIdActa($datosacta->id)->whereNotIn('status',['B'])->count();

        return view('documentos.informe-gestion.15-1.edit', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'igestion', 'igestionc')
                );

    }


    public function update(Request $request, string $id)
    {
        if($request->action=='0')
        {
            $validatedData = $request->validate([
                'oi'    => 'required',
                'oii'   => 'required',
                'oiii'  => 'required',
                'oiv'   => 'required',
            ],$message=[
                'oi.required'   => 'Registra las actividades y funciones',
                'oii.required'  => 'Registra resultado de los programas, proyectos, etc..',
                'oiii.required' => 'Registra principales logros alcanzados',
                'oiv.required' => 'Registra temas prioritarios, principales problemáticas, etc.. ',
            ]);

            $update_informe = Informegestion::find($id);
            $update_informe->oi   = $request->oi;
            $update_informe->oii  = $request->oii;
            $update_informe->oiii = $request->oiii;
            $update_informe->oiv  = $request->oiv;
            $update_informe->save();

            return redirect(url('informe-gestion-plantilla'))
                    ->with('success', 'Se ha actualizó el registro de informe de gestión');
        }else if($request->action=='1'){
            $avances_plantilla = Avanceanexos::whereIdActa($request->acta);
            $avances_plantilla->update(['oinforme_gestion_a' => 1]);  
  
            return redirect(url('informe-gestion'))
                    ->with("success", "Se ha finalizado el registro de informe de gestión");
        }

    }

}
