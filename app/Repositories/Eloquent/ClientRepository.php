<?php

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Repositories\IClientRepository;

class ClientRepository extends BaseRepository implements IClientRepository
{
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }
}
