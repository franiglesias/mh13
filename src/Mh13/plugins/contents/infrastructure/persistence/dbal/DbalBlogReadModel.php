<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\BlogReadModel;
use Mh13\plugins\contents\exceptions\InvalidBlog;


class DbalBlogReadModel implements BlogReadModel
{
    /**
     * @var Connection
     */
    private $connection;


    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getBlog($specification)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('blog.*')->from('blogs', 'blog')->where($specification->getConditions())->setParameters(
                $specification->getParameters(),
                $specification->getTypes()
            )
        ;
        $statement = $builder->execute();
        $blog = $statement->fetch();
        if (!$blog) {
            throw InvalidBlog::message('That blog does not exist.');
        }

        return $blog;


    }

    public function findBlogs($specification)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('blog.*')->from('blogs', 'blog')->where($specification->getConditions())->setParameters(
            $specification->getParameters(),
            $specification->getTypes()
        )
        ;
        $statement = $builder->execute();
        $blogs = $statement->fetchAll();

        return $blogs;


    }


}
