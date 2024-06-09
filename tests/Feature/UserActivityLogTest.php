<?php

namespace Tests\Feature;

use Tests\TestCase;
use Torann\GeoIP\Facades\GeoIP;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserActivityLogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing user activity log.
     *
     * @return void
     */
    public function testStoreUserActivityLog()
    {
        // Mock the GeoIP facade
        GeoIP::shouldReceive('getLocation')
            ->once()
            ->andReturn($location = (object)[
                'country' => 'United States',
                'city' => 'New York',
                'state' => 'NY',
                'timezone' => 'America/New_York'
            ]);

        // Mock the Agent facade
        Agent::shouldReceive('browser')
            ->once()
            ->andReturn($browser = 'Chrome');

        Agent::shouldReceive('platform')
            ->once()
            ->andReturn($platform = 'Windows');

        Agent::shouldReceive('device')
            ->once()
            ->andReturn($device = 'Desktop');

        Agent::shouldReceive('isRobot')
            ->once()
            ->andReturn(false);

        Agent::shouldReceive('languages')
            ->once()
            ->andReturn($languages =  ['en-US', 'en']);

        $headerData = [
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            'referer' => 'http://example.com',
        ];

        $response = $this->postJson('/user-activity-logs', [], $headerData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User activity logged successfully',
            ]);

        $this->assertDatabaseHas('user_activity_logs', [
            'user_agent' => $headerData['user_agent'],
            'referral_url' => $headerData['referer'],
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'timezone' => $location->timezone,
            'browser' => $browser,
            'platform' => $platform,
            'device' => $device,
            'languages' => json_encode($languages),
        ]);
    }
}
