<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 15:42
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;


use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class ArticleWithSlug extends CompositeDbalSpecification
{
    public function __construct(ExpressionBuilder $expressionBuilder, string $slug)
    {

        $this->setParameter('slug', $slug);
        $this->expressionBuilder = $expressionBuilder;
    }

    public function getConditions()
    {
        return 'article.slug = :slug';
    }
}
