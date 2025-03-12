<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informegestion extends Model
{
    use HasFactory;

    protected $table = 'g1informe_gestion';

    protected $fillable=[
                            'id',
                            'id_acta',
                            'id_ct',
                            'oi',
                            'oii',
                            'oiii',
                            'oiv',
                            'status',
                            'oanio',
                        ];
}
