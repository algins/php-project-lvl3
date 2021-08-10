<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
    }

    public function testStore(): void
    {
        $urlId = DB::table('urls')->insertGetId([
            'name' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHas('flash_notification.0.level', 'info');
        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', ['url_id' => $urlId]);
    }

    public function testStoreWithNonExistingUrl(): void
    {
        $urlId = 0;

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $response->assertRedirect();

        $this->assertDatabaseMissing('url_checks', ['url_id' => $urlId]);
    }
}
