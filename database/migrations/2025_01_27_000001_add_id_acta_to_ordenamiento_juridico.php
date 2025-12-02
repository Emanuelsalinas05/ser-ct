<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('g1ordenamiento_juridico')) {
            Schema::table('g1ordenamiento_juridico', function (Blueprint $table) {
                if (!Schema::hasColumn('g1ordenamiento_juridico', 'id_acta')) {
                    $table->unsignedBigInteger('id_acta')->nullable()->after('id_ct');
                    $table->index('id_acta', 'g1ordenamiento_juridico_id_acta_index');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('g1ordenamiento_juridico')) {
            Schema::table('g1ordenamiento_juridico', function (Blueprint $table) {
                if (Schema::hasColumn('g1ordenamiento_juridico', 'id_acta')) {
                    $table->dropIndex('g1ordenamiento_juridico_id_acta_index');
                    $table->dropColumn('id_acta');
                }
            });
        }
    }
};

