<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PosEnvironment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_routes_clear_demo_mode_session()
    {
        // Set demo_mode in session
        session(['demo_mode' => true]);
        $this->assertTrue(session('demo_mode'));

        // Visit /login (a guest route)
        $response = $this->get('/login');

        // Assert session variable is forgotten
        $this->assertNull(session('demo_mode'));
    }

    public function test_cannot_add_employee_if_not_in_demo_mode()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $environment = PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => '123456',
        ]);
        $admin->update(['pos_environment_id' => $environment->id]);

        $response = $this->actingAs($admin)
            ->post(route('demo.addEmployee'), [
                'name' => 'Test Employee',
                'email' => 'test@demo.com',
                'password' => 'password123',
            ]);

        // Should redirect to login because not in demo mode
        $response->assertRedirect(route('login'));
    }

    public function test_add_employee_in_demo_mode()
    {
        // Set demo_mode in session
        session(['demo_mode' => true]);

        // Create the admin and environment
        $admin = User::factory()->create(['role' => 'admin']);
        $environment = PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => '123456',
        ]);
        $admin->update(['pos_environment_id' => $environment->id]);

        $response = $this->actingAs($admin)
            ->post(route('demo.addEmployee'), [
                'name' => 'Demo Employee',
                'email' => 'cashier@demo.com',
                'password' => 'password123',
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Demo Employee',
            'email' => 'cashier@demo.com',
            'role' => 'cashier',
            'pos_environment_id' => $environment->id,
        ]);
    }

    public function test_simulate_selects_random_cashier()
    {
        session(['demo_mode' => true]);

        $admin = User::factory()->create(['role' => 'admin']);
        $environment = PosEnvironment::create([
            'admin_id' => $admin->id,
            'join_code' => '123456',
        ]);
        $admin->update(['pos_environment_id' => $environment->id]);

        // Create two cashiers
        User::create([
            'name' => 'Cashier One',
            'email' => 'one@demo.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
            'pos_environment_id' => $environment->id,
        ]);
        User::create([
            'name' => 'Cashier Two',
            'email' => 'two@demo.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
            'pos_environment_id' => $environment->id,
        ]);

        // Create a product with stock
        $category = \App\Models\Category::create([
            'name' => 'Test Category',
            'pos_environment_id' => $environment->id,
        ]);
        \App\Models\Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'stock' => 100,
            'pos_environment_id' => $environment->id,
        ]);

        // Call the simulate route
        $response = $this->actingAs($admin)
            ->get(route('demo.simulate'));

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        
        // Assert the returned cashier name is one of the two cashiers
        $data = $response->json();
        $this->assertContains($data['cashier_name'], ['Cashier One', 'Cashier Two']);
    }
}
