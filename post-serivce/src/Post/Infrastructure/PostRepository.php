<?php

namespace App\Post\Infrastructure;

use App\Post\Model\Post;
use App\Post\Model\PostRepositoryInterface;
use DateTime;
use InvalidArgumentException;
use PDO;

class PostRepository implements PostRepositoryInterface
{
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d';
    public function __construct(private PDO $connection)
    {
    }

    public function get(int $id): ?Post
    {
        $query = "SELECT title, 
                         subtitle, 
                         content, 
                         posted_at
                  FROM post 
                  WHERE id = $id";
        $statement = $this->connection->query($query);
        if ($row = $statement->fetch(PDO::FETCH_ASSOC))
        {
            return $this->createPostFromRow($row);
        }
        return null;
    }

    public function store(Post $post): int
    {
        $postedAt = $post->getPostedAt();
        $query = "INSERT INTO post 
                    (title, subtitle, content, posted_at)
                    VALUES (:title, :subtitle, :content, :posted_at);";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            'title' => $post->getTitle(),
            'subtitle' => $post->getSubtitle(),
            'content' => $post->getContent(),
            'posted_at' => $postedAt->format(self::MYSQL_DATETIME_FORMAT),
        ]);
        return $this->connection->lastInsertId();
    }

    private function createPostFromRow(array $row): Post
    {
        return new Post(
            (int)$row['id'],
            $row['title'],
            $row['subtitle'],
            $row['content'],
            $this->parseDateTime($row['posted_at']),
        );
    }

    private function parseDateTime(string $value): DateTime
    {
        $result = DateTime::createFromFormat(self::MYSQL_DATETIME_FORMAT, $value);
        if (!$result)
        {
            throw new InvalidArgumentException("Invalid datetime value '$value'");
        }
        return $result;
    }
}