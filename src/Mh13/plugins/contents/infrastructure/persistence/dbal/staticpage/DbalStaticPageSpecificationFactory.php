<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:02
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\StaticPageSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\related\GetDescendantsWithDepthForPageWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\specification\GetPageWithSlug;


class DbalStaticPageSpecificationFactory implements StaticPageSpecificationFactory
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
        return new related\GetParentsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createGetDescendantsForPageWithSlug(string $slug)
    {
        return new related\GetDescendantsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createGetDescendantsWithDepthForPageWithSlug(string $slug)
    {
        return new GetDescendantsWithDepthForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createGetSiblingsForPageWithSlug(string $slug)
    {
        return new related\GetSiblingsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }
}
