<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Cliente;
use App\Vehiculo;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creamos una instancia de Faker
        $faker = Faker::create();

        // Para cubrir los aviones tenemos que tener en cuenta qué fabricantes tenemos.
        // Para que la clave foránea no nos de problemas.
        // Averiguamos cuantos fabricantes hay en la tabla.
        $cuantos= Cliente::all()->count();

        // Creamos un bucle para cubrir 20 aviones:
        for ($i=1; $i<=50; $i++)
        {
            // Cuando llamamos al método create del Modelo Avion
            // se está creando una nueva fila en la tabla.
            Vehiculo::create(
                [
                 'placa'=>$faker->word(3).'-'.$faker->randomNumber(3),
                 'tipo'=>$faker->randomElement($array = array ('Automovil','Moto','Bicicleta')),
                 'cliente_id'=>$faker->numberBetween(1,$cuantos)
                ]
            );
        }
    }
}
