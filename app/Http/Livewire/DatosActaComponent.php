<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\CentrosTrabajo;
use App\Models\Plantilla;
use App\Models\Anexos;
use App\Models\Documentos;
use App\Models\Ordenamientojuridico;

use App\Models\Tipoacta;
use App\Models\DatosActa;
use App\Models\Avanceanexos;
use App\Models\User;


class DatosActaComponent extends Component
{
    use WithFileUploads;
    public $onombre_entrega_a, $orfc_entrega_a, $ocargo_entrega_a, $onombre_recibe_a, $orfc_recibe_a, $ocargo_recibe_a, $onombre_recibe_ac, $orfc_recibe_ac;

    public function render()
    {
        $tipoacta    = Tipoacta::get();
        $elacta      = DatosActa::whereIdUser(Auth::user()->id)->first();
        $documentos  = Documentos::get();
        
        if($elacta)
        {
            $datosacta   = DatosActa::select('*',
                            DB::raw('CASE 
                                        WHEN 
                                            id_tipoacta=1 
                                        THEN 
                                            CASE WHEN   
                                                onombre_entrega_a IS NOT NULL AND
                                                orfc_entrega_a IS NOT NULL AND
                                                ocargo_entrega_a IS NOT NULL AND
                                                onombre_recibe_a IS NOT NULL AND
                                                orfc_recibe_a IS NOT NULL AND
                                                ocargo_recibe_a  IS NOT NULL
                                            THEN 1 ELSE 0 END 
                                        WHEN 
                                            id_tipoacta=2 
                                        THEN 
                                            CASE WHEN 
                                                onombre_recibe_ac IS NOT NULL AND
                                                orfc_recibe_ac IS NOT NULL
                                            THEN 1 ELSE 0 END  
                                        END AS ock'))
                            ->whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

            $avanceanexos = Avanceanexos::select('*',
                            DB::raw('CASE WHEN
                                        omarco_juridico_d=1 AND orecursos_humanos_d=1 AND 
                                        osituacion_recursos_materiales_d=1 AND 
                                        osituacion_tics_d AND 
                                        ocertificados_no_adeudos_d=1 AND 
                                        oinforme_gestion_d=1 AND 
                                        oinforme_gestion_d=1 AND 
                                        ootros_hechos_d=1  
                                    THEN 1 ELSE 0 END AS completado')
                            )->whereIdActa($datosacta->id)->get();
            $avance       = Avanceanexos::select('*',
                            DB::raw('CASE WHEN
                                        omarco_juridico_d=1 AND orecursos_humanos_d=1 AND 
                                        osituacion_recursos_materiales_d=1 AND 
                                        osituacion_tics_d AND 
                                        ocertificados_no_adeudos_d=1 AND 
                                        oinforme_gestion_d=1 AND 
                                        oinforme_gestion_d=1 AND 
                                        ootros_hechos_d=1  
                                    THEN 1 ELSE 0 END AS completado')
                            )->whereIdActa($datosacta->id)->first();

            if($datosacta->id_tipoacta==2){
                $anexos   = Anexos::whereNotIn('onum_anexo', [14,15])->OrderBy('onum_anexo', 'ASC')->get();
            }else{
               $anexos    = Anexos::OrderBy('onum_anexo', 'ASC')->get(); 
            }

            $ban = 1;
            return view('livewire.datos-acta-component',
                    compact('tipoacta', 'anexos', 'documentos', 'datosacta', 'avanceanexos', 'avance', 'ban')
                    );
        }else{
            $ban = 0;
        }
        return view('livewire.datos-acta-component',
                compact('tipoacta', 'documentos', 'ban')
                );
    }


    public function tipoActa($idacta)
    {
        $datosacta = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();
        $datosCT   = CentrosTrabajo::whereId(Auth::user()->id_ct)->first();

        if(!$datosacta)
        {

            DatosActa::create([
                'id_user'       => Auth::user()->id,
                'id_tipoacta'   => $idacta,
                'id_ct'         => Auth::user()->id_ct,
                'oactual'       => 1,
                'ofecha'        => date('Y-m-d'),
                'oestado'       => 0,
                'oconcluida'    => 0,
                'oct_a'         => $datosCT->oclave,   
                'oct_ac'        => $datosCT->oclave,    
                'odomicilio_ct_a'=> $datosCT->odomicilio,
                'olugar_a'      => $datosCT->nombre_loc,
                'onombre_ct_a'  => $datosCT->onombre_ct,
                'onombre_ct_ac' => $datosCT->onombre_ct,
                'odomicilio_ct_ac'=> $datosCT->odomicilio,
                'olugar_ac'     => $datosCT->nombre_loc,
            ]);

            $datosacta_ = DatosActa::whereIdUser(Auth::user()->id)->whereOconcluida(0)->first();

            Avanceanexos::create([
                'id_acta'   => $datosacta_->id,
                'id_ct'     => $datosacta_->id_ct,
                'oanio'     => date('Y-m-d'),
                'omarco_juridico_d'     => 1,
                'ofecha_omarco_juridico' => date('Y-m-d'),
                'oactual'   => 1,
            ]);
        }
    }

    public function saveDatos($id, $val)
    {
        if($val==1)
        {
            $pdateActa = DatosActa::whereId($id);
            $pdateActa->update([
                    'onombre_entrega_a' => $this->onombre_entrega_a,
                    'orfc_entrega_a'    => $this->orfc_entrega_a,
                    'ocargo_entrega_a'  => $this->ocargo_entrega_a,
                    'onombre_recibe_a'  => $this->onombre_recibe_a,
                    'orfc_recibe_a'     => $this->orfc_recibe_a,
                    'ocargo_recibe_a'   => $this->ocargo_recibe_a,
                ]);
        }else if($val==2){
            $pdateActa = DatosActa::whereId($id);
            $pdateActa->update([
                    'onombre_recibe_ac' => $this->ovalle,
                    'orfc_recibe_ac'    => $this->ofuncion,
                ]);
        }
    
    }


}
