<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface IBaseRepository
{
    public function create(array $data): Model;
    public function paginate(array $filters, string $orderBy, string $orderDirection): LengthAwarePaginator;
}
