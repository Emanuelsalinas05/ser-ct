<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Ctitulares;
use App\Models\Intervencion;
use App\Models\DatosActa;

class _adgIntervencionesgeneradasexcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getmacta = DatosActa::select(DB::raw('date_format(ofechafin, "%m-%Y") as fecha'))
                    ->whereOconcluida(1)
                    ->GroupBy(DB::raw('date_format(ofechafin, "%m-%Y")'))
                    ->OrderBy(DB::raw('date_format(ofechafin, "%m-%Y")'),'ASC')->get();

        return view('adg.levels.reportes.index',
                    compact('getmacta')
                );
    }

   
}
