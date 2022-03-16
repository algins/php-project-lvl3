<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    private string $urlName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->urlName = $this->faker->url;
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $response = $this->post(route('urls.store'), ['url' => ['name' => $this->urlName]]);
        $response->assertSessionHas('flash_notification.0.level', 'success');
        $response->assertRedirect();

        $this->assertDatabaseHas('urls', ['name' => normalize_url($this->urlName)]);
    }

    public function testStoreWithValidationErrors(): void
    {
        $urlName = 'invalid-url';

        $response = $this->post(route('urls.store'), ['url' => ['name' => $urlName]]);
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $response->assertRedirect();

        $this->assertDatabaseMissing('urls', ['name' => normalize_url($urlName)]);
    }

    public function testStoreExistingUrl(): void
    {
        $normalizedUrlName = normalize_url($this->urlName);

        DB::table('urls')->insert([
            'name' => $normalizedUrlName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('urls.store'), ['url' => ['name' => $this->urlName]]);
        $response->assertSessionHas('flash_notification.0.level', 'info');
        $response->assertRedirect();

        $this->assertDatabaseHas('urls', ['name' => $normalizedUrlName]);
        $this->assertDatabaseCount('urls', 1);
    }

    public function testShow(): void
    {
        $id = DB::table('urls')->insertGetId([
            'name' => $this->urlName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get(route('urls.show', $id));
        $response->assertOk();
    }
}
