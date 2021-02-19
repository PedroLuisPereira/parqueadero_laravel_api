<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Cliente;

class ClienteSeeder extends Seeder
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

        // Creamos un bucle para cubrir 5 fabricantes:
        for ($i=1; $i<=50; $i++)
        {
            // Cuando llamamos al método create del Modelo Fabricante
            // se está creando una nueva fila en la tabla.
            Cliente::create(
                [
                    'numero_documento' => $faker->randomNumber(8),
                    'nombre' => $faker->firstName(),
                    'apellidos' => $faker->lastName(),
                ]
            );
        }
    }
}
