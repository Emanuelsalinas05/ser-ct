<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervencion extends Model
{
    use HasFactory;
    
    protected $table = 'b3adg_intervenciones';

    protected $fillable=[
                            'id',
                            'idct_departamento',
                            'oct_nivel',
                            'onivel_educativo',
                            'otitular_nivel',
                            'ofecha_realizacion',
                            'idct_escuela',
                            'oclave',
                            'onombrect',
                            'odomicilio',
                            'oentrega',
                            'orecibe',
                            'omotivo',
                            'ofecha_entrega',
                            'ohora_entrega',
                            'ogenerada',
                            'onotifica_nivel',
                            'ofin',
                            'ofechafin',
                            'ourl',
                            'oarchivo',
                            'ofile',
                            'ooficio',
                            'oconsecutivo',
                            'oanio',
                            'onivel',
                            'onotificado',
                            'istatus',

                        ];

    public function ctadg() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_departamento', 'kcvect');
    }

    public function ctentrega() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_escuela', 'kcvect');
    }

    
}
