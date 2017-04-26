<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 12:01
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification;


interface DbalSpecification
{
    public function getConditions();
}
