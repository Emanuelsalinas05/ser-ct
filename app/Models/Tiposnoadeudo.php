<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiposnoadeudo extends Model
{
    use HasFactory;

    protected $table = 'g1tipocertificado_noadeudo';

    protected $fillable=[
                            'id',
                            'otipo',
                            'oorden',
                            'oanio',
                            'status',
                        ];
}
