<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantillacomisionados extends Model
{
    use HasFactory;

    protected $table = 'g1plantilla_comisionados';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'onombre_servidor',
                            'ounidad_adscripcion',
                            'ocomisionado_act',
                            'operiodoinicio',
                            'operiodofinal',
                            'ooficio_autorizacion',
                            'oobservaciones',
                            'status',
                            'option',
                            'oactual',
                            'oanio',
                            'ofinalizacion',
                        ];

    public function acta() {
        return $this->belongsTo(DatosActa::class, 'id_acta', 'id');
    }

    public function elct() {
        return $this->belongsTo(CentrosTrabajo::class, 'id_ct', 'id');
    }

}
