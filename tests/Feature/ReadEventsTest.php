<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadEventsTest extends TestCase
{
    use RefreshDatabase;

    protected $eventManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventManager = factory('App\User')->create();

        $this->eventManager->assignRole('Event Manager');

    }

    /** @test */
    public function an_unauthenticated_user_can_not_browse_events()
    {
        $this->json('GET', '/event')
            ->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'Unauthenticated.',
            ]);
    }

    /** @test */
    public function an_authenticated_user_can_browse_all_events()
    {
        $this->actingAs($this->eventManager);

        $event = factory('App\Event')->create(['user_id' => $this->eventManager->id]);
        $secondEvent = factory('App\Event')->create(['user_id' => $this->eventManager->id]);

        $this->json('GET', route('event.index'))
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $event->title,
                'title' => $secondEvent->title,
                'user_id' => strval($this->eventManager->id),
            ]);
    }

    /** @test */
    public function user_can_not_view_create_event_form_before_verifying_email_address()
    {
        $user = factory('App\User')->create(['email_verified_at' => null]);
        $this->actingAs($user);

        $this->json('GET', route('event.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function only_event_manager_and_super_admin_can_view_create_event_form()
    {
        $this->actingAs($this->eventManager);

        $this->json('GET', route('event.create'))
            ->assertStatus(200);

        $superAdmin = factory('App\User')->create();
        $superAdmin->assignRole('Super Admin');
        $this->actingAs($superAdmin);

        $this->json('GET', route('event.create'))
            ->assertStatus(200);

        $client = factory('App\User')->create();
        $client->assignRole('Client');
        $this->actingAs($client);

        $this->json('GET', route('event.create'))
            ->assertStatus(403);

    }

    /** @test */
    public function an_authenticated_user_can_show_event()
    {
        $this->actingAs($this->eventManager);

        $event = factory('App\Event')->create(['user_id' => $this->eventManager->id]);

        $this->get(route('event.show', [$event->id]))
            ->assertSee($event->title)
            ->assertSee($event->description);
    }

}
