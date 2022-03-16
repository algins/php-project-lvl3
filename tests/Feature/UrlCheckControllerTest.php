<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    public function testStore(): void
    {
        /** @var string $body */
        $body = file_get_contents($this->getFixturePath('response.html'));

        Http::fake([
            '*' => Http::response($body),
        ]);

        $urlId = DB::table('urls')->insertGetId([
            'name' => $this->faker->url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHas('flash_notification.0.level', 'info');
        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $urlId,
            'status_code' => 200,
            'h1' => 'Page analyzer',
            'title' => 'Page analyzer',
            'description' => 'Site that analyzes pages for SEO suitability.',
        ]);
    }

    public function testStoreWithNonExistingUrl(): void
    {
        $urlId = 0;

        $response = $this->post(route('urls.checks.store', $urlId));
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $response->assertRedirect();

        $this->assertDatabaseMissing('url_checks', ['url_id' => $urlId]);
    }

    private function getFixturePath(string $filename): string
    {
        $segments = [__DIR__, '..', 'fixtures', $filename];

        return implode(DIRECTORY_SEPARATOR, $segments);
    }
}
