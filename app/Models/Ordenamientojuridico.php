<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordenamientojuridico extends Model
{
    use HasFactory;

    protected $table = 'g1ordenamiento_juridico';


    protected $fillable=[
                            'id',
                            'id_ct',
                            'id_anexo',
                            'onprogresivo',
                            'odenominacion_juridica',
                            'omedio_oficial_publicacion',
                            'ofecha_publicacion',
                            'ourl_publicacion',
                        ];

    public function anexos() {
        return $this->belongsTo(Anexos::class, 'id_anexo', 'id');
    }
}
