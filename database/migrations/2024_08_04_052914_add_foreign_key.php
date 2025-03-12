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
        Schema::table('g1documentos_bibliohemerograficos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ct'); 
            $table->foreign('id_ct')->references('id')->on('g1centros_trabajo')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('g1documentos_bibliohemerograficos', function (Blueprint $table) {
            //
        });
    }
};
