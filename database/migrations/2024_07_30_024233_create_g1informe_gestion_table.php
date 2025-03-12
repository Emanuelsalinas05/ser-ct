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
        Schema::create('g1informe_gestion', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_acta'); 
            
            $table->longText('oi')->nullable(true);
            $table->longText('oii')->nullable(true);
            $table->longText('oiii')->nullable(true);
            $table->longText('oiv')->nullable(true);

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
        Schema::dropIfExists('g1informe_gestion');
    }
};
