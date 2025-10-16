<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervencion extends Model
{
    use HasFactory;

    protected $table = 'b3adg_intervenciones';

    // no incluyas 'id'
    protected $fillable = [
        'idct_departamento','oct_nivel','onivel_educativo','otitular_nivel',
        'ofecha_realizacion','idct_escuela','oclave','onombrect','odomicilio',
        'oentrega','orecibe','omotivo','ofecha_entrega','ohora_entrega',
        'ogenerada','onotifica_nivel','ofin','ofechafin','ourl','oarchivo',
        'ofile','ooficio','oconsecutivo','oanio','onivel','onotificado','istatus',
    ];

    protected $casts = [
        'ofecha_realizacion' => 'date',
        'ofecha_entrega'     => 'date',
        'ofechafin'          => 'date',
        'ogenerada'          => 'boolean',
        'ofin'               => 'boolean',
        'onotifica_nivel'    => 'boolean',
        'onotificado'        => 'boolean',
        'oanio'              => 'integer',
    ];

    // relaciones
    public function ctadg()
    {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_departamento', 'kcvect');
    }

    public function ctentrega()
    {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_escuela', 'kcvect');
    }

    // scopes
    public function scopeActiva($q, int $idCtEscuela)
    {
        return $q->where('idct_escuela', $idCtEscuela)
                 ->where('ogenerada', 1)
                 ->where('ofin', 0)
                 ->where('istatus', '!=', 'B');
    }

    public function scopeDeEscuela($q, int $idCtEscuela)
    {
        return $q->where('idct_escuela', $idCtEscuela);
    }

    // helper
    public static function existeActiva(int $idCtEscuela): bool
    {
        return static::activa($idCtEscuela)->exists();
    }
}
