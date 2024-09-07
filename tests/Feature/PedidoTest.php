<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cuenta;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_pedido()
    {
        $cuenta = Cuenta::factory()->create();
        
        $response = $this->postJson('/api/pedidos', [
            'idCuenta' => $cuenta->idCuenta,
            'producto' => 'Producto de prueba',
            'cantidad' => 1,
            'valor' => 2.00,
            'total' => 3.00,
        ]);
        

        $response->assertStatus(201)
                 ->assertJson([
                    'idCuenta' => $cuenta->idCuenta,
                    'producto' => 'Producto de prueba',
                    'cantidad' => 1,
                    'valor' => 2,
                    'total' => 3,
                 ]);
    }

    public function test_actualizar_pedido()
    {
        $pedido = Pedido::factory()->create();

        $response = $this->putJson("/api/pedidos/{$pedido->idPedido}", [
            'producto' => 'Producto actualizado',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'producto' => 'Producto actualizado',
                 ]);
    }

    public function test_eliminar_pedido()
    {
        $pedido = Pedido::factory()->create();
        
        $response = $this->deleteJson("/api/pedidos/{$pedido->idPedido}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('pedidos', ['id' => $pedido->id]);
    }
}