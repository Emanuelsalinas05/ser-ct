<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventariocomputo extends Model
{
    use HasFactory;
            
    protected $table = 'g1inventario_equipocomputo';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'onombre_documento',
                            'ourl',
                            'oarchivo_adjunto',
                            'status',
                            'oanio',
                            'ofile',
                        ];
}
