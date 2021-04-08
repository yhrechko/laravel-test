<?php

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Models\User;
use App\Repositories\IClientRepository;
use App\Repositories\IUserRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create(array $data): Model
    {
        $user = new $this->model($data);
        $user->client_id = $data['client_id'];
        $user->save();

        return $user;
    }
}
