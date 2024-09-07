<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pedidos",
     *     summary="Obtener lista de pedidos",
     *     tags={"Pedidos"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pedido")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Pedido::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pedidos",
     *     summary="Crear un nuevo pedido",
     *     tags={"Pedidos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Pedido")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pedido creado",
     *         @OA\JsonContent(ref="#/components/schemas/Pedido")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta no encontrada"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $cuenta = Cuenta::find($request->idCuenta);
        
        if (!$cuenta) {
            return response()->json(['message' => 'Cuenta no encontrada'], 404);
        }

        $pedido = Pedido::create($request->all());

        // Enviar notificación por websocket a servidor Node.js
        $pedidoConCuenta = [
            'cuenta' => $cuenta,
            'pedido' => $pedido
        ];

        try {
            Http::timeout(5)->post('http://localhost:3000/send-notification', $pedidoConCuenta);
        } catch (\Exception $e) {
            Log::error('No se pudo enviar la notificación: ' . $e->getMessage());
        }

        return response()->json($pedido, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pedido/{id}",
     *     summary="Obtener un pedido por ID",
     *     tags={"Pedidos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pedido encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Pedido")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrada'], 404);
        }
        return response()->json($pedido, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/pedidos/{id}",
     *     summary="Actualizar un pedido",
     *     tags={"Pedidos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Pedido")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pedido actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Pedido")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        $pedido->update($request->all());
        return response()->json($pedido, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/pedidos/{id}",
     *     summary="Eliminar un pedido",
     *     tags={"Pedidos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Pedido eliminado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pedido no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        $pedido->delete();
        return response()->json(null, 204);
    }
}