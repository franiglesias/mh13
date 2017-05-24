<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:02
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\StaticPageRelatedFinderFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\related\GetDescendantsWithDepthForPageWithSlug;


class DbalStaticPageRelatedFinderFactory implements StaticPageRelatedFinderFactory
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function createFindParentsForPageWithSlug(string $slug)
    {
        return new related\GetParentsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createFindDescendantsForPageWithSlug(string $slug)
    {
        return new related\GetDescendantsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createFindDescendantsWithDepthForPageWithSlug(string $slug)
    {
        return new GetDescendantsWithDepthForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }

    public function createFindSiblingsForPageWithSlug(string $slug)
    {
        return new related\GetSiblingsForPageWithSlug($this->connection->createQueryBuilder(), $slug);
    }
}
