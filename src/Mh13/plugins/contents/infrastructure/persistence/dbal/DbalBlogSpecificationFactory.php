<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 21/4/17
 * Time: 13:22
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\BlogSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\ActiveBlogWithSlug;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\BlogIsActive;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog\BlogWithSlug;


class DbalBlogSpecificationFactory implements BlogSpecificationFactory
{
    protected $expressionBuilder;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->expressionBuilder = $this->connection->createQueryBuilder()->expr();
    }

    public function createBlogWithSlug(string $slug)
    {
        $blogIsActive = new BlogIsActive($this->expressionBuilder);

        return $blogIsActive->and(new BlogWithSlug($this->expressionBuilder, $slug));
    }
}
