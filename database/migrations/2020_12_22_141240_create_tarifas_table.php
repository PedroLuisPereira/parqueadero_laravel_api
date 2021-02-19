<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->double('minuto_autos', 12, 2)->default(0);
            $table->double('minuto_bicicletas', 12, 2)->default(0);
            $table->double('minuto_motos', 12, 2)->default(0);
            $table->double('descuento', 8, 2)->default(0);
            $table->integer('minutos')->default(0);
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
        Schema::dropIfExists('tarifas');
    }
}
