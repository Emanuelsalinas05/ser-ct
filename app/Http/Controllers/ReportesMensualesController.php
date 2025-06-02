<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosActa;
use App\Models\Intervencion;
use App\Models\Solicitudnoadeudo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActasExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesMensualesController extends Controller
{
    // Método general para verificar rol 1 (Administrador)
    private function onlyAdmin()
    {
        if (Auth::user()->orol != 1) {
            abort(403, 'Acceso no autorizado.');
        }
    }

    // Método para validar y convertir fechas del input month (formato Y-m)
    private function getFechaRango($fechaInput)
    {
        if (!$fechaInput) {
            return null;
        }

        try {
            if (preg_match('/^\d{2}-\d{4}$/', $fechaInput)) {
                // Formato m-Y (como 02-2025)
                $carbon = Carbon::createFromFormat('m-Y', $fechaInput);
            } elseif (preg_match('/^\d{4}-\d{2}$/', $fechaInput)) {
                // Formato Y-m (como 2025-02)
                $carbon = Carbon::createFromFormat('Y-m', $fechaInput);
            } else {
                return null;
            }

            $inicio = $carbon->startOfMonth()->toDateString();
            $fin    = $carbon->endOfMonth()->toDateString();
            $fecha  = $carbon->format('m-Y');

            return [$inicio, $fin, $fecha];
        } catch (\Exception $e) {
            return null;
        }
    }


    public function reporteActos(Request $request)
    {
        $this->onlyAdmin();

        $fechaInput = $request->input('fecha_actos');
        $rango = $this->getFechaRango($fechaInput);

        if (!$rango) {
            return back()->with('warning', 'La fecha seleccionada no es válida.');
        }

        [$inicio, $fin, $fecha] = $rango;

        $actas = DatosActa::where('oconcluida', 1)
            ->whereBetween('ofechafin', [$inicio, $fin])
            ->get();

        return view('adg.levels.reportes.reporte-actos', compact('actas', 'fecha'));
    }

    public function reporteIntervencion(Request $request)
    {
        $this->onlyAdmin();

        $fechaInput = $request->input('fecha_intervencion');
        $rango = $this->getFechaRango($fechaInput);

        if (!$rango) {
            return back()->with('warning', 'La fecha seleccionada no es válida.');
        }

        [$inicio, $fin, $fecha] = $rango;

        $intervenciones = Intervencion::whereBetween('ofecha_realizacion', [$inicio, $fin])
            ->orWhereBetween('ofecha_entrega', [$inicio, $fin])
            ->get();

        return view('adg.levels.reportes.reporte-intervencion', compact('intervenciones', 'fecha'));
    }

    public function reporteNoAdeudos(Request $request)
    {
        $this->onlyAdmin();

        $fechaInput = $request->input('fecha_noadeudos');
        $rango = $this->getFechaRango($fechaInput);

        if (!$rango) {
            return back()->with('warning', 'La fecha seleccionada no es válida.');
        }

        [$inicio, $fin, $fecha] = $rango;

        $solicitudes = Solicitudnoadeudo::where('ogenerado', 1)
            ->whereBetween('olugar_fecha', [$inicio, $fin])
            ->get();

        return view('adg.levels.reportes.reporte-noadeudos', compact('solicitudes', 'fecha'));
    }

    public function exportExcel(Request $request)
    {
        $this->onlyAdmin();

        $fecha = $request->query('fecha');
        if (!$fecha) {
            return back()->with('warning', 'Fecha no proporcionada.');
        }

        return Excel::download(new ActasExport($fecha), "reporte_actos_$fecha.xlsx");
    }

    public function exportPDF(Request $request)
    {
        $this->onlyAdmin();

        $fecha = $request->query('fecha');
        $rango = $this->getFechaRango($fecha);

        if (!$rango) {
            return back()->with('warning', 'La fecha seleccionada no es válida.');
        }

        [$inicio, $fin, $fecha] = $rango;

        $actas = DatosActa::where('oconcluida', 1)
            ->whereBetween('ofechafin', [$inicio, $fin])
            ->get();

        $pdf = Pdf::loadView('adg.levels.reportes.actas-pdf', compact('actas', 'fecha'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("reporte_actos_$fecha.pdf");
    }
}
