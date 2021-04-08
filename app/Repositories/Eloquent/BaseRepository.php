<?php

namespace App\Repositories\Eloquent;

use App\Repositories\IBaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseRepository implements IBaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function paginate(array $filters, string $orderBy, string $orderDirection): LengthAwarePaginator
    {
        $query = $this->model->query()
            ->where($filters)
            ->orderBy($orderBy, $orderDirection);

        return $query->paginate()->withQueryString();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
