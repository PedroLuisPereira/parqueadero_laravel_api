<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateParqueaderosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parqueaderos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50);
            $table->string('estado', 50)->default("Disponible");
            $table->string('parqueadero', 50);
            $table->integer('vehiculo_id')->nullable();
            $table->timestamps();
        });


        /* user administrador, contra = 123456 */
        $contra = '$2y$10$xL0qtEQ7wHc.Vi6quWQ61ub6uueZhEBADaNBGywAQpoJeKZx6.RGm';
        DB::insert("INSERT INTO `users` (`id`, `name`, `email`,`password`,`rol`,`estado`)
        VALUES ('1', 'Pedro Luis', 'druped@hotmail.com','$contra','Administrador','Activo');");
        
        /*tarifas*/
        DB::insert("INSERT INTO `tarifas` (`id`) VALUES ('1');");

        /* automoviles*/
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('2', 'Automovil', 'A2');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('1', 'Automovil', 'A1');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('3', 'Automovil', 'A3');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('4', 'Automovil', 'A4');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('5', 'Automovil', 'A5');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('6', 'Automovil', 'A6');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('7', 'Automovil', 'A7');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('8', 'Automovil', 'A8');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('9', 'Automovil', 'A9');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('10', 'Automovil', 'A10');");

        /*bicicletas*/
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('11', 'Bicicleta', 'B1');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('12', 'Bicicleta', 'B2');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('13', 'Bicicleta', 'B3');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('14', 'Bicicleta', 'B4');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('15', 'Bicicleta', 'B5');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('16', 'Bicicleta', 'B6');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('17', 'Bicicleta', 'B7');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('18', 'Bicicleta', 'B8');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('19', 'Bicicleta', 'B9');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('20', 'Bicicleta', 'B10')");

        /*motos*/
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('21', 'Moto', 'M1');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('22', 'Moto', 'M2');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('23', 'Moto', 'M3');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('24', 'Moto', 'M4');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('25', 'Moto', 'M5');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('26', 'Moto', 'M6');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('27', 'Moto', 'M7');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('28', 'Moto', 'M8');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('29', 'Moto', 'M9');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('30', 'Moto', 'M10');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('31', 'Moto', 'M11');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('32', 'Moto', 'M12');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('33', 'Moto', 'M13');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('34', 'Moto', 'M14');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('35', 'Moto', 'M15');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('36', 'Moto', 'M16');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('37', 'Moto', 'M17');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('38', 'Moto', 'M18');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('39', 'Moto', 'M19');");
        DB::insert("INSERT INTO `parqueaderos` (`id`, `tipo`, `parqueadero`) VALUES ('40', 'Moto', 'M20');");
    }

    /**)
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parqueaderos');
    }
}
