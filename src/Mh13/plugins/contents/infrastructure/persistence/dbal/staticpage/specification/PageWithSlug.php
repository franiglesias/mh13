<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 10:06
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\staticpage\specification;


use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class PageWithSlug extends CompositeDbalSpecification
{
    public function __construct(string $slug)
    {
        $this->setParameter('slug', $slug);
    }

    public function getConditions()
    {
        return 'static.slug = :slug';
    }
}
