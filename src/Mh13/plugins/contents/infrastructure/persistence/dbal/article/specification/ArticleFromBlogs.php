<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 16:17
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\article\specification;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class ArticleFromBlogs extends CompositeDbalSpecification
{
    public function __construct(array $blogs)
    {
        $this->setParameter('blogs', $blogs, Connection::PARAM_STR_ARRAY);
    }

    public function getConditions()
    {
        return 'blog.slug IN (:blogs)';
    }
}
