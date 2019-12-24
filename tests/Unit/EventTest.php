<?php

namespace Tests\Unit;

use App\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    protected $event;

    protected $eventManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventManager = factory('App\User')->create();

        $this->eventManager->assignRole('Event Manager');

        $this->actingAs($this->eventManager);

        $this->event = factory('App\Event')->create(['user_id' => $this->eventManager->id]);

    }

    /** @test */
    public function it_returns_default_image_path_if_event_has_no_image()
    {
        $this->withExceptionHandling();

        $this->assertEquals(
            asset("images/event_images/default.png"),
            $this->event->imagePath
        );
    }

    /** @test */
    public function an_event_has_path()
    {
        $this->assertEquals(
            "/event/{$this->event->id}",
            $this->event->path()
        );
    }

    /** @test */
    public function an_event_has_creator()
    {
        $this->assertInstanceOf(
            'App\User',
            $this->event->creator
        );
    }

    /** @test */
    public function an_event_has_country()
    {
        $this->assertInstanceOf(
            'App\Country',
            $this->event->country
        );
    }

    /** @test */
    public function an_event_can_add_comment()
    {
        $this->event->comments()->create([
            'user_id' => 1,
            'body' => 'First comment'
        ]);

        $this->assertEquals(
            1,
            $this->event->comments()->count()
        );
    }

    /** @test */
    public function an_event_has_comments()
    {
        $this->event->comments()->create([
            'user_id' => 1,
            'body' => 'First comment'
        ]);

        $this->assertInstanceOf(
            'App\Comment',
            $this->event->comments->first()
        );
    }

    /** @test */
    public function an_event_can_have_favorites()
    {
        Favorite::create([
            'user_id' => $this->eventManager->id,
            'favoritable_id' => $this->event->id,
            'favoritable_type' => 'App\Event',
        ]);

        $this->assertEquals(
            $this->event->id,
            $this->event->favorites()->first()->favoritable_id
        );
    }

    /** @test */
    public function an_event_can_be_favorited()
    {
        $this->event->favorite();

        $this->assertDatabaseHas('favorites', [
            'favoritable_id' => $this->event->id,
        ]);
    }

    /** @test */
    public function an_event_can_be_unfavorited()
    {
        $this->event->favorite();

        $this->event->unfavorite();

        $this->assertDatabaseMissing('favorites', [
            'favoritable_id' => $this->event->id,
        ]);
    }

    /** @test */
    public function an_event_know_if_it_is_favorited()
    {
        $this->event->favorite();

        $this->assertTrue($this->event->fresh()->isFavorited());

        $this->event->unfavorite();

        $this->assertFalse($this->event->fresh()->isFavorited());
    }

    /** @test */
    public function an_event_has_subscriptions()
    {
        $this->event->subscribe();

        $this->assertInstanceOf(
            'App\EventSubscription',
            $this->event->subscription()->first()
        );
    }

    /** @test */
    public function an_event_can_be_subscribed_to()
    {
        $this->event->subscribe();

        $this->assertDatabaseHas(
            'event_subscriptions', [
                'user_id' => $this->eventManager->id,
                'event_id' => $this->event->id,
            ]
        );
    }

    /** @test */
    public function an_event_can_be_unsubscribed_from()
    {
        $this->event->subscribe();
        $this->event->unsubscribe();

        $this->assertDatabaseMissing(
            'event_subscriptions', [
                'user_id' => $this->eventManager->id,
                'event_id' => $this->event->id,
            ]
        );
    }

    /** @test */
    public function an_event_know_if_authenticated_user_is_subscribe_to_it()
    {
        $this->assertFalse($this->event->isSubscribed);

        $this->event->subscribe();

        $this->assertTrue($this->event->isSubscribed);
    }

    /** @test */
    public function an_event_know_how_many_subscribers_it_has()
    {
        $this->assertEquals(
            0,
            $this->event->subscribersCount
        );

        $this->event->subscribe();

        $this->assertEquals(
            1,
            $this->event->fresh()->subscribersCount
        );
    }

    /** @test */
    public function an_event_records_activity_for_the_user_when_it_is_created()
    {
        $this->assertDatabaseHas(
            'activities', [
                'user_id' => $this->eventManager->id,
                'subject_id' => $this->event->id,
                'subject_type' => 'App\Event',
                'type' => 'created_event',
            ]
        );
    }

    /** @test */
    public function an_event_has_activities()
    {
        $this->assertInstanceOf(
            'App\Activity',
            $this->event->activity()->first()
        );
    }

}
