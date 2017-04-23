<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 17:01
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\ArticleReadModel;
use Mh13\plugins\contents\application\service\catalog\ArticleRequest;


class DBalArticleReadModel implements ArticleReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getArticle($specification)
    {
        $statement = $specification->getQuery()->execute();

        return $statement->fetch();
    }

    /**
     * @param ArticleRequest $request
     *
     * @return array
     */
    public function findArticles($specification)
    {
        $statement = $specification->getQuery()->execute();

        return $statement->fetchAll();

    }


}
