<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('pedido_id');
            $table->unsignedBigInteger('cliente_id');
            $table->set('status', ['reservado', 'pago', 'cancelado']);
            $table->timestamps();

            // Foreign key
            $table->foreign('cliente_id')->references('cliente_id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['cliente_id']);
        
        Schema::dropIfExists('pedidos');
    }
}
