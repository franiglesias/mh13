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


class ImagesOfStaticPage extends CompositeDbalSpecification
{
    public function __construct(ExpressionBuilder $expressionBuilder, string $slug)
    {
        $this->setParameter('slug', $slug, 'string');
        $this->setParameter('model', 'StaticPage', 'string');
        $this->setParameter('table', 'static_pages', 'string');
        parent::__construct($expressionBuilder);
    }

    public function getConditions()
    {
        return 'article.slug = :slug AND image.type LIKE \'image%\'';
    }
}
