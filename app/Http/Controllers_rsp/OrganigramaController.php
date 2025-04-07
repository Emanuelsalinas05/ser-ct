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
use App\Models\Organitation;

class OrganigramaController extends Controller
{
    public function index()
    {
        $centrotrabajo = CentrosTrabajo::get();
        $organitation  = Organitation::get();
        
        $sector     = Organitation::select('idct_sector','cct_sector')
                        ->GroupBy('idct_sector','cct_sector')->get();

        $supervision= Organitation::select('idct_sector','idct_supervicion','cct_supervision')
                        ->GroupBy('idct_sector','idct_supervicion','cct_supervision')->get();

        $escuelas   = Organitation::select('idct_sector','idct_supervicion','idct_escuela','cct_escuela')
                    ->GroupBy('idct_sector','idct_supervicion','idct_escuela','cct_escuela')->get();

        return view('admin.organitation.index',
                compact( 'centrotrabajo','organitation','sector','supervision','escuelas')
                );
    }

}
