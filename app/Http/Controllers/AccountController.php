<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAllAccountsRequest;
use App\Http\Resources\Client as ClientResource;
use App\Models\Client;
use App\Repositories\IClientRepository;

class AccountController extends Controller
{
    protected $clientRepository;

    public function __construct(IClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function index(GetAllAccountsRequest $request)
    {
        $filters = $request->only((new Client())->filterable);

        return ClientResource::collection(
            $this->clientRepository->paginate(
                $filters,
                $request->query('order_by', 'id'),
                $request->query('order_direction', 'asc')
            )
        );
    }
}
