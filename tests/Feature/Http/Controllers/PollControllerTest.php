<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PollControllerTest extends TestCase
{
    Use RefreshDatabase;

   public function test_poll_page_is_rendered_properly()
   {
       // Create a user
       $user = User::factory()->create();
       // Act as a user
       $this->actingAs($user);

       // Hit the page where polls are displayed
       // Located at /home route
       $response = $this->get('/modules/1/sessions/1');

       // Assert that we got status 200
       $response->assertStatus(200);
   }

   public function test_teachers_validated_can_see_polls()
   {
       // Create a fake user
       $user = User::factory()->create();
       $this->actingAs($user);

       // Make GET request to homepage where polls are
       $response = $this->get('/modules/1/sessions/1');

       // Assert that user has access to view page
       $response = assertOk();
   }

   public function test_users_cannot_create_without_answers()
    {
        // Create a user
        $user = User::factory()->create();
        $this->actingAs($user);

        //Create a new module and session which the session will belong to
        $response = $this->post('/modules', [
            'module_name' => 'FYP',
            'module_code' => 'CS2050'
        ]);
        $response = $this->post('/modules', [
            'session_topic' => 'MySQL'
        ]);

        // Want to hit /polls with a POST request
        $response = $this->post('/modules', [
            'question' => 'What is MySQL'
        ]);

        // Assert was not created
        $response->assertSessionHasErrors('answers');
        $response->assertStatus(422);

        // Find the session created
        $module = Poll::first();
        // Ensure we have no polls
        // Since nothing was in database before
        $this->assertEquals(0, Poll::count());

        // Assert polls has the proper data
        $this->assertEquals('MySQL', $module->session_topic);

        // Polls belongs to user who created the class
        $this->assertEquals($user->id, $session->user_id);
    }

   public function test_only_logged_in_user_can_see_sessions_page()
   {
       // Make GET request to sessions page without logged in
       $response = $this->get('/modules/1/sessions/1');

       // Assert we were redirected
       $response->assertStatus(302);

       // Assert we are redirected to right page
       $response->assertRedirect('/login');
   }
}
