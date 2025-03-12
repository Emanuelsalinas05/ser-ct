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
        Schema::create('ordenamiento_juridico', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_anexo'); 
            $table->Integer('onprogresivo')->nullable(true) ; 
            $table->string('odenominacion_juridica')->nullable(true);
            $table->string('omedio_oficial_publicacion')->nullable(true);
            $table->string('ofecha_publicacion')->nullable(true);
            $table->string('ourl_publicacion')->nullable(true);
            $table->Char('status', 1)->default('A') ;
            $table->timestamps();

            $table->foreign('id_anexo')->references('id')->on('g1anexo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenamiento_juridico');
    }
};
