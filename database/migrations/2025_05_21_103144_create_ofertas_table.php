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
            $table->decimal('valor_a_pagar', total: 10, places: 2);
            $table->decimal('valor_solicitado', total: 10, places: 2);
            $table->decimal('valor_parcela', total: 10, places: 2);
            $table->decimal('taxa_juros', total: 5, places: 4);
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
