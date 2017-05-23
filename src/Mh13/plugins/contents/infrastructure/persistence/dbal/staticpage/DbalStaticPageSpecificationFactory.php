<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:02
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage;


use Mh13\plugins\contents\domain\StaticPageSpecificationFactory;
use Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\specification\GetPageWithSlug;


class DbalStaticPageSpecificationFactory implements StaticPageSpecificationFactory
{


    public function createGetPageWithSlug(string $slug)
    {
        return new GetPageWithSlug($slug);
    }

}
