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
        Schema::create('g1plantilla_comisionados', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_acta'); 
            $table->unsignedBigInteger('id_ct');

            $table->string('onombre_servidor')->nullable(true);
            $table->string('ounidad_adscripcion')->nullable(true);
            $table->string('ocomisionado_act')->nullable(true);
            $table->date('operiodoinicio')->nullable(true);
            $table->date('operiodofinal')->nullable(true);
            $table->string('ooficio_autorizacion')->nullable(true);
            $table->longText('oobservaciones')->nullable(true);
            $table->Char('status', 1)->default('A') ;
            $table->Integer('oanio')->nullable(true) ; 
            $table->timestamps();

            $table->foreign('id_ct')->references('id')->on('g1centros_trabajo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g1plantilla_comisionados');
    }
};
