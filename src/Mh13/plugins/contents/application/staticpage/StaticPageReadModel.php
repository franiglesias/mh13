<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 10:25
 */

namespace Mh13\plugins\contents\application\staticpage;


use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\related\DBalStaticPageRelatedFinder;


interface StaticPageReadModel
{
    public function getPage($specification);

    public function findPages($specification);

    public function findRelated(DBalStaticPageRelatedFinder $finder);


}
