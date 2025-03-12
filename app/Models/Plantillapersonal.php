<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantillapersonal extends Model
{
    use HasFactory;

    protected $table = 'g1plantilla_personal';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'oclave_puesto',
                            'onombre_puesto',
                            'onivelrango',
                            'ototalplazas',
                            'ototalocupadas',
                            'ototalvacantes',
                            'osueldo_ind',
                            'osueldo_total',
                            'oactual',
                            'status',
                            'oanio',
                            'ofinalizacion',
                            'onombre_documento',
                            'ourl',
                            'oarchivo_adjunto',
                            'ofile',
                        ];

    public function acta() {
        return $this->belongsTo(DatosActa::class, 'id_acta', 'id');
    }

    public function elct() {
        return $this->belongsTo(CentrosTrabajo::class, 'id_ct', 'id');
    }

}
