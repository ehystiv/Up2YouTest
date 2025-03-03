<?php

namespace Tests\Feature;

use Tests\TestCase;

class GenericTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_unauthorized(): void
    {
        $response = $this->get('/api/attendees');

        $response->assertStatus(401);
    }
}
