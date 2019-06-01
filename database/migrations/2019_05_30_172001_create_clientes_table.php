<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('cliente_id');
            $table->string('nome', 255);
            $table->string('email', 150)->unique();
            $table->string('cpf', 14)->nullable();
            $table->string('cep', 9);
            $table->string('endereco', 250);
            $table->integer('numero_casa')->nullable();
            $table->string('bairro', 150);
            $table->string('cidade', 150);
            $table->char('estado', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
