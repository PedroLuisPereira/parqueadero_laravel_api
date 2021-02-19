<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//https://manuais.iessanclemente.net/index.php/LARAVEL_Framework_-_Tutorial_01_-_Creaci%C3%B3n_de_API_RESTful_(actualizado)

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Versionado de la API.
Route::prefix('v1')->group(function () {
    // resource recibe nos parámetros(URI del recurso, Controlador que gestionará las peticiones)
    Route::resource('/clientes', 'ClientesController', ['except' => ['edit', 'create']]);   // Todos los métodos menos Edit que mostraría un formulario de edición.

    // Si queremos dar  la funcionalidad de ver todos los aviones tendremos que crear una ruta específica.
    // Pero de aviones solamente necesitamos solamente los métodos index y show.
    // Lo correcto sería hacerlo así:
    Route::resource('/vehiculos', 'VehiculosController', ['only' => ['index', 'show']]);

    // Como la clase principal es fabricantes y un avión no se puede crear si no le indicamos el fabricante,
    // entonces necesitaremos crear lo que se conoce como  "Recurso Anidado" de fabricantes con aviones.
    // Definición del recurso anidado:
    Route::resource('/clientes.vehiculos', 'ClientesVehiculosController', ['except' => ['show', 'edit', 'create']]);
});
