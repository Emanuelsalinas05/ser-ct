<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficioscna extends Model
{
    use HasFactory;

    protected $table = 'g1oficios_cna';

    protected $fillable=[
                            'id',
                            'id_dir',
                            'id_sub',
                            'id_dep',
                            'id_sec',
                            'id_sup',
                            'id_ct',
                            'id_acta',
                            'onivel',

                            'oadg',
                            'ofecha_adg',
                            'ooficio_adg',

                            'odee',
                            'olugar_dee',
                            'ooficio_dee'
                            
                            'oanio',
                            'status',
                        ];

    public function acta() {
        return $this->belongsTo(DatosActa::class, 'id_acta', 'id');
    }
    

    public function titulardir() {
        return $this->belongsTo(Ctitulares::class, 'id_dir', 'id_ct');
    }

    public function titularsub() {
        return $this->belongsTo(Ctitulares::class, 'id_sub', 'id_ct');
    }

    public function titulardep() {
        return $this->belongsTo(Ctitulares::class, 'id_dep', 'id_ct');
    }



}
