<?php

namespace App\Observers;

use App\Models\Client;

class ClientObserver
{
    public function creating(Client $client)
    {
        $client->fillGeocodingData();
    }
}
