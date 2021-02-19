<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('numero_documento', 50)->unique();
            $table->string('nombre', 50);
            $table->string('apellidos', 50);
            $table->timestamps();

             // # Si queremos volver a poner la base de datos en su estado inicial podemos hacerlo con:
            // php artisan migrate:refresh
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
