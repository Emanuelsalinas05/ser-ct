<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\Tipoacta;
use App\Models\Conceptos;
use App\Models\Documentos;

class DocumentosActoController extends Controller
{
    public function index()
    {
        //
    }

    public function juridico()
    {
        return view('documentos.marco-juridico');
    }

    public function organizacion()
    {
        return view('documentos.organizacion');
    }

    public function recursoshumanos()
    {
        return view('documentos.recursos-humanos');
    }

    public function recursosmateriales()
    {
        return view('documentos.situacion-recursos-materiales');
    }

    public function situaciontics()
    {
        return view('documentos.situacion-tics');
    }

    public function archivos()
    {
        return view('documentos.archivos');
    }

    public function noadeudos()
    {
        return view('documentos.certificados-no-adeudos');
    }

    public function informegestion()
    {
        return view('documentos.informe-gestion');
    }

    public function otroshechos()
    {
        return view('documentos.otros-hechos');
    }



}
