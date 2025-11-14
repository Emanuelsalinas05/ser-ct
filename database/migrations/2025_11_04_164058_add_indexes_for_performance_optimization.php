<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Agrega índices para optimizar el rendimiento de las consultas más frecuentes
     * Prioridad: Entregas-Recepción (finalizadas y en proceso) e Intervenciones
     */
    public function up(): void
    {
        // ============================================
        // TABLA g1acta (DatosActa) - PRIORIDAD MÁXIMA
        // ============================================
        // Índices simples para campos usados frecuentemente en WHERE
        if (Schema::hasTable('g1acta')) {
            Schema::table('g1acta', function (Blueprint $table) {
                // Índices simples para campos críticos
                if (!$this->indexExists('g1acta', 'g1acta_oconcluida_index')) {
                    $table->index('oconcluida', 'g1acta_oconcluida_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_ctorigen_index')) {
                    $table->index('id_ctorigen', 'g1acta_id_ctorigen_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_user_index')) {
                    $table->index('id_user', 'g1acta_id_user_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_ct_index')) {
                    $table->index('id_ct', 'g1acta_id_ct_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_dir_index')) {
                    $table->index('id_dir', 'g1acta_id_dir_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_sub_index')) {
                    $table->index('id_sub', 'g1acta_id_sub_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_dep_index')) {
                    $table->index('id_dep', 'g1acta_id_dep_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_sec_index')) {
                    $table->index('id_sec', 'g1acta_id_sec_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_id_sup_index')) {
                    $table->index('id_sup', 'g1acta_id_sup_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_created_at_index')) {
                    $table->index('created_at', 'g1acta_created_at_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_ofecha_fin_a_index')) {
                    $table->index('ofecha_fin_a', 'g1acta_ofecha_fin_a_index');
                }
                if (!$this->indexExists('g1acta', 'g1acta_ofecha_fin_ac_index')) {
                    $table->index('ofecha_fin_ac', 'g1acta_ofecha_fin_ac_index');
                }
                
                // Índices compuestos para consultas frecuentes
                // Consulta: whereOconcluida(0/1) + id_ct
                if (!$this->indexExists('g1acta', 'g1acta_oconcluida_id_ct_index')) {
                    $table->index(['oconcluida', 'id_ct'], 'g1acta_oconcluida_id_ct_index');
                }
                // Consulta: whereOconcluida(0/1) + created_at (para ORDER BY)
                if (!$this->indexExists('g1acta', 'g1acta_oconcluida_created_at_index')) {
                    $table->index(['oconcluida', 'created_at'], 'g1acta_oconcluida_created_at_index');
                }
                // Consulta: id_ctorigen + oconcluida
                if (!$this->indexExists('g1acta', 'g1acta_id_ctorigen_oconcluida_index')) {
                    $table->index(['id_ctorigen', 'oconcluida'], 'g1acta_id_ctorigen_oconcluida_index');
                }
            });
        }

        // ============================================
        // TABLA b3adg_intervenciones (Intervencion) - PRIORIDAD ALTA
        // ============================================
        if (Schema::hasTable('b3adg_intervenciones')) {
            Schema::table('b3adg_intervenciones', function (Blueprint $table) {
                // Índices simples para campos críticos
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_onivel_index')) {
                    $table->index('onivel', 'b3adg_intervenciones_onivel_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_ofin_index')) {
                    $table->index('ofin', 'b3adg_intervenciones_ofin_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_ogenerada_index')) {
                    $table->index('ogenerada', 'b3adg_intervenciones_ogenerada_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_idct_departamento_index')) {
                    $table->index('idct_departamento', 'b3adg_intervenciones_idct_departamento_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_idct_escuela_index')) {
                    $table->index('idct_escuela', 'b3adg_intervenciones_idct_escuela_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_ofechafin_index')) {
                    $table->index('ofechafin', 'b3adg_intervenciones_ofechafin_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_istatus_index')) {
                    $table->index('istatus', 'b3adg_intervenciones_istatus_index');
                }
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_ofecha_realizacion_index')) {
                    $table->index('ofecha_realizacion', 'b3adg_intervenciones_ofecha_realizacion_index');
                }
                
                // Índices compuestos para consultas frecuentes
                // Consulta: whereOnivel() + whereOfin() + whereNotIn('istatus', ['B'])
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_onivel_ofin_istatus_index')) {
                    $table->index(['onivel', 'ofin', 'istatus'], 'b3adg_intervenciones_onivel_ofin_istatus_index');
                }
                // Consulta: whereOnivel() + whereOfin()
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_onivel_ofin_index')) {
                    $table->index(['onivel', 'ofin'], 'b3adg_intervenciones_onivel_ofin_index');
                }
                // Consulta: idct_departamento + ofin
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_idct_departamento_ofin_index')) {
                    $table->index(['idct_departamento', 'ofin'], 'b3adg_intervenciones_idct_departamento_ofin_index');
                }
                // Consulta: idct_escuela + ofin
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_idct_escuela_ofin_index')) {
                    $table->index(['idct_escuela', 'ofin'], 'b3adg_intervenciones_idct_escuela_ofin_index');
                }
                // Consulta: onivel + ogenerada + ofin + istatus
                if (!$this->indexExists('b3adg_intervenciones', 'b3adg_intervenciones_onivel_ogenerada_ofin_istatus_index')) {
                    $table->index(['onivel', 'ogenerada', 'ofin', 'istatus'], 'b3adg_intervenciones_onivel_ogenerada_ofin_istatus_index');
                }
            });
        }

        // ============================================
        // TABLA g1organigrama (Organitation)
        // ============================================
        if (Schema::hasTable('g1organigrama')) {
            Schema::table('g1organigrama', function (Blueprint $table) {
                // Índices simples para campos críticos
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_direccion_index')) {
                    $table->index('idct_direccion', 'g1organigrama_idct_direccion_index');
                }
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_departamento_index')) {
                    $table->index('idct_departamento', 'g1organigrama_idct_departamento_index');
                }
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_sector_index')) {
                    $table->index('idct_sector', 'g1organigrama_idct_sector_index');
                }
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_supervicion_index')) {
                    $table->index('idct_supervicion', 'g1organigrama_idct_supervicion_index');
                }
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_escuela_index')) {
                    $table->index('idct_escuela', 'g1organigrama_idct_escuela_index');
                }
                if (!$this->indexExists('g1organigrama', 'g1organigrama_oorden_sub_index')) {
                    $table->index('oorden_sub', 'g1organigrama_oorden_sub_index');
                }
                if (!$this->indexExists('g1organigrama', 'g1organigrama_oorden_dep_index')) {
                    $table->index('oorden_dep', 'g1organigrama_oorden_dep_index');
                }
                
                // Índices compuestos para JOINs frecuentes
                // Consulta: leftJoin con idct_sector + where idct_direccion
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_direccion_idct_sector_index')) {
                    $table->index(['idct_direccion', 'idct_sector'], 'g1organigrama_idct_direccion_idct_sector_index');
                }
                // Consulta: leftJoin con idct_supervicion + where idct_direccion
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_direccion_idct_supervicion_index')) {
                    $table->index(['idct_direccion', 'idct_supervicion'], 'g1organigrama_idct_direccion_idct_supervicion_index');
                }
                // Consulta: leftJoin con idct_escuela + where idct_direccion
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_direccion_idct_escuela_index')) {
                    $table->index(['idct_direccion', 'idct_escuela'], 'g1organigrama_idct_direccion_idct_escuela_index');
                }
                // Consulta: leftJoin con idct_sector + where idct_departamento
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_departamento_idct_sector_index')) {
                    $table->index(['idct_departamento', 'idct_sector'], 'g1organigrama_idct_departamento_idct_sector_index');
                }
                // Consulta: leftJoin con idct_supervicion + where idct_departamento
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_departamento_idct_supervicion_index')) {
                    $table->index(['idct_departamento', 'idct_supervicion'], 'g1organigrama_idct_departamento_idct_supervicion_index');
                }
                // Consulta: leftJoin con idct_escuela + where idct_departamento
                if (!$this->indexExists('g1organigrama', 'g1organigrama_idct_departamento_idct_escuela_index')) {
                    $table->index(['idct_departamento', 'idct_escuela'], 'g1organigrama_idct_departamento_idct_escuela_index');
                }
            });
        }

        // ============================================
        // TABLA g1avance_anexos (Avanceanexos)
        // ============================================
        if (Schema::hasTable('g1avance_anexos')) {
            Schema::table('g1avance_anexos', function (Blueprint $table) {
                if (!$this->indexExists('g1avance_anexos', 'g1avance_anexos_id_acta_index')) {
                    $table->index('id_acta', 'g1avance_anexos_id_acta_index');
                }
            });
        }

        // ============================================
        // TABLA g1centros_trabajo (CentrosTrabajo)
        // ============================================
        if (Schema::hasTable('g1centros_trabajo')) {
            Schema::table('g1centros_trabajo', function (Blueprint $table) {
                // kcvect es la clave primaria, pero puede necesitar índice adicional si se usa en JOINs
                // No se agrega si ya existe como PK
            });
        }

        // ============================================
        // TABLA solicitud_noadeudos (Solicitudnoadeudo) - si existe
        // ============================================
        if (Schema::hasTable('solicitud_noadeudos')) {
            Schema::table('solicitud_noadeudos', function (Blueprint $table) {
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_tipocert_index')) {
                    $table->index('id_tipocert', 'solicitud_noadeudos_id_tipocert_index');
                }
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_dir_index')) {
                    $table->index('id_dir', 'solicitud_noadeudos_id_dir_index');
                }
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_sub_index')) {
                    $table->index('id_sub', 'solicitud_noadeudos_id_sub_index');
                }
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_dep_index')) {
                    $table->index('id_dep', 'solicitud_noadeudos_id_dep_index');
                }
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_acta_index')) {
                    $table->index('id_acta', 'solicitud_noadeudos_id_acta_index');
                }
                // Índice compuesto: id_tipocert + id_dir/id_sub/id_dep
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_tipocert_id_dir_index')) {
                    $table->index(['id_tipocert', 'id_dir'], 'solicitud_noadeudos_id_tipocert_id_dir_index');
                }
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_tipocert_id_sub_index')) {
                    $table->index(['id_tipocert', 'id_sub'], 'solicitud_noadeudos_id_tipocert_id_sub_index');
                }
                if (!$this->indexExists('solicitud_noadeudos', 'solicitud_noadeudos_id_tipocert_id_dep_index')) {
                    $table->index(['id_tipocert', 'id_dep'], 'solicitud_noadeudos_id_tipocert_id_dep_index');
                }
            });
        }

        // ============================================
        // TABLA users - si existe campo id_ct
        // ============================================
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'id_ct') && !$this->indexExists('users', 'users_id_ct_index')) {
                    $table->index('id_ct', 'users_id_ct_index');
                }
                if (Schema::hasColumn('users', 'orol') && !$this->indexExists('users', 'users_orol_index')) {
                    $table->index('orol', 'users_orol_index');
                }
                if (Schema::hasColumn('users', 'onivel') && !$this->indexExists('users', 'users_onivel_index')) {
                    $table->index('onivel', 'users_onivel_index');
                }
            });
        }

        // ============================================
        // TABLA g1titulares (Ctitulares) - si existe
        // ============================================
        if (Schema::hasTable('g1titulares')) {
            Schema::table('g1titulares', function (Blueprint $table) {
                if (Schema::hasColumn('g1titulares', 'id_ct') && !$this->indexExists('g1titulares', 'g1titulares_id_ct_index')) {
                    $table->index('id_ct', 'g1titulares_id_ct_index');
                }
                if (Schema::hasColumn('g1titulares', 'onivel') && !$this->indexExists('g1titulares', 'g1titulares_onivel_index')) {
                    $table->index('onivel', 'g1titulares_onivel_index');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar índices de g1acta
        if (Schema::hasTable('g1acta')) {
            Schema::table('g1acta', function (Blueprint $table) {
                $table->dropIndex('g1acta_oconcluida_index');
                $table->dropIndex('g1acta_id_ctorigen_index');
                $table->dropIndex('g1acta_id_user_index');
                $table->dropIndex('g1acta_id_ct_index');
                $table->dropIndex('g1acta_id_dir_index');
                $table->dropIndex('g1acta_id_sub_index');
                $table->dropIndex('g1acta_id_dep_index');
                $table->dropIndex('g1acta_id_sec_index');
                $table->dropIndex('g1acta_id_sup_index');
                $table->dropIndex('g1acta_created_at_index');
                $table->dropIndex('g1acta_ofecha_fin_a_index');
                $table->dropIndex('g1acta_ofecha_fin_ac_index');
                $table->dropIndex('g1acta_oconcluida_id_ct_index');
                $table->dropIndex('g1acta_oconcluida_created_at_index');
                $table->dropIndex('g1acta_id_ctorigen_oconcluida_index');
            });
        }

        // Eliminar índices de b3adg_intervenciones
        if (Schema::hasTable('b3adg_intervenciones')) {
            Schema::table('b3adg_intervenciones', function (Blueprint $table) {
                $table->dropIndex('b3adg_intervenciones_onivel_index');
                $table->dropIndex('b3adg_intervenciones_ofin_index');
                $table->dropIndex('b3adg_intervenciones_ogenerada_index');
                $table->dropIndex('b3adg_intervenciones_idct_departamento_index');
                $table->dropIndex('b3adg_intervenciones_idct_escuela_index');
                $table->dropIndex('b3adg_intervenciones_ofechafin_index');
                $table->dropIndex('b3adg_intervenciones_istatus_index');
                $table->dropIndex('b3adg_intervenciones_ofecha_realizacion_index');
                $table->dropIndex('b3adg_intervenciones_onivel_ofin_istatus_index');
                $table->dropIndex('b3adg_intervenciones_onivel_ofin_index');
                $table->dropIndex('b3adg_intervenciones_idct_departamento_ofin_index');
                $table->dropIndex('b3adg_intervenciones_idct_escuela_ofin_index');
                $table->dropIndex('b3adg_intervenciones_onivel_ogenerada_ofin_istatus_index');
            });
        }

        // Eliminar índices de g1organigrama
        if (Schema::hasTable('g1organigrama')) {
            Schema::table('g1organigrama', function (Blueprint $table) {
                $table->dropIndex('g1organigrama_idct_direccion_index');
                $table->dropIndex('g1organigrama_idct_departamento_index');
                $table->dropIndex('g1organigrama_idct_sector_index');
                $table->dropIndex('g1organigrama_idct_supervicion_index');
                $table->dropIndex('g1organigrama_idct_escuela_index');
                $table->dropIndex('g1organigrama_oorden_sub_index');
                $table->dropIndex('g1organigrama_oorden_dep_index');
                $table->dropIndex('g1organigrama_idct_direccion_idct_sector_index');
                $table->dropIndex('g1organigrama_idct_direccion_idct_supervicion_index');
                $table->dropIndex('g1organigrama_idct_direccion_idct_escuela_index');
                $table->dropIndex('g1organigrama_idct_departamento_idct_sector_index');
                $table->dropIndex('g1organigrama_idct_departamento_idct_supervicion_index');
                $table->dropIndex('g1organigrama_idct_departamento_idct_escuela_index');
            });
        }

        // Eliminar índices de otras tablas
        if (Schema::hasTable('g1avance_anexos')) {
            Schema::table('g1avance_anexos', function (Blueprint $table) {
                $table->dropIndex('g1avance_anexos_id_acta_index');
            });
        }

        if (Schema::hasTable('solicitud_noadeudos')) {
            Schema::table('solicitud_noadeudos', function (Blueprint $table) {
                $table->dropIndex('solicitud_noadeudos_id_tipocert_index');
                $table->dropIndex('solicitud_noadeudos_id_dir_index');
                $table->dropIndex('solicitud_noadeudos_id_sub_index');
                $table->dropIndex('solicitud_noadeudos_id_dep_index');
                $table->dropIndex('solicitud_noadeudos_id_acta_index');
                $table->dropIndex('solicitud_noadeudos_id_tipocert_id_dir_index');
                $table->dropIndex('solicitud_noadeudos_id_tipocert_id_sub_index');
                $table->dropIndex('solicitud_noadeudos_id_tipocert_id_dep_index');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'id_ct')) {
                    $table->dropIndex('users_id_ct_index');
                }
                if (Schema::hasColumn('users', 'orol')) {
                    $table->dropIndex('users_orol_index');
                }
                if (Schema::hasColumn('users', 'onivel')) {
                    $table->dropIndex('users_onivel_index');
                }
            });
        }

        if (Schema::hasTable('g1titulares')) {
            Schema::table('g1titulares', function (Blueprint $table) {
                if (Schema::hasColumn('g1titulares', 'id_ct')) {
                    $table->dropIndex('g1titulares_id_ct_index');
                }
                if (Schema::hasColumn('g1titulares', 'onivel')) {
                    $table->dropIndex('g1titulares_onivel_index');
                }
            });
        }
    }

    /**
     * Verifica si un índice existe en una tabla
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $connection = DB::connection();
        $databaseName = $connection->getDatabaseName();
        
        $result = DB::select(
            "SELECT COUNT(*) as count 
             FROM information_schema.statistics 
             WHERE table_schema = ? 
             AND table_name = ? 
             AND index_name = ?",
            [$databaseName, $table, $indexName]
        );
        
        return $result[0]->count > 0;
    }
};