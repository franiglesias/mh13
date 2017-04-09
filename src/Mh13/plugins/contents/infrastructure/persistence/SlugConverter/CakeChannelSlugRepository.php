<?php

namespace Mh13\plugins\contents\infrastructure\persistence\SlugConverter;

use Doctrine\DBAL\Connection;


class CakeItemSlugRepository implements SlugRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getIdOfSlug($slug)
    {
        $sql = 'select id from channels where slug = ?';;
        $statement = $this->connection->executeQuery($sql, [(string)$slug]);
        $result = $statement->fetch();

        return $result['id'];
    }
}
