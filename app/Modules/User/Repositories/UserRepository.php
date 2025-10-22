<?php

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\Shared\Repositories\BaseRepository;


class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
