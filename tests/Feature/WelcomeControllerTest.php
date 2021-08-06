<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    public function testWelcome(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertOk();
    }
}
