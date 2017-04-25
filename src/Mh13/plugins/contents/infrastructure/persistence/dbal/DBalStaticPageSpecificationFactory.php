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
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetDescendantsForPageWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetPageWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetParentsForPageWithSlug;


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

    public function createGetParentsForPageWithSlug(string $slug)
    {
        return new GetParentsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createGetDescendantsForPageWithSlug(string $slug)
    {
        return new GetDescendantsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }
}
