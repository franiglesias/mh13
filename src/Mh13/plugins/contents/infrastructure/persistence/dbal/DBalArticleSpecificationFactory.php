<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 16:35
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\service\catalog\CatalogRequest;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class DBalArticleSpecificationFactory implements ArticleSpecificationFactory
{
    /**
     * @var Connection
     */
    private $connection;


    /**
     * DBalArticleSpecificationFactory constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function createLastArticles()
    {
        // TODO: Implement createLastArticles() method.
    }

    public function createFromCatalogRequest(CatalogRequest $catalogRequest)
    {
        return new FromCatalogRequest($this->connection, $catalogRequest);
    }
}
