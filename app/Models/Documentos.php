<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;

    protected $table = 'g1documentos';


    protected $fillable=[
                            'id',
                            'id_anexo',
                            'onum_documento',
                            'odocumento',
                            'ourl_documentos',
                            'oavance_documentos',
                            'odescripcion',
                            'oopendoc',
                            'ourl_documentos_admin',
                        ];

    public function anexo() {
        return $this->belongsTo(Anexos::class, 'id_anexo', 'id');
    }

}
