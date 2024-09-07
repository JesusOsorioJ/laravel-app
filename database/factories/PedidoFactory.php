<?php

namespace Database\Factories;

use App\Models\Cuenta;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition()
    {
        return [
            'idCuenta' => Cuenta::factory(), // Relación con el modelo Cuenta
            'producto' => $this->faker->sentence(),
            'cantidad' => $this->faker->numberBetween(1, 10),
            'valor' => $this->faker->randomFloat(2, 1, 100),
            'total' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
