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
        $sql = 'SELECT * FROM blogs WHERE blogs.slug = ?';
        $statement = $this->connection->executeQuery($sql, [$slug]);
        $data = $statement->fetch();
        if (!$data) {
            throw InvalidBlog::withSlug($slug);
        }
        $blog = new Blog(new BlogId($data['id']), $data['title'], $data['slug']);
        $blog->setIcon($data['icon']);
        $blog->setImage($data['image']);
        $blog->setTagline($data['tagline']);
        $blog->setDescription($data['description']);

        return $blog;
    }
}
