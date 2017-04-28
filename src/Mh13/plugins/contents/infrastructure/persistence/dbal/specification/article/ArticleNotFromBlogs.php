<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 16:21
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class ArticleNotFromBlogs extends CompositeDbalSpecification
{
    public function __construct(ExpressionBuilder $expressionBuilder, array $blogs)
    {
        $this->setParameter('excluded', $blogs, Connection::PARAM_STR_ARRAY);
        parent::__construct($expressionBuilder);
    }

    public function getConditions()
    {
        return 'blog.slug NOT IN (:excluded)';
    }
}
