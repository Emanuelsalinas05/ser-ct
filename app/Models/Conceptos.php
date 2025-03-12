<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conceptos extends Model
{
    use HasFactory;
    
    protected $table = 'conceptos';


    protected $fillable=[
                            'id',
                            'onum_concepto',
                            'oconcepto',
                            'ourl_concepto',
                        ];


}
