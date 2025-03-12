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
        Schema::create('g1plantilla_personal', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_acta'); 
            $table->unsignedBigInteger('id_ct');
            $table->string('oclave_puesto')->nullable(true);
            $table->string('onombre_puesto')->nullable(true);
            $table->string('onivelrango')->nullable(true);
            $table->Integer('ototalplazas')->nullable(true) ;
            $table->Integer('ototalocupadas')->nullable(true) ;
            $table->Integer('ototalvacantes')->nullable(true) ;
            $table->decimal('osueldo_ind', 10,2)->nullable(true) ;
            $table->decimal('osueldo_total', 20,2)->nullable(true) ;
            $table->Integer('oactual')->default(0) ;
            $table->Char('status', 1)->default('A') ;
            $table->Integer('oanio')->nullable(true) ; 
            $table->Integer('ofinalizacion')->default(0);       
            $table->timestamps();

            $table->foreign('id_ct')->references('id')->on('g1centros_trabajo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g1plantilla_personal');
    }
};
