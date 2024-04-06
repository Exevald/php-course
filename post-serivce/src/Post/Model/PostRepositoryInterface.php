<?php

namespace App\Post\Model;

interface PostRepositoryInterface
{
    public function get(int $id): ?Post;

    public function store(Post $post): int;
}