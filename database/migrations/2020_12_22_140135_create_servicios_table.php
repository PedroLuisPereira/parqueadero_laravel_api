<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->dateTime('hora_entrada', $precision = 0);
            $table->dateTime('hora_salida', $precision = 0)->default(null);
            $table->integer('minutos')->default(0);
            $table->double('valor_minuto', 12, 2)->default(0);
            $table->double('total', 12, 2)->default(0);
            $table->string('estado', 50);
            $table->string('parqueadero', 50);
            $table->unsignedBigInteger('vehiculo_id');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
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
        Schema::dropIfExists('servicios');
    }
}
