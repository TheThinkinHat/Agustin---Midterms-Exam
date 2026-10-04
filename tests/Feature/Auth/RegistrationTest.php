<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertOk()
            ->assertSee('Choose a Username');
    }

    public function test_login_screen_links_to_registration(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee(route('register'))
            ->assertSee('Register here');
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'username' => 'test-admin',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('users', ['username' => 'test-admin']);
        $this->assertDatabaseMissing('users', [
            'username' => 'test-admin',
            'password' => 'password',
        ]);
    }
}
