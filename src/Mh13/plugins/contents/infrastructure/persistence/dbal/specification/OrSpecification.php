<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:34
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


class OrSpecification extends CompositeDbalSpecification
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
        parent::__construct();
    }

    public function getConditions()
    {
        return sprintf('%s OR %s', $this->left->getConditions(), $this->right->getConditions());
    }
}
