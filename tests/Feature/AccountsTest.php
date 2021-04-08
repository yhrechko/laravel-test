<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    // Successful

    public function testSuccessfulGetAllAccounts()
    {
        $response = $this->get('/api/accounts');

        $response->assertStatus(200);
    }

    public function testSuccessfulGetAllAccountsWithSortingById()
    {
        $response = $this->get('/api/accounts?order_by=id&order_direction=asc');

        $response->assertStatus(200);
    }

    public function testSuccessfulGetAllAccountsWithCorrectFilters()
    {
        $query = [
            'id' => 1,
            'name' => 'name',
            'address_1' => 'address_1',
            'address_2' => 'address_2',
            'city' => 'city',
            'state' => 'state',
            'country' => 'country',
            'latitude' => '24',
            'longitude' => '47',
            'phone_1' => 'phone',
            'phone_2' => 'phone',
            'zip' => 'zip',
            'start_validity' => '2021-04-08',
            'end_validity' => '2021-04-23',
            'status' => 'Active',
            'created_at' => '2021-04-08',
            'updated_at' => '2021-04-08',
        ];

        $queryString = implode(
            '&',
            array_map(function ($value, $key) {
                return "$key=$value";
            }, $query, array_keys($query))
        );

        $response = $this->get("/api/accounts?$queryString");

        $response->assertStatus(200);
    }

    // Unsuccessful

    public function testUnsuccessfulGetAllAccountsWithWrongSortingField()
    {
        $response = $this->get('/api/accounts?order_by=some_field', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    public function testUnsuccessfulGetAllAccountsWithWrongSortingOrder()
    {
        $response = $this->get('/api/accounts?order_direction=bigger', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    public function testUnsuccessfulGetAllAccountsWithWrongNumericFilter()
    {
        $response = $this->get('/api/accounts?id=string', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }

    public function testUnsuccessfulGetAllAccountsWithWrongDateFilter()
    {
        $response = $this->get('/api/accounts?created_at=wrong_date', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
    }
}
