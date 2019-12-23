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

}
