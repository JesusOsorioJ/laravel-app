<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Cuenta",
 *     type="object",
 *     title="Cuenta",
 *     required={"nombre", "email", "telefono"},
 *     @OA\Property(
 *         property="idCuenta",
 *         type="integer",
 *         description="ID de la cuenta"
 *     ),
 *     @OA\Property(
 *         property="nombre",
 *         type="string",
 *         description="Nombre de la cuenta"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email de la cuenta"
 *     ),
 *     @OA\Property(
 *         property="telefono",
 *         type="string",
 *         description="Teléfono de la cuenta"
 *     )
 * )
 */
class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'telefono'];
    protected $primaryKey = 'idCuenta'; 

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'idCuenta');
    }
}
