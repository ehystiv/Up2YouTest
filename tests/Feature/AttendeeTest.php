<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendeeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->get('/api/attendees');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id',
                'firstname',
                'lastname',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_show(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->get('/api/attendees/1');

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'firstname',
            'lastname',
            'email',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_store(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/attendees', [
            'firstname' => 'Stefano',
            'lastname' => 'Maffulli',
            'email' => 'test@test.com',
        ]);

        $response->assertStatus(201)->assertJson([
            'firstname' => 'Stefano',
            'lastname' => 'Maffulli',
            'email' => 'test@test.com',
        ]);
    }

    public function test_update(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->patch('/api/attendees/1', [
            'firstname' => 'Stefano',
            'lastname' => 'Maffulli',
            'email' => 'test@test.com',
        ]);

        $response->assertStatus(200)->assertJson([
            'firstname' => 'Stefano',
            'lastname' => 'Maffulli',
            'email' => 'test@test.com',
        ]);
    }

    public function test_delete(): void
    {
        $response = $this->withHeader('X-API-KEY', config('auth.api_key'))->post('/api/attendees', [
            'firstname' => 'Stefano',
            'lastname' => 'Maffulli',
            'email' => 'test@test.com',
        ]);

        $this->withHeader('X-API-KEY', config('auth.api_key'))->delete('/api/attendees/'.$response['id'])->assertStatus(204);
    }
}
