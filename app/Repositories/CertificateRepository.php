<?php

namespace App\Repositories;

use App\Models\Certificate;

class CertificateRepository
{
    protected $entity;

    public function __construct(Certificate $model)
    {
        $this->entity = $model;
    }

    public function create($dataCertificate)
    {
        return $this->entity->create($dataCertificate);
    }

    public function findCertificate($userId, $courseId)
    {
        return  $this->entity
            ->where('user_id', '=', $userId)
            ->where('course_id', '=', $courseId)
            ->first();
    }
}
