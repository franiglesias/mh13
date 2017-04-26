<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:03
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


use Doctrine\DBAL\Query\Expression\ExpressionBuilder;


abstract class CompositeDbalSpecification implements DbalSpecification
{
    /**
     * @var ExpressionBuilder
     */
    protected $expressionBuilder;
    protected $parameters = [];
    protected $types = [];

    public function __construct(ExpressionBuilder $expressionBuilder)
    {
        $this->expressionBuilder = $expressionBuilder;
    }

    abstract public function getConditions();

    public function and (CompositeDbalSpecification $specification)
    {
        return new AndSpecification($this->expressionBuilder, $this, $specification);
    }

    public function or (CompositeDbalSpecification $specification)
    {
        return new OrSpecification($this->expressionBuilder, $this, $specification);
    }

    protected function addParameters(CompositeDbalSpecification $specification)
    {
        $types = $specification->getTypes();
        foreach ($specification->getParameters() as $key => $value) {
            $this->setParameter($key, $value, $types[$key]);

        }
    }

    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    protected function setParameter($key, $value, $type = null)
    {
        $this->parameters[$key] = $value;

        $this->types[$key] = $type;
    }
}
