<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cuenta;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CuentaTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_cuenta()
    {
        $response = $this->postJson('/api/cuentas', [
            'nombre' => 'John Doe',
            'email' => 'johndoe@example.com',
            'telefono' => '123456789'
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'nombre' => 'John Doe',
                     'email' => 'johndoe@example.com',
                     'telefono' => '123456789',
                 ]);
    }

    public function test_obtener_lista_de_cuentas()
    {
        Cuenta::factory()->count(3)->create();

        $response = $this->getJson('/api/cuentas');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_obtener_una_cuenta()
    {
        $cuenta = Cuenta::factory()->create();

        $response = $this->getJson("/api/cuentas/{$cuenta->idCuenta}");

        $response->assertStatus(200)
                 ->assertJson([
                     'idCuenta' => $cuenta->idCuenta,
                     'nombre' => $cuenta->nombre,
                     'email' => $cuenta->email,
                     'telefono' => $cuenta->telefono,
                 ]);
    }

    public function test_actualizar_cuenta()
    {
        $cuenta = Cuenta::factory()->create();

        $response = $this->putJson("/api/cuentas/{$cuenta->idCuenta}", [
            'nombre' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'telefono' => '987654321'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'idCuenta' => $cuenta->idCuenta,
                     'nombre' => 'Jane Doe',
                     'email' => 'janedoe@example.com',
                     'telefono' => '987654321',
                 ]);
    }

    public function test_eliminar_cuenta()
    {
        $cuenta = Cuenta::factory()->create();

        $response = $this->deleteJson("/api/cuentas/{$cuenta->idCuenta}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('cuentas', ['idCuenta' => $cuenta->idCuenta]);
    }
}