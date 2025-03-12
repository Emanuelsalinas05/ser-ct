<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compromisos90dias extends Model
{
    use HasFactory;


    protected $table = 'g1compromisos90dias';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'odescripcion_asunto',
                            'oresponsable',
                            'oacciones_realizar',
                            'olugar',
                            'ofecha',
                            'ohora',
                            'status',
                            'oanio',
                        ];
}
