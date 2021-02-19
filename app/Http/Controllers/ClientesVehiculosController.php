<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClientesVehiculosController extends Controller
{

    // Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
	// pero solamente para los métodos de crear, actualizar y borrar.
	public function __construct()
	{
		//$this->middleware('auth.basic',['only'=>['store','update','destroy']]);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idCliente)
    {
        // Devolverá todos los aviones.
        //return "Mostrando los aviones del fabricante con Id $idFabricante";
        $cliente = Cliente::find($idCliente);

        if (!$cliente) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un fabricante con ese código.'])], 404);
        }
        // Activamos la caché de los resultados.
		// Como el closure necesita acceder a la variable $ fabricante tenemos que pasársela con use($fabricante)
		// Para acceder a los modelos no haría falta puesto que son accesibles a nivel global dentro de la clase.
		//  Cache::remember('tabla', $minutes, function()
		$vehiculoCliente=Cache::remember('claveVehiculos',2, function() use ($cliente)
		{
			// Caché válida durante 2 minutos.
			return $cliente->vehiculos()->get();
		});

		// Respuesta con caché:
		return response()->json(['status'=>'ok','data'=>$vehiculoCliente],200);
        // Respuesta sin caché:
        //return response()->json(['status' => 'ok', 'data' => $cliente->vehiculos()->get()], 200);
        //return response()->json(['status'=>'ok','data'=>$fabricante->aviones],200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idCliente)
    {
        /* Necesitaremos el fabricante_id que lo recibimos en la ruta
		 #Serie (auto incremental)
		Modelo
		Longitud
		Capacidad
		Velocidad
		Alcance */

        // Primero comprobaremos si estamos recibiendo todos los campos.
        if (!$request->input('placa') || !$request->input('tipo')) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan datos necesarios para el proceso de alta.'])], 422);
        }

        // Buscamos el Fabricante.
        $cliente = Cliente::find($idCliente);

        // Si no existe el fabricante que le hemos pasado mostramos otro código de error de no encontrado.
        if (!$cliente) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un fabricante con ese código.'])], 404);
        }

        // Si el fabricante existe entonces lo almacenamos.
        // Insertamos una fila en Aviones con create pasándole todos los datos recibidos.
        $nuevoVehiculo = $cliente->vehiculos()->create($request->all());

        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        return response()->json(['data' => $nuevoVehiculo], 201)->header('Location',  url('/api/v1/') . '/vehiculos/' . $nuevoVehiculo->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idFabricante, $idAvion)
    {
        return "Se muestra avión $idAvion del fabricante $idFabricante";
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idCliente, $idVehiculo)
    {
        // Comprobamos si el fabricante que nos están pasando existe o no.
        $cliente = Cliente::find($idCliente);

        // Si no existe ese fabricante devolvemos un error.
        if (!$cliente) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un fabricante con ese código.'])], 404);
        }

        // El fabricante existe entonces buscamos el avion que queremos editar asociado a ese fabricante.
        $vehiculo = $cliente->vehiculos()->find($idVehiculo);

        // Si no existe ese avión devolvemos un error.
        if (!$vehiculo) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un avión con ese código asociado al fabricante.'])], 404);
        }


        // Listado de campos recibidos teóricamente.
        $placa = $request->input('placa');
        $tipo = $request->input('tipo');

        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        /*  Modelo      Longitud        Capacidad       Velocidad       Alcance */
        if ($request->method() === 'PATCH') {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;

            // Actualización parcial de campos.
            if ($placa) {
                $vehiculo->placa = $placa;
                $bandera = true;
            }

            if ($tipo) {
                $vehiculo->tipo = $tipo;
                $bandera = true;
            }


            if ($bandera) {
                // Almacenamos en la base de datos el registro.
                $vehiculo->save();
                return response()->json(['status' => 'ok', 'data' => $vehiculo], 200);
            } else {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors' => array(['code' => 304, 'message' => 'No se ha modificado ningún dato del avión.'])], 304);
            }
        }

        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$placa || !$tipo) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan valores para completar el procesamiento.'])], 422);
        }

        $vehiculo->placa = $placa;
        $vehiculo->tipo = $tipo;
        // Almacenamos en la base de datos el registro.
        $vehiculo->save();

        return response()->json(['status' => 'ok', 'data' => $vehiculo], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idCliente, $idVehiculo)
    {
        // Comprobamos si el fabricante que nos están pasando existe o no.
        $cliente = Cliente::find($idCliente);

        // Si no existe ese fabricante devolvemos un error.
        if (!$cliente) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un fabricante con ese código.'])], 404);
        }

        // El fabricante existe entonces buscamos el avion que queremos borrar asociado a ese fabricante.
        $vehiculo = $cliente->vehiculos()->find($idVehiculo);

        // Si no existe ese avión devolvemos un error.
        if (!$vehiculo) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un avión con ese código asociado a ese fabricante.'])], 404);
        }

        // Procedemos por lo tanto a eliminar el avión.
        $vehiculo->delete();

        // Se usa el código 204 No Content – [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (como una petición DELETE)
        // Este código 204 no devuelve body así que si queremos que se vea el mensaje tendríamos que usar un código de respuesta HTTP 200.
        return response()->json(['code' => 204, 'message' => 'Se ha eliminado el avión correctamente.'], 204);
    }
}
