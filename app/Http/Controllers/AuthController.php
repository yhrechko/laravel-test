<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\IClientRepository;
use App\Repositories\IUserRepository;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $clientRepository;
    protected $userRepository;

    public function __construct(IClientRepository $clientRepository, IUserRepository $userRepository)
    {
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request, Response $response)
    {
        $client = $this->clientRepository->create($request->validated());

        $this->userRepository->create(array_merge(
            $request->validated()['user'],
            ['client_id' => $client->id]
        ));

        return $response->setStatusCode($response::HTTP_CREATED);
    }
}
