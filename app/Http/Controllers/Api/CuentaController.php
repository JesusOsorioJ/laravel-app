<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="CRUD: cuentas y pedidos",
 *     version="1.0.0",
 *     description=" La API incluye funcionalidades CRUD para gestionar cuentas y pedidos, y utiliza un servidor Node.js para manejar las notificaciones en tiempo real y almacenar los pedidos en MongoDB Atlas."
 * )
*/

class CuentaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cuentas",
     *     summary="Obtener lista de cuentas",
     *     tags={"Cuentas"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Cuenta")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Cuenta::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/cuentas",
     *     summary="Crear una nueva cuenta",
     *     tags={"Cuentas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cuenta")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cuenta creada",
     *         @OA\JsonContent(ref="#/components/schemas/Cuenta")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:cuentas,email',
            'telefono' => 'required|string|max:15',
        ]);
    
        $cuenta = Cuenta::create($request->all());
        return response()->json($cuenta, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/cuentas/{id}",
     *     summary="Obtener una cuenta por ID",
     *     tags={"Cuentas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cuenta encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Cuenta")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta no encontrada"
     *     )
     * )
     */
    public function show($idCuenta)
    {
        $cuenta = Cuenta::find($idCuenta);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta no encontrada'], 404);
        }
        return response()->json($cuenta, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/cuentas/{id}",
     *     summary="Actualizar una cuenta",
     *     tags={"Cuentas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Cuenta")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cuenta actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Cuenta")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $cuenta = Cuenta::find($id);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta no encontrada'], 404);
        }
        $cuenta->update($request->all());
        return response()->json($cuenta, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/cuentas/{id}",
     *     summary="Eliminar una cuenta",
     *     tags={"Cuentas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Cuenta eliminada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $cuenta = Cuenta::find($id);
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta no encontrada'], 404);
        }
        $cuenta->delete();
        return response()->json(null, 204);
    }
}