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
        Schema::create('g1documentos', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_anexo'); 
            $table->unsignedBigInteger('onum_documento'); 
            $table->string('odocumento')->nullable(true);
            $table->string('ourl_documentos')->nullable(true);
            $table->string('oavance_documento')->nullable(true);
            $table->longText('odescripcion')->nullable(true);
            $table->Char('status', 1)->default('A') ;
            $table->Integer('oanio')->nullable(true) ;                   
            $table->timestamps();

            $table->foreign('id_anexo')->references('id')->on('g1anexos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
