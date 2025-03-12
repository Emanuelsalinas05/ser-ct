<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentrosTrabajo extends Model
{
    use HasFactory;

    protected $table = 'g1centros_trabajo';

    protected $fillable=[
                            'id',
                            'kcvect',
                            'oclave',
                            'onombre_ct',
                            'odomicilio',
                            'odireccion',
                            'onamedir',
                            'oencargado',
                            'omodalidad',
                            'desc_modal',
                            'rcvelocalidad_inegi',
                            'rcvemunicipio_sep',
                            'nombre_col',
                            'nombre_loc',
                            'omunicipio',
                            'nombre_mun',
                            'ovalle',
                            'ocodigopostal',
                            'onombre_colonia',
                            'otelefono',
                            'otelefono_ext',
                            'ocelular1',
                            'oemail',
                            'oemail2',
                            'opagina_web',
                            'rcveturno',
                            'nom_turno',
                            'rcvect_zona',
                            'oclavezona',
                            'rcve_sector',
                            'oclavesector',
                            'rcvect_serreg',
                            'oclaveserreg',
                            'rcvedepadministrativa',
                            'rcvedepnormativa',
                            'rcveservicio',
                            'rcvesostenimiento',
                            'cct_zona',
                            'cct_sector',
                            'cct_depto',
                            'cct_responsable',
                            'ostatus',
                            'nom_status',
                            'olongitud',
                            'olatitud',
                            'oaltitud',
                        ];
}
