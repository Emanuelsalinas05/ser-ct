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
        Schema::create('g1archivos_tramite', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_acta'); 
            
            $table->string('onombre_documento')->nullable(true);
            $table->string('ourl')->nullable(true);
            $table->string('oarchivo_adjunto')->nullable(true);
            
            $table->string('oclave_expediente')->nullable(true);
            $table->string('onombre_expediente')->nullable(true);
            $table->Integer('onum_legajos')->default(0);
            $table->Integer('onum_documentos')->default(0);
            $table->date('ofecha_primero')->nullable(true);
            $table->date('ofecha_ultimo')->nullable(true);

            $table->Char('status', 1)->default('A') ;
            $table->Integer('oanio')->nullable(true) ; 
            $table->timestamps();

            $table->foreign('id_acta')->references('id')->on('g1acta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g1archivos_tramite');
    }
};
