<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosActa extends Model
{
    use HasFactory;

    protected $table = 'g1acta';

    protected $fillable=[
                            'id',
                            'id_user',
                            'id_tipoacta',
                            
                            'id_ctorigen',
                            'id_dir',
                            'id_sub',
                            'id_dep',
                            'id_sec',
                            'id_sup',
                            'id_ct',
                            
                            'octorigen',
                            'oct_a',
                            'onombre_ct_a',
                            'olugar_a',
                            'ohora_inicio_a',
                            'ofecha_inicio_a',
                            'odomicilio_ct_a',
                            'onombre_entrega_a',
                            'orfc_entrega_a',
                            'ocargo_entrega_a',
                            'oidentificacion_entrega_a',
                            'onumero_identificacion_entrega_a',
                            'oidentificacion_url_entrega_a',
                            'onombre_recibe_a',
                            'orfc_recibe_a',
                            'ocargo_recibe_a',
                            'oidentificacion_recibe_a',
                            'onumero_identificacion_recibe_a',
                            'oidentificacion_url_recibe_a',
                            'onombre_testigo_a',
                            'oct_testigo_a',
                            'ocargo_testigo_a',
                            'onombre_testigo2_a',
                            'oct_testigo2_a',
                            'ocargo_testigo2_a',
                            'oidentificacion_testigo',
                            'onumero_identificacion_testigo_a',
                            'oidentificacion_url_testigo',
                            'orfc_testigo',
                            'oidentificacion_testigo2',
                            'onumero_identificacion_testigo2_a',
                            'oidentificacion_url_testigo2',
                            'orfc_testigo2',
                            'orepresentante_a',
                            'onombre_representante_contraloria_a',
                            'orfc_orepresentante_contraloria_a',
                            'ooficio_designacion_er_a',
                            'ofecha_ofocio_designacion_er_a',
                            'ohechos_a',
                            'oanexos_total_a',
                            'ohora_fin_a',
                            'ofecha_fin_a',
                            'olugar_ac',
                            'ohora_inicio_ac',
                            'ofecha_inicio_ac',
                            'oct_ac',
                            'onombre_ct_ac',
                            'odepartamento_ac',
                            'odomicilio_ct_ac',
                            'otelefono_ct_ac',
                            'orfc_recibe_ac',
                            'onombre_recibe_ac',
                            'oidentificacion_recibe_ac',
                            'onumero_identificacion_recibe_ac',
                            'oidentificacion_url_recibe_ac',
                            'orepresentante_ac',
                            'orfc_orepresentante_contraloria_ac',
                            'orepresentante_contraloria_ac',
                            'oidentificacion_representante_ac',
                            'onumero_identificacion_representante_ac',
                            'oidentificacion_representante_url_ac',
                            'ooficio_designacion_ac',
                            'ofecha_ofocio_designacion_ac',
                            'orfc_testigo1_ac',
                            'onombre_testigo1_ac',
                            'oidentificacion_testigo1_ac',
                            'onumero_identificacion_testigo1_ac',
                            'oidentificacion_testigo1_url_ac',
                            'orfc_testigo2_ac',
                            'onombre_testigo2_ac',
                            'oidentificacion_testigo2_ac',
                            'onumero_identificacion_testigo2_ac',
                            'oidentificacion_testigo2_url_ac',
                            'oidentificacion_ac',
                            'ohechos_ac',
                            'oanexos_total_ac',
                            'omanifestacion_recibe_ac',
                            'omanifiestan_representante_organo_ac',
                            'ohora_fin_ac',
                            'ofecha_fin_ac',
                            'status',
                            'oactual',
                            'ocheck',
                            'ohechos',
                            'ourl_hechos',
                            'ohechosurl_ac',
                            'oestado',
                            'ocheckactaa',
                            'ocargaacta',
                            'ocheckacta',
                            'ourl_acta',
                            'oopenanexo',
                            'oconcluida',
                            'ofecha',
                            'ofechafin',
                            'ocodigo_verificacion',
                            'ocargacomprimido',
                            'oenviocorreooic',
                            'onombrecarpeta',
                            'ourlcarpeta',
                            'ocorreocc',
                        ];

    public function eluser() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function tipoacta() {
        return $this->belongsTo(Tipoacta::class, 'id_tipoacta', 'id');
    }

    public function elct() {
        return $this->belongsTo(CentrosTrabajo::class, 'id_ct', 'kcvect');
    }

    public function avances() {
        return $this->belongsTo(Avanceanexos::class, 'id', 'id_acta');
    }
    
    public function inventariobienes(){
    return $this->belongsTo(Inventariobienes::class, 'id', 'id_acta');
    }
    public function inventarioalmacen(){
        return $this->belongsTo(Inventarioalmacen::class, 'id', 'id_acta');
    }
    public function relacioncustodias(){
        return $this->belongsTo(Relacioncustodias::class, 'id', 'id_acta');
    }
    public function inventariocomputo(){
        return $this->belongsTo(Inventariocomputo::class, 'id', 'id_acta');
    }
    public function documentoshemerograficos(){
        return $this->belongsTo(Documentoshemerograficos::class, 'id', 'id_acta');
    }
    public function certificadosnoadeudo(){
        return $this->belongsTo(Certificadosnoadeudo::class, 'id', 'id_acta');
    }
    public function otroshechos(){
        return $this->belongsTo(Otroshechos::class, 'id', 'id_acta');
    }
    public function archivostramite(){
        return $this->belongsTo(Archivostramite::class, 'id', 'id_acta');
    }
    public function archivoshistorico(){
        return $this->belongsTo(Archivoshistorico::class, 'id', 'id_acta');
    }
    public function informegestion(){
        return $this->belongsTo(Informegestion::class, 'id', 'id_acta');
    }
    public function compromisos90dias(){
        return $this->belongsTo(Compromisos90dias::class, 'id', 'id_acta');
    }
    



}
