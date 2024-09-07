<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('idPedido');
            $table->unsignedBigInteger('idCuenta');
            $table->string('producto');
            $table->integer('cantidad');
            $table->decimal('valor', 8, 2);
            $table->decimal('total', 8, 2);
            $table->timestamps();

             // Definir la clave foránea
             $table->foreign('idCuenta')->references('idCuenta')->on('cuentas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}