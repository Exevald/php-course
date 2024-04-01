<?php

namespace App\Post\Domain;

use DateTime;

class Post
{
    private ?int $id;
    private string $title;
    private string $subTitle;
    private string $content;
    public ?DateTime $postedAt;

    public function __construct(?int $id, string $title, string $subTitle, string $content, ?DateTime $postedAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->content = $content;
        $this->postedAt = $postedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPostedAt(): ?DateTime
    {
        return $this->postedAt;
    }
}