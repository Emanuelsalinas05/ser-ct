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

class RmcertificadosNoadeudos extends Controller
{
    public function index()
    {
        $anexo      = Anexos::whereOnumAnexo(14)->first();
        $documento  = Documentos::whereIdAnexo($anexo->id)->whereId(11)->first();
        $datosacta  = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $avances    = Avanceanexos::whereIdActa($datosacta->id)->first();
        $inoadeudo = Certificadosnoadeudo::whereIdActa($datosacta->id)->whereNotIn('status',['B'])->get();
        $inoadeudoc= Certificadosnoadeudo::whereIdActa($datosacta->id)->whereNotIn('status',['B'])->count();

        return view('documentos.certificados-no-adeudos.14-1.index', 
                compact('anexo', 'documento', 'datosacta', 'avances', 'inoadeudo', 'inoadeudoc')
                );
    }

    public function store(Request $request)
    {
        $user           = User::whereId(Auth::user()->id)->first();
        $centrotrabajo  = CentrosTrabajo::whereKcvect($user->id_ct)->first();
        $elct           = $centrotrabajo->oclave;
        $iddoc          = $request->iddoc;
        $idacta         = $request->idacta;
        $nombredoc      = str_replace(' ', '',$request->onombre_documento);
        $file           = $request->file('onombre_archivo');

        if($request->hasFile('onombre_archivo'))
        {
            $file->storeAs('certificados-noadeudos/14-1/'.$elct.'/'.$idacta, $nombredoc.'.'.$file->extension(), 'public');
            Certificadosnoadeudo::create([
                'id_acta'           => $idacta,
                'id_ct'             => Auth::user()->id_ct,
                'onombre_documento' => $nombredoc,
                'ourl'              => 'certificados-noadeudos/14-1/'.$elct.'/'.$idacta.'/',
                'oarchivo_adjunto'  => $nombredoc.'.'.$file->extension(),
                'oanio'             => date('Y-m-d'),     
            ]);
            return redirect()->back()->with("success", "Se ha cargado el archivo $nombredoc correctamente");
        }else{
            return redirect()->back()->with("warning", "No se ha cargado ningún archivo");
        } 
    }


    public function update(Request $request, string $id)
    {
        if($request->actionplantilla==1)
        {
            $almacen = Certificadosnoadeudo::whereId($id)->first();
            $update_almacen = Certificadosnoadeudo::whereId($id);
            $update_almacen->update([ 'status' => 'B' ]);
            unlink(storage_path('app/public/'.$almacen->ourl.$almacen->oarchivo_adjunto));

            return redirect()->back()->with("success", "Se ha removido el archivo correctamente");
  
        }else if($request->actionplantilla==2){
            $avanceanexos = Avanceanexos::whereId($id)->first();
            $avances_plantilla = Avanceanexos::whereIdActa($avanceanexos->id_acta);
            $avances_plantilla->update(['ocertificados_no_adeudo_a' => 1]);  
  
            return redirect()->route('documentos.certificados-no-adeudos.index')
                    ->with("success", "Se ha finalizado el registro de certificados de no adeudos"); 
        }   
    }
}
