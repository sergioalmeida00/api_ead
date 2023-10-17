<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Repositories\Traits\RepositoryTraits;

class ReplySupportsRepository
{
    use RepositoryTraits;
    protected $entity;

    public function __construct(ReplySupport $model)
    {
        $this->entity = $model;
    }

    public function createReplyToSupportId($data)
    {
        $user = $this->getUserAuth();

        return $this->entity
            ->create([
                'support_id' => $data['supportId'],
                'description' => $data['description'],
                'user_id' => $user->id
            ]);
    }
}
