<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class HealthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_health_returns_200_with_valid_header(): void
    {
        $response = $this->getJson('/api/v1/health-check', [
            'X-Owner' => Str::uuid()->toString(),
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['db', 'cache']);
    }

    public function test_health_returns_401_without_header(): void
    {
        $response = $this->getJson('/api/v1/health-check');
        $response->assertStatus(401);
    }

    public function test_health_is_throttled_after_60_records(): void
    {
        $uuid = Str::uuid()->toString();

        $limitThrottle = 62;
        while($limitThrottle-- && $limitThrottle > 0){
            $response = $this->getJson('/api/v1/health-check', [
                'X-Owner' => $uuid,
            ]);
        }
        $response->assertStatus(429);
    }
}
