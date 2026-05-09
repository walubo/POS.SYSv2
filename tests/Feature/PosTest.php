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

        $response = $this->actingAs($admin)->get('/categories');

        $response->assertStatus(200);
    }

    public function test_cashier_cannot_access_categories()
    {
        $cashier = User::factory()->create(['role' => 'cashier']);

        $response = $this->actingAs($cashier)->get('/categories');

        $response->assertStatus(403);
    }

    public function test_can_process_sale()
    {
        $cashier = User::factory()->create(['role' => 'cashier']);
        $category = Category::create(['name' => 'Test Cat']);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 10
        ]);

        $response = $this->actingAs($cashier)->post('/sales', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2]
            ],
            'paid_amount' => 200
        ]);

        $response->assertRedirect('/sales');
        $this->assertDatabaseHas('sales', ['total_amount' => 200]);
        $this->assertEquals(8, $product->fresh()->stock);
    }
}
