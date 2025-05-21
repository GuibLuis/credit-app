<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_consulta');
            $table->foreign('id_consulta')->references('id')->on('consultas')->onDelete('cascade');
            $table->string('instituicao_financeira', length: 100);
            $table->string('modalidade_credito', length: 100);
            $table->float('valor_a_pagar');
            $table->float('valor_solicitado');
            $table->float('valor_parcela');
            $table->float('taxa_juros');
            $table->integer('qnt_parcelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ofertas');
    }
};
