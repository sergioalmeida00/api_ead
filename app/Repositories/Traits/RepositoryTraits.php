<?php

namespace App\Repositories\Traits;

use App\Models\User;

trait RepositoryTraits
{
    public function getUserAuth()
    {
        return User::first();
    }
}
