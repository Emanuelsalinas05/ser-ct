<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class CentroTrabajoService
{
    public static function findById($id)
    {
        $response = Http::get(env('MICROSERVICE_URL') .
            '?action=centroTrabajoFindById&id=' . urlencode($id));

        // Verificar si la solicitud fue exitosa y el código de estado es 200
        if ($response->successful() && $response->status() === 200) {
            return $response->object();
        } else {
            // En caso de que la solicitud no sea exitosa o el código de estado no sea 200, devolver null
            return null;
        }
    }

    public static function findByOClave($oclave)
    {
        $response = Http::get(env('MICROSERVICE_URL') .
            '?action=centroTrabajoFindByOClave&oclave=' . urlencode($oclave));

        if ($response->successful() && $response->status() === 200) {
            return $response->object();
        } else {
            return null;
        }
    }
}
