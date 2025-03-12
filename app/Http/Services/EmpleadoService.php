<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class EmpleadoService
{
    public static function findById($id)
    {
        $response = Http::get(env('MICROSERVICE_URL') .
            '?action=empleadoFindById&id=' . urlencode($id));

        // Verificar si la solicitud fue exitosa y el código de estado es 200
        if ($response->successful() && $response->status() === 200) {
            return $response->object();
        } else {
            // En caso de que la solicitud no sea exitosa o el código de estado no sea 200, devolver null
            return null;
        }
    }

    public static function findByRFC($rfc)
    {
        $response = Http::get(env('MICROSERVICE_URL') .
            '?action=empleadoFindByRFC&rfc=' . urlencode($rfc));

        if ($response->successful() && $response->status() === 200) {
            return $response->object();
        } else {
            return null;
        }
    }
}
