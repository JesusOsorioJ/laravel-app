<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Pedido",
 *     type="object",
 *     title="Pedido",
 *     required={"idCuenta", "producto", "cantidad", "valor", "total"},
 *     @OA\Property(
 *         property="idPedido",
 *         type="integer",
 *         description="ID del pedido"
 *     ),
 *     @OA\Property(
 *         property="idCuenta",
 *         type="integer",
 *         description="ID de la cuenta asociada"
 *     ),
 *     @OA\Property(
 *         property="producto",
 *         type="string",
 *         description="Nombre del producto"
 *     ),
 *     @OA\Property(
 *         property="cantidad",
 *         type="integer",
 *         description="Cantidad del producto"
 *     ),
 *     @OA\Property(
 *         property="valor",
 *         type="number",
 *         description="Valor del producto"
 *     ),
 *     @OA\Property(
 *         property="total",
 *         type="number",
 *         description="Total de pedido"
 *     )
 * )
 */
class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['idCuenta', 'producto', 'cantidad', 'valor', 'total'];
    protected $primaryKey = 'idPedido'; 

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'idCuenta');
    }
}
