<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:02
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\StaticPageSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetPageWithSlug;


class DBalStaticPageSpecificationFactory implements StaticPageSpecificationFactory
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function createGetPageWithSlug(string $slug)
    {
        return new GetPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }
}
