<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivostramite extends Model
{
    use HasFactory;

    protected $table = 'g1archivos_tramite';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'onombre_documento',
                            'ourl',
                            'oarchivo_adjunto',
                            'oclave_expediente',
                            'onombre_expediente',
                            'onum_legajos',
                            'onum_documentos',
                            'ofecha_primero',
                            'ofecha_ultimo',
                            'status',
                            'oanio',
                        ];
}
