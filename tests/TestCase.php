<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function actingAs(\Illuminate\Contracts\Auth\Authenticatable $user, $guard = null)
    {
        if ($user instanceof \App\Models\User && !$user->pos_environment_id) {
            $admin = \App\Models\User::where('role', 'admin')->first() 
                ?? \App\Models\User::factory()->create(['role' => 'admin']);

            $environment = \App\Models\PosEnvironment::create([
                'admin_id' => $admin->id,
                'join_code' => '123456',
            ]);

            $user->pos_environment_id = $environment->id;
            $user->save();
        }

        return parent::actingAs($user, $guard);
    }
}
