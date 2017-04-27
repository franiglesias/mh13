<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:13
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload;


use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class ImagesOfArticle extends CompositeDbalSpecification
{
    public function __construct(ExpressionBuilder $expressionBuilder, string $slug)
    {
        $this->setParameter('slug', $slug);
        parent::__construct($expressionBuilder);
    }

    public function getConditions()
    {
        return "article.slug = :slug AND type LIKE 'image%'";
    }
}
