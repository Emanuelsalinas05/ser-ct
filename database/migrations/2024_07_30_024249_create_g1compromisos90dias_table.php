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
        Schema::create('g1compromisos90dias', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_acta'); 
            
            $table->longText('odescripcion_asunto')->nullable(true);
            $table->string('oresponsable')->nullable(true);
            $table->longText('oacciones_realizar')->nullable(true);
            $table->string('olugar')->nullable(true);
            $table->date('ofecha')->nullable(true);
            $table->char('ohora', 10)->nullable(true);

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
        Schema::dropIfExists('g1compromisos90dias');
    }
};
