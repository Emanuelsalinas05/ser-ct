<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    use HasFactory;

    protected $table = 'g1claves_plantilla';

    protected $fillable=[
                            'id',
                            'oclave',
                            'oclave_descripcion',  
                            'otipo',   
                            'otipo_categoria', 
                            'oclave_pago', 
                            'ocm', 
                            'oclave_nivel',
                            'oclave_sueldo',
                            'omonto_mensual',
                            'ohoras_compatibilidad',
                            'ohoras_servicio',
                            'ohoras_docencia',
                            'oban_nivel',
                            'onivel',
                            'omodalidad',
                        ];


}
