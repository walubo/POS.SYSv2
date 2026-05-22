<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_categories()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $environment = \App\Models\PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => '123456',
        ]);
        $admin->update(['pos_environment_id' => $environment->id]);

        $response = $this->actingAs($admin)->get('/categories');

        $response->assertStatus(200);
    }

    public function test_cashier_cannot_access_categories()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $environment = \App\Models\PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => '123456',
        ]);
        $cashier = User::factory()->create([
            'role' => 'cashier',
            'pos_environment_id' => $environment->id,
        ]);

        $response = $this->actingAs($cashier)->get('/categories');

        $response->assertStatus(403);
    }

    public function test_can_process_sale()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $environment = \App\Models\PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => '123456',
        ]);
        $cashier = User::factory()->create([
            'role' => 'cashier',
            'pos_environment_id' => $environment->id,
        ]);

        $category = Category::create([
            'name' => 'Test Cat',
            'pos_environment_id' => $environment->id,
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 10,
            'pos_environment_id' => $environment->id,
        ]);

        $response = $this->actingAs($cashier)->post('/sales', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2]
            ],
            'paid_amount' => 200
        ]);

        $response->assertRedirect('/sales');
        $this->assertDatabaseHas('sales', ['total_amount' => 200, 'pos_environment_id' => $environment->id]);
        $this->assertEquals(8, $product->fresh()->stock);
    }
}
