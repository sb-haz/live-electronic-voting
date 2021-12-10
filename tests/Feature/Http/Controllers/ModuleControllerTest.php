<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModuleControllerTest extends TestCase
{
    Use RefreshDatabase;

    public function test_module_page_is_rendered_properly()
    {
        // Create a user
        $user = User::factory()->create();
        // Act as a user
        $this->actingAs($user);

        // Hit the page where modules are displayed
        // Located at /home route
        $response = $this->get('/home');

        // Assert that we got status 200
        $response->assertStatus(200);
    }

    public function test_users_can_create_modules()
    {
        // Create a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Want to hit /modules with a POST request
        $response = $this->post('/modules', [
            'module_name' => 'FYP',
            'module_code' => 'CS2050'
        ]);

        // Assert we were redirected
        $response->assertStatus(302);
        // Assert we are redirected to right page
        $response->assertRedirect('/modules/1');

        // Find the module created
        $module = Module::first();
        // Ensure we only have one module
        // Since nothing was in database before
        $this->assertEquals(1, Module::count());

        // Assert module has the proper data
        $this->assertEquals('FYP', $module->module_name);
        $this->assertEquals('CS2050', $module->module_code);

        // Module belongs to user who created the class
        $this->assertEquals($user->id, $module->user_id);
    }

    public function test_teachers_validated_can_see_modules()
    {
        // Create a fake user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Make GET request to homepage where modules are
        $response = $this->get('/home');

        // Assert that user has access to view page
        $response = assertOk();
    }
}
