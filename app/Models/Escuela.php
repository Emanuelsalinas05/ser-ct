<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DatosActa;

class Escuela extends Model
{
    protected $table = 'escuelas';
    
    protected $primaryKey = 'id_ct';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_ct',
        'cct',
        'nombre',
        'nivel',
        'id_subdireccion',
        'id_departamento', 
        'id_sector',
        'id_supervision'
    ];

    public function datosActa()
    {
        return $this->hasMany(DatosActa::class, 'id_ct', 'id_ct');
    }
}