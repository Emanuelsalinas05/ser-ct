<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoacta extends Model
{
    use HasFactory;

     protected $table = 'g1tipoacta';


    protected $fillable=[
                            'id',
                            'otipoacta',
                            'oapodo',
                            'odescripcion',
                        ];

 
}
