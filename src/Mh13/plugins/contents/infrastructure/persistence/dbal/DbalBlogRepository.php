<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\Blog;
use Mh13\plugins\contents\domain\BlogId;
use Mh13\plugins\contents\domain\BlogRepository;
use Mh13\plugins\contents\exceptions\InvalidBlog;


class DbalBlogRepository implements BlogRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getBySlugOrFail(string $slug): Blog
    {
        $sql = 'SELECT * FROM blogs WHERE slug = ?';
        $statement = $this->connection->executeQuery($sql, [$slug]);
        $data = $statement->fetchAll();
        if (!$data) {
            throw InvalidBlog::withSlug($slug);
        }

        return new Blog(new BlogId($data['id']), $data['title'], $data['tagline'], $data['description']);
    }
}
