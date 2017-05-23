<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:06
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\blog\specification;


use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class BlogWithSlug extends CompositeDbalSpecification
{

    public function __construct(string $slug)
    {
        $this->setParameter('slug', $slug);
    }

    public function getConditions()
    {
        return 'blog.slug = :slug';

    }

}
