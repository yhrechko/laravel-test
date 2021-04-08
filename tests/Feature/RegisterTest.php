<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    // Successful

    public function testSuccessfulRegisterWithRealAddress()
    {
        Cache::shouldReceive('rememberForever')
            ->once()
            ->with('USA Oklahoma Oklahoma 933 NE 69th St', \Closure::class)
            ->andReturn([
                'results' => [
                    [
                        'geometry' => [
                            'location' => [
                                'lat' => 49,
                                'lng' => 55
                            ]
                        ]
                    ]
                ]
            ]);

        $response = $this->post('/api/register', [
            "name" => "Client name",
            "address_1" => "933 NE 69th St",
            "address_2" => "second address",
            "city" => "Oklahoma",
            "state" => "Oklahoma",
            "country" => "USA",
            "zip" => "zip",
            "phone_1" => "client phone",
            "user" => [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "email@example.com",
                "password" => "password",
                "password_confirmation" => "password",
                "phone" => "user phone"
            ]
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', ['latitude' => 49, 'longitude' => 55]);
        $this->assertDatabaseHas('users', ['client_id' => 1]);
    }

    public function testSuccessfulRegisterWithFakeAddress()
    {
        Cache::shouldReceive('rememberForever')
            ->once()
            ->with('fake country fake state fake city fake address', \Closure::class)
            ->andReturn([
                'results' => []
            ]);

        $response = $this->post('/api/register', [
            "name" => "Client name",
            "address_1" => "fake address",
            "address_2" => "second address",
            "city" => "fake city",
            "state" => "fake state",
            "country" => "fake country",
            "zip" => "zip",
            "phone_1" => "client phone",
            "user" => [
                "first_name" => "First name",
                "last_name" => "Last name",
                "email" => "email@example.com",
                "password" => "password",
                "password_confirmation" => "password",
                "phone" => "user phone"
            ]
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', ['latitude' => null, 'longitude' => null]);
        $this->assertDatabaseHas('users', ['client_id' => 2]);
    }

    // Unsuccessful

    public function testUnsuccessfulRegister()
    {
        $response = $this->post('/api/register', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }
}
