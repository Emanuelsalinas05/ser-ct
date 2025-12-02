<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DatosActa;
use App\Models\User;

class ReportePdfController extends Controller
{
    /**
     * Genera un PDF de reporte validando permisos del usuario
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generarPdf(Request $request)
    {
        $idActa = $request->input('i1d3');
        $idReporte = $request->input('idr3p0rt');
        $us = $request->input('us');
        $unidad = $request->input('un1d');

        // Validar que el usuario esté autenticado
        if (!Auth::check()) {
            abort(403, 'Debes estar autenticado para ver este documento.');
        }

        $user = Auth::user();

        // Validar que el acta exista
        if (!$idActa) {
            abort(404, 'Acta no encontrada.');
        }

        $acta = DatosActa::find($idActa);
        
        if (!$acta) {
            abort(404, 'Acta no encontrada.');
        }

        // VALIDACIÓN DE PERMISOS POR ROL
        // Rol 3 solo puede ver sus propios documentos
        if ($user->orol == 3) {
            // Verificar que el acta pertenezca al usuario autenticado
            if ($acta->id_user != $user->id) {
                \Log::warning("Intento de acceso denegado - Usuario ID: {$user->id}, Rol: {$user->orol}, Acta ID: {$idActa}, Acta User ID: {$acta->id_user}");
                abort(403, 'No tienes permiso para ver este documento. Solo puedes ver tus propios documentos.');
            }
        }
        // Los roles 1 y 99 pueden ver todos los documentos (sin restricción)
        // Otros roles pueden tener restricciones adicionales si es necesario

        // Log para depuración
        \Log::info("Generando PDF - Usuario ID: {$user->id}, Rol: {$user->orol}, Acta ID: {$idActa}, Reporte ID: {$idReporte}");

        // Si pasa todas las validaciones, redirigir al generador de PDFs
        $url = url('/reportes/print-report.php') . '?' . http_build_query([
            'i1d3' => $idActa,
            'idr3p0rt' => $idReporte,
            'us' => $us,
            'un1d' => $unidad
        ]);

        return redirect($url);
    }
}

