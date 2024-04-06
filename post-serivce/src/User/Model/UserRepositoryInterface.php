<?php

namespace App\User\Model;


interface UserRepositoryInterface
{
    public function get(int $id): ?User;

    public function store(User $user): int;
}