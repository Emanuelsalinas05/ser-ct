<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosActa;
use App\Models\Intervencion;
use App\Models\Solicitudnoadeudo;
use Carbon\Carbon;

class ReportesMensualesController extends Controller
{


    public function reporteActos(Request $request)
{
    $fecha = $request->input('fecha_actos');

    if (!$fecha || !preg_match('/^\d{2}-\d{4}$/', $fecha)) {
        return back()->with('warning', 'La fecha seleccionada no es válida.');
    }

    $inicio = \Carbon\Carbon::createFromFormat('m-Y', $fecha)->startOfMonth()->toDateString();
    $fin    = \Carbon\Carbon::createFromFormat('m-Y', $fecha)->endOfMonth()->toDateString();

    $actas = DatosActa::where('oconcluida', 1)
        ->whereBetween('ofechafin', [$inicio, $fin])
        ->get();

    return view('adg.levels.reportes.reporte-actos', compact('actas', 'fecha'));
}

public function reporteIntervencion(Request $request)
{
    // Recibes la fecha seleccionada
    $fecha = $request->input('fecha_intervencion');  

    // Validación de la fecha
    if (!$fecha || !preg_match('/^\d{2}-\d{4}$/', $fecha)) {
        return back()->with('warning', 'La fecha seleccionada no es válida.');
    }

    // Crear el rango de fechas
    $inicio = Carbon::createFromFormat('m-Y', $fecha)->startOfMonth()->toDateString(); // Primer día del mes
    $fin = Carbon::createFromFormat('m-Y', $fecha)->endOfMonth()->toDateString();   // Último día del mes

    // Filtrar intervenciones en el rango de fechas
    $intervenciones = Intervencion::whereBetween('ofecha_realizacion', [$inicio, $fin])
        ->orWhereBetween('ofecha_entrega', [$inicio, $fin])
        ->get();

    // Pasar los datos a la vista
    return view('adg.levels.reportes.reporte-intervencion', compact('intervenciones', 'fecha'));
}

public function reporteNoAdeudos(Request $request)
{
    // Recibes la fecha seleccionada
    $fecha = $request->input('fecha_noadeudos');  // Aquí recibes la fecha seleccionada

    // Validación de la fecha
    if (!$fecha || !preg_match('/^\d{2}-\d{4}$/', $fecha)) {
        return back()->with('warning', 'La fecha seleccionada no es válida.');
    }

    // Crear el rango de fechas
    $inicio = Carbon::createFromFormat('m-Y', $fecha)->startOfMonth()->toDateString(); // Primer día del mes
    $fin = Carbon::createFromFormat('m-Y', $fecha)->endOfMonth()->toDateString();   // Último día del mes

    // Filtrar solicitudes no adeudos en el rango de fechas y donde ogenerado es 1
    $solicitudes = SolicitudNoAdeudo::where('ogenerado', 1)
        ->whereBetween('olugar_fecha', [$inicio, $fin])
        ->get();

    // Pasar los datos a la vista
    return view('adg.levels.reportes.reporte-noadeudos', compact('solicitudes', 'fecha'));
}

}

