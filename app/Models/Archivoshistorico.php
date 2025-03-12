<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivoshistorico extends Model
{
    use HasFactory;

    protected $table = 'g1archivos_concentracion_historico';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'onombre_documento',
                            'ourl',
                            'oarchivo_adjunto',
                            'oclave_expediente',
                            'onombre_expediente',
                            'operiodo',
                            'operiodo2',
                            'onum_legajos',
                            'onum_documentos',
                            'otiempo_conservacion',
                            'add_otiempo_conservacion',
                            'otiempo_conservacion2',
                            'add_otiempo_conservacion2',
                            'ocomentarios',
                            'status',
                            'oanio',
                        ];
}
