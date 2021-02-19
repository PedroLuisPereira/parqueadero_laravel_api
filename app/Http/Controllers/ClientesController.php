<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
// Activamos el uso de las funciones de caché.
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;


class ClientesController extends Controller
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
    public function index()
    {
        // return "En el index de Fabricante.";
        // Devolvemos un JSON con todos los fabricantes.
        // return Fabricante::all();

        // Caché se actualizará con nuevos datos cada 15 segundos.
        // cachefabricantes es la clave con la que se almacenarán 
        // los registros obtenidos de Fabricante::all()
        // El segundo parámetro son los minutos.
        $clientes = Cache::remember('cacheclientes', 15 / 60, function () {
            // Para la paginación en Laravel se usa "Paginator"
            // En lugar de devolver 
            // return Fabricante::all();
            // devolveremos return Fabricante::paginate();
            // 
            // Este método paginate() está orientado a interfaces gráficas. 
            // Paginator tiene un método llamado render() que permite construir
            // los enlaces a página siguiente, anterior, etc..
            // Para la API RESTFUL usaremos un método más sencillo llamado simplePaginate() que
            // aporta la misma funcionalidad
            return Cliente::simplePaginate(10);  // Paginamos cada 10 elementos.

        });

        // Para devolver un JSON con código de respuesta HTTP sin caché.
        // return response()->json(['status'=>'ok', 'data'=>Fabricante::all()],200);

        // Devolvemos el JSON usando caché.
        // return response()->json(['status'=>'ok', 'data'=>$fabricantes],200);

        // Con la paginación lo haremos de la siguiente forma:
        // Devolviendo también la URL a l
        return response()->json(['status' => 'ok', 'siguiente' => $clientes->nextPageUrl(), 'anterior' => $clientes->previousPageUrl(), 'data' => $clientes->items()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Método llamado al hacer un POST.
        // Comprobamos que recibimos todos los campos.
        if (!$request->input('numero_documento') || !$request->input('nombre') || !$request->input('apellidos')) {
            // NO estamos recibiendo los campos necesarios. Devolvemos error.
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan datos necesarios para procesar el alta.'])], 422);
        }

        // Insertamos los datos recibidos en la tabla.
        $nuevoCliente = Cliente::create($request->all());

        // Devolvemos la respuesta Http 201 (Created) + los datos del nuevo fabricante + una cabecera de Location + cabecera JSON
        // $respuesta = Response::make(json_encode(['data' => $nuevoCliente]), 201)
        //     ->header('Location', 'http://www.dominio.local/clientes/' . $nuevoCliente->id)
        //     ->header('Content-Type', 'application/json');
        // return $respuesta;

        return response()->json(['data' => $nuevoCliente], 201)
            ->header('Location',  url('/api/v1/') . '/clientes/' . $nuevoCliente->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Corresponde con la ruta /fabricantes/{fabricante}
        // Buscamos un fabricante por el ID.
        $cliente = Cliente::find($id);

        // Chequeamos si encontró o no el c$cliente
        if (!$cliente) {
            // Se devuelve un array errors con los errores detectados y código 404
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un c$cliente con ese código.'])], 404);
        }

        // Devolvemos la información encontrada.
        return response()->json(['status' => 'ok', 'data' => $cliente], 200);
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Vamos a actualizar un fabricante.
        // Comprobamos si el fabricante existe. En otro caso devolvemos error.
        $cliente = Cliente::find($id);

        // Si no existe mostramos error.
        if (!$cliente) {
            // Devolvemos error 404.
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un fabricante con ese código.'])], 404);
        }

        // Almacenamos en variables para facilitar el uso, los campos recibidos.
        $numero_documento = $request->input('numero_documento');
        $nombre = $request->input('nombre');
        $apellidos = $request->input('apellidos');

        // Comprobamos si recibimos petición PATCH(parcial) o PUT (Total)
        if ($request->method() == 'PATCH') {
            $bandera = false;

            // Actualización parcial de datos.
            if ($numero_documento != null && $numero_documento != '') {
                $cliente->numero_documento = $numero_documento;
                $bandera = true;
            }

            // Actualización parcial de datos.
            if ($nombre != null && $nombre != '') {
                $cliente->nombre = $nombre;
                $bandera = true;
            }

            // Actualización parcial de datos.
            if ($apellidos != null && $apellidos != '') {
                $cliente->apellidos = $apellidos;
                $bandera = true;
            }

            if ($bandera) {
                // Grabamos el c$cliente.
                $cliente->save();

                // Devolvemos un código 200.
                return response()->json(['status' => 'ok', 'data' => $cliente], 200);
            } else {
                // Devolvemos un código 304 Not Modified.
                return response()->json(['errors' => array(['code' => 304, 'message' => 'No se ha modificado ningún dato del fabricante.'])], 304);
            }
        }

        // Método PUT actualizamos todos los campos.
        // Comprobamos que recibimos todos.
        if (!$numero_documento || !$nombre || !$apellidos) {
            // Se devuelve código 422 Unprocessable Entity.
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan valores para completar el procesamiento.'])], 422);
        }

        // Actualizamos los 3 campos:
        $cliente->numero_documento = $numero_documento;
        $cliente->nombre = $nombre;
        $cliente->apellidos = $apellidos;

        // Grabamos el c$cliente
        $cliente->save();
        return response()->json(['status' => 'ok', 'data' => $cliente], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Borrado de un fabricante.
        // Ejemplo: /fabricantes/89 por DELETE
        // Comprobamos si el fabricante existe o no.
        $cliente = Cliente::find($id);

        if (!$cliente) {
            // Devolvemos error codigo http 404
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra el cli$cliente con ese código.'])], 404);
        }

        // Borramos el $cliente y devolvemos código 204
        // 204 significa "No Content".
        // Este código no muestra texto en el body.
        // Si quisiéramos ver el mensaje devolveríamos
        // un código 200.
        // Antes de borrarlo comprobamos si tiene aviones y si es así
        // sacamos un mensaje de error.
        // $aviones = $cliente->aviones()->get();
        $vehiculos = $cliente->vehiculos;

        if (sizeof($vehiculos) > 0) {
            // Si quisiéramos borrar todos los aviones del cliente sería:
            // $cliente->aviones->delete();

            // Devolvemos un código 409 Conflict. 
            return response()->json(['errors' => array(['code' => 409, 'message' => 'Este cli$cliente posee aviones y no puede ser eliminado.'])], 409);
        }

        // Eliminamos el cliente si no tiene aviones.
        $cliente->delete();

        // Se devuelve código 204 No Content.
        return response()->json(['code' => 204, 'message' => 'Se ha eliminado correctamente el cli$cliente.'], 204);
    }
}
