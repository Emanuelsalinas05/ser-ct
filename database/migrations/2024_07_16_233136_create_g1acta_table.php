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
        Schema::create('g1acta', function (Blueprint $table) {
            $table->increments('id')->unsignedBigInteger();
            $table->unsignedBigInteger('id_tipoacta'); 
            $table->unsignedBigInteger('id_ct'); 
            $table->string('oct_a')->nullable(true);
            $table->string('onombre_ct_a')->nullable(true);
            $table->string('olugar_a')->nullable(true);
            $table->string('ohora_inicio_a')->nullable(true);
            $table->date('ofecha_inicio_a')->nullable(true);
            $table->string('odomicilio_ct_a')->nullable(true);
            $table->string('onombre_entrega_a')->nullable(true);
            $table->string('ocargo_entrega_a')->nullable(true);
            $table->string('oidentificacion_a')->nullable(true);
            $table->string('onombre_recibe_a')->nullable(true);
            $table->string('ocargo_recibe_a')->nullable(true);
            $table->string('onombre_testigo_a')->nullable(true);
            $table->string('oct_testigo_a')->nullable(true);
            $table->string('ocargo_testigo_a')->nullable(true);
            $table->string('orepresentante_a')->nullable(true);
            $table->string('orfc_orepresentante_contraloria_a')->nullable(true);
            $table->string('orepresentante_contraloria_a')->nullable(true);
            $table->string('ooficio_designacion_er_a')->nullable(true);
            $table->string('ofecha_ofocio_designacion_er_a')->nullable(true);       
            $table->longText('ohechos_a')->nullable(true);
            $table->Integer('oanexos_total_a')->nullable(true) ; 
            $table->string('ohora_fin_a')->nullable(true);

            $table->string('olugar_ac')->nullable(true);
            $table->string('ohora_inicio_ac')->nullable(true);
            $table->date('ofecha_inicio_ac')->nullable(true);
            $table->string('oct_ac')->nullable(true);
            $table->string('onombre_ct_ac')->nullable(true);
            $table->string('odepartamento_ac')->nullable(true);
            $table->string('odomicilio_ct_ac')->nullable(true);
            $table->Integer('otelefono_ct_ac')->nullable(true) ; 
            $table->string('orfc_recibe_ac')->nullable(true);
            $table->string('onombre_recibe_ac')->nullable(true);
            $table->string('orfc_orepresentante_contraloria_ac')->nullable(true);
            $table->string('orepresentante_contraloria_ac')->nullable(true);
            $table->string('orfc_testigo1_ac')->nullable(true);
            $table->string('onombre_testigo1_ac')->nullable(true);
            $table->string('orfc_testigo2_ac')->nullable(true);
            $table->string('onombre_testigo2_ac')->nullable(true);
            $table->string('oidentificacion_ac')->nullable(true);
            $table->longText('ohechos_ac')->nullable(true);
            $table->Integer('oanexos_total_ac')->nullable(true) ; 
            $table->longText('omanifestacion_recibe_ac')->nullable(true);
            $table->longText('omanifiestan_representante_organo_ac')->nullable(true);
            $table->string('ohora_fin_ac')->nullable(true);
            $table->date('ofecha_fin_ac')->nullable(true);
            
            $table->Char('status', 1)->default('A') ;
            $table->Integer('oactual')->default(0) ;
            $table->Integer('oanio')->nullable(true) ;                   
            $table->timestamps();

            $table->foreign('id_tipoacta')->references('id')->on('g1tipoacta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('g1acta');
    }
};
