<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexos extends Model
{
    use HasFactory;
    
    protected $table = 'g1anexos';

    protected $fillable=[
                            'id',
                            'onum_anexo',
                            'oanexo',
                            'ourl_anexo',
                            'ourl_anexoadmin',
                            'ourl_anexoadmin_ok',
                            'ourl_anexoa_history',
                            'oavance_anexo',

                        ];

    public function documento() {
        return $this->belongsTo(Anexos::class, 'id', 'id_anexo');
    }

    
}
