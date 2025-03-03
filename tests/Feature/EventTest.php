<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->get('/api/events');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'description',
                'scheduled_at',
                'location',
                'max_attendees',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_show(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->get('/api/events/1');

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'title',
            'description',
            'scheduled_at',
            'location',
            'max_attendees',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_store(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/events/', [
            'title' => 'Test',
            'description' => 'test',
            'scheduled_at' => '2024-05-06 00:00:00',
            'location' => 'test',
            'max_attendees' => 20,

        ]);

        $response->assertStatus(201)->assertJson([
            'title' => 'Test',
            'description' => 'test',
            'scheduled_at' => '2024-05-06 00:00:00',
            'location' => 'test',
            'max_attendees' => 20,
        ]);
    }

    public function test_update(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->patch('/api/events/1', [
            'title' => 'Test',
        ]);

        $response->assertStatus(200)->assertJson([
            'title' => 'Test',
        ]);
    }

    public function test_delete(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/events', [
            'title' => 'test',
            'description' => 'test',
            'scheduled_at' => '2024-05-06 00:00:00',
            'location' => 'test',
            'max_attendees' => 20,
        ]);

        $this->withHeader('X-API-KEY', config('auth.api_key'))->delete('/api/events/' . $response['id'])->assertStatus(204);
    }

    public function test_subscribe(): void
    {
        $eventRes = $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/events', [
            'title' => 'test',
            'description' => 'test',
            'scheduled_at' => '2024-05-06 00:00:00',
            'location' => 'test',
            'max_attendees' => 2,
        ]);

        $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/subscribe', [
            'event' => $eventRes['id'],
            'attendee' => 1,
        ])->assertStatus(204);

        $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/subscribe', [
            'event' => $eventRes['id'],
            'attendee' => 2,
        ])->assertStatus(204);

        $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/subscribe', [
            'event' => $eventRes['id'],
            'attendee' => 1,
        ])->assertStatus(400)->assertJson([
                    'message' => 'Attendee is already subscribed'
                ]);

        $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/subscribe', [
            'event' => $eventRes['id'],
            'attendee' => 3,
        ])->assertStatus(400)->assertJson([
                    'message' => 'Event is full'
                ]);
    }
}
