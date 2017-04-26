<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:06
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\blog;


use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class BlogWithSlug extends CompositeDbalSpecification
{

    public function __construct(ExpressionBuilder $expressionBuilder, string $slug)
    {
        $this->setParameter('slug', $slug);

        parent::__construct($expressionBuilder);
    }

    public function getConditions()
    {
        return $this->expressionBuilder->eq('slug', ':slug');

    }

}
