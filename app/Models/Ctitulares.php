<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ctitulares extends Model
{
    use HasFactory;

    protected $table = 'g1titulares';

    protected $fillable=[
                            'id',
                            'id_ct',
                            'oclave',
                            'onombre_ct',
                            'ooficio',
                            'oanio',
                            'ocargo',
                            'otitular',
                            'oorden',
                            'onivel',
                            'istatus',
                        ];

    public function elct() {
        return $this->belongsTo(CentrosTrabajo::class, 'kcvect', 'id_ct');
    }

    public function eluser() {
        return $this->belongsTo(CentrosTrabajo::class, 'id_ct', 'id_ct')->whereOrol(2);
    }


    public function orgsub() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_subdireccion', 'id_ct');
    }

    public function orgdep() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_departamento', 'id_ct');
    }


}
