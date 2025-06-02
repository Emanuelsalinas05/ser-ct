<?php

namespace App\Exports;

use App\Models\DatosActa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ActasExport implements FromView
{
    protected $fecha;

    public function __construct($fecha)
    {
        $this->fecha = $fecha;
    }

    public function view(): View
    {
        $carbon = Carbon::createFromFormat('m-Y', $this->fecha);
        $inicio = $carbon->startOfMonth()->toDateString();
        $fin    = $carbon->endOfMonth()->toDateString();

        $actas = DatosActa::where('oconcluida', 1)
            ->whereBetween('ofechafin', [$inicio, $fin])
            ->get();

        return view('adg.levels.reportes.actas-excel', [
            'actas' => $actas,
            'fecha' => $this->fecha,
        ]);

    }
}
