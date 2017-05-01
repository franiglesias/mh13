<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:34
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


class AndSpecification extends CompositeDbalSpecification
{
    protected $left;
    protected $right;

    public function __construct(
        CompositeDbalSpecification $left,
        CompositeDbalSpecification $right
    ) {
        $this->left = $left;
        $this->right = $right;
        $this->addParameters($left);
        $this->addParameters($right);
    }

    public function getConditions()
    {
        return sprintf('%s AND %s', $this->left->getConditions(), $this->right->getConditions());
    }
}
