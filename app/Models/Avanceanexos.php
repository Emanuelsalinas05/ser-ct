<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avanceanexos extends Model
{
    use HasFactory;

    protected $table = 'g1avance_anexos';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'omarco_juridico_d',    
                            'orecursos_humanos_d',  
                            'oplantilla_personal_a',
                            'oplantilla_comisionados_a',
                            'osituacion_recursos_materiales_d', 
                            'oinventario_bienes_a',
                            'oinventario_almacen_a',
                            'orelacion_bienes_custodia_a',
                            'osituacion_tics_d',    
                            'oinventario_equipo_a',
                            'oarchivos_d',
                            'orelacion_archivos_a',
                            'orelacion_archivos_historico_a',
                            'orelacion_documentos_noconvencionles_a',
                            'ocertificados_no_adeudos_d',   
                            'ocertificados_no_adeudo_a',
                            'oinforme_gestion_d',   
                            'oinforme_gestion_a',
                            'oinforme_compromisos_a',
                            'ootros_hechos_d',
                            'ootros_hechos_a',
                            'oactual',
                            'oestado',
                            'ocheckacta',
                            'ocargaacta',
                            'oopenanexo',
                            'ocargacomprimido',
                            'ofinalizacion',
                            'ofecha_er',                        
                            'oanio',
                            'status',
                            'ofecha_omarco_juridico',
                            'ofecha_orecursos_humanos',
                            'ofecha_osituacion_recursos_materiales',
                            'ofecha_osituacion_tics',
                            'ofecha_oarchivos',
                            'ofecha_ocertificados_no_adeudos',
                            'ofecha_oinforme_gestion',
                            'ofecha_ootros_hechos',   
                        ];

    public function elct() {
        return $this->belongsTo(CentrosTrabajo::class, 'kcvect', 'id_ct');
    }

    public function tipoacta() {
        return $this->belongsTo(CentrosTrabajo::class, 'id', 'id_acta');
    }

}
