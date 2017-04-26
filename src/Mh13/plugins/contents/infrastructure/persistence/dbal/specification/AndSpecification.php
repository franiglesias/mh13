<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:34
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Query\Expression\ExpressionBuilder;


class AndSpecification extends CompositeDbalSpecification
{
    protected $left;
    protected $right;

    public function __construct(
        ExpressionBuilder $expressionBuilder,
        CompositeDbalSpecification $left,
        CompositeDbalSpecification $right
    ) {
        $this->left = $left;
        $this->right = $right;
        $this->addParameters($left);
        $this->addParameters($right);
        parent::__construct($expressionBuilder);
    }

    public function getConditions()
    {
        return $this->expressionBuilder->andX($this->left->getConditions(), $this->right->getConditions());
    }
}
