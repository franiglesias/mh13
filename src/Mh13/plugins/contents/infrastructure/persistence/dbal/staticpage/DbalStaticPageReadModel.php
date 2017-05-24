<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:40
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\StaticPageReadModel;
use Mh13\plugins\contents\exceptions\InvalidStaticPage;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\related\DBalStaticPageRelatedFinder;


class DbalStaticPageReadModel implements StaticPageReadModel
{
    /**
     * @var Connection
     */
    private $connection;


    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param \Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\specification\PageWithSlug $specification
     */
    public function getPage($specification)
    {
        $builder = $this->connection->createQueryBuilder();

        $builder->select('static.*', 'image.path as image')->from('static_pages', 'static')->leftJoin(
            'static',
            'uploads',
            'image',
            'image.id = (select uploads.id from uploads where uploads.model="StaticPage" and foreign_key = static.id order by uploads.order asc limit 1)'

        )->where(
            $specification->getConditions()
        )->setParameters(
            $specification->getParameters(),
            $specification->getTypes()
        )
        ;
        $statement = $builder->execute();

        $page = $statement->fetch();
        if (!$page) {
            throw InvalidStaticPage::message('Static Page not found with that name');
        }

        return $page;
    }


    public function findPages($specification)
    {
        $statement = $specification->getQuery();

        return $statement->fetchAll();
    }

    public function findRelated(DBalStaticPageRelatedFinder $finder)
    {
        $statement = $finder->getQuery();

        return $statement->fetchAll();
    }
}
