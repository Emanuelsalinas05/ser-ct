<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organitation extends Model
{
    use HasFactory;

    protected $table = 'g1organigrama';

    protected $fillable=[
                            'id',
                            'idct_direccion',
                            'cct_direccion',
                            'direccion',
                            'oct_level_direccion',
                            'oorden_sub',
                            'idct_subdireccion',
                            'cct_subdireccion',
                            'subdireccion',
                            'oct_level_subdireccion',
                            'oorden_dep',
                            'idct_departamento',
                            'cct_departamento',
                            'departamento',
                            'oct_level_departamento',
                            'idct_sector',
                            'cct_sector',
                            'oct_level_sector',
                            'idct_supervicion',
                            'cct_supervision',
                            'oct_level_supervicion',
                            'idct_escuela',
                            'cct_escuela',
                            'oct_level_escuela',
                            'ovalle',
                            'odireccionnivel',
                            'istatus',
                            'ocorreosub',
                            'ocorreodep',
                            'ocorreoestructura',
                            'ocorreoestructura2',
                            'ocorreos',
                            'oejemploz',
                            'oejemploz2',
                            'oejemploz3',
                        ];

    public function ctdir() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_direccion', 'kcvect');
    }

    public function ctsub() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_subdireccion', 'kcvect');
    }

    public function ctdep() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_departamento', 'kcvect');
    }

    public function ctsec() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_sector', 'kcvect');
    }

    public function ctsup() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_supervicion', 'kcvect');
    }

    public function cct() {
        return $this->belongsTo(CentrosTrabajo::class, 'idct_escuela', 'kcvect');
    }





    public function uctdir() {
        return $this->belongsTo(User::class, 'idct_direccion', 'id_ct')->whereOrol(1);
    }

    public function uctsub() {
        return $this->belongsTo(User::class, 'idct_subdireccion', 'id_ct')->whereOrol(2);
    }

    public function uctdep() {
        return $this->belongsTo(User::class, 'idct_departamento', 'id_ct')->whereOrol(2);
    }

    public function uctsec() {
        return $this->belongsTo(User::class, 'idct_sector', 'id_ct')->whereOrol(2);
    }

    public function uctsup() {
        return $this->belongsTo(User::class, 'idct_supervicion', 'id_ct')->whereOrol(2);
    }






    public function usdir() {
        return $this->belongsTo(User::class, 'cct_direccion', 'email')->whereOrol(3);
    }

    public function ussub() {
        return $this->belongsTo(User::class, 'cct_subdireccion', 'email')->whereOrol(3);
    }

    public function usdep() {
        return $this->belongsTo(User::class, 'cct_departamento', 'email')->whereOrol(3);
    }

    public function ussec() {
        return $this->belongsTo(User::class, 'cct_sector', 'email')->whereOrol(3);
    }

    public function ussup() {
        return $this->belongsTo(User::class, 'cct_supervision', 'email')->whereOrol(3);
    }

    public function usct() {
        return $this->belongsTo(User::class, 'cct_escuela', 'email')->whereOrol(3);
    }



    public function ctitularsub() {
        return $this->belongsTo(Ctitilar::class, 'idct_subdireccion', 'id_ct');
    }

    public function ctitulardep() {
        return $this->belongsTo(Ctitilar::class, 'idct_departamento', 'id_ct');
    }




}
