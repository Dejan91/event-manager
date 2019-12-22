<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
