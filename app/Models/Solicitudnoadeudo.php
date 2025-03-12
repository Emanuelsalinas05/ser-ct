<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudnoadeudo extends Model
{
    use HasFactory;

    protected $table = 'g1solicitudes_noadeudos';

    protected $fillable=[
                            'id',
                            'odir',
                            'id_dir',
                            'id_sub',
                            'id_dep',
                            'id_sec',
                            'id_sup',
                            'id_ct',
                            'id_tipocert',
                            'oselecttipo',
                            'id_acta',
                            'onumero_oficio',
                            'olocalidad',
                            'omunicipio',
                            'ofecha',
                            'onombre_autoridadinmediata',
                            'ocargo_autoridadinmediata',
                            'otitular_caf',
                            'ofecha_acta',
                            'ohora_acta',

                            'ogenerado',
                            'oenviado',
                            'oentregado',
                            'ofinalizado',
                            'ogestion',
                            'aprobaradg',
                            'odee',
                            'oenviocaoe',
                            'oliberado',

                            'oadg',
                            'ofecha_adg',
                            'oficio_adg',
                            'oconsecutivo_adg',
                            'orubrica_adg',
                            'olugar_adg',
                            'ofile_adg',
                            'oruta_adg',
                            
                            'odee',
                            'ofecha_dee',
                            'oficio_dee',
                            'oconsecutivo_dee',
                            'orubrica_dee',
                            'olugar_dee',
                            'ofile_dee',
                            'oruta_dee',
                            
                            'ocaoe',
                            'oficio',
                            'ootitular_caoe',
                            'olugar_fecha',
                            'orubrica',

                            'oanio',
                            'status',
                        ];

    public function acta() {
        return $this->belongsTo(DatosActa::class, 'id_acta', 'id');
    }
    

    public function tipoceradeudo() {
        return $this->belongsTo(Tiposnoadeudo::class, 'id_tipocert', 'oorden');
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
