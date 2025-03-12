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
        Schema::create('g1avance_anexos', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_acta'); 
            $table->unsignedBigInteger('id_ct');

            $table->Integer('omarco_juridico_d')->default(0) ;
            $table->Integer('omarco_juridico_a')->default(0) ;
            $table->Integer('orecursos_humanos_d')->default(0) ;
            $table->Integer('oplantilla_personal_a')->default(0) ;
            $table->Integer('oplantilla_comisionados_a')->default(0) ;
            $table->Integer('osituacion_recursos_materiales_d')->default(0) ;
            $table->Integer('oinventario_bienes_a')->default(0) ;
            $table->Integer('oinventario_almacen_a')->default(0) ;
            $table->Integer('orelacion_bienes_custodia_a')->default(0) ;
            $table->Integer('osituacion_tics_d')->default(0) ;
            $table->Integer('oinventario_equipo_a')->default(0) ;
            $table->Integer('oarchivos_d')->default(0) ;
            $table->Integer('orelacion_archivos_a')->default(0) ;
            $table->Integer('orelacion_archivos_historico_a')->default(0) ;
            $table->Integer('orelacion_documentos_noconvencionles_a')->default(0) ;
            $table->Integer('ocertificados_no_adeudos_d')->default(0) ;
            $table->Integer('ocertificados_no_adeudo_a')->default(0) ;
            $table->Integer('oinforme_gestion_d')->default(0) ;
            $table->Integer('oinforme_gestion_a')->default(0) ;
            $table->Integer('oinforme_compromisos_a')->default(0) ;
            $table->Integer('ootros_hechos_d')->default(0) ;
            $table->Integer('ootros_hechos_a')->default(0) ;

            $table->Integer('ofinalizacion')->default(0) ;
            $table->date('ofecha_er')->nullable(true);
            $table->Char('status', 1)->default('A') ;
            $table->Integer('oactual')->default(0) ;
            $table->Integer('oanio')->nullable(true) ;                   
            $table->timestamps();

            $table->foreign('id_acta')->references('id')->on('g1acta')->onDelete('cascade');
           // $table->foreign('id_ct')->references('id')->on('g1centros_trabajo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g1avance_anexos');
    }
};
