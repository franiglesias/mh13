<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:40
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Mh13\plugins\contents\application\readmodel\StaticPageReadModel;
use Mh13\plugins\contents\exceptions\InvalidStaticPage;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\staticpage\GetPageWithSlug;


class DbalStaticPageReadModel implements StaticPageReadModel
{

    /**
     * @param GetPageWithSlug $specification
     */
    public function getPage($specification)
    {
        $statement = $specification->getQuery();
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
}
