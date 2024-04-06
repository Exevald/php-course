<?php

namespace App\User\Domain;


interface UserRepositoryInterface
{
    public function get(int $id): ?User;

    public function store(User $user): int;
}