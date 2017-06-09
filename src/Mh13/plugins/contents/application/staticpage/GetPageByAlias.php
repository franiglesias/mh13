<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 25/4/17
 * Time: 11:07
 */

namespace Mh13\plugins\contents\application\staticpage;


class GetPageByAlias
{
    /**
     * @var string
     */
    private $alias;

    public function __construct(string $alias)
    {

        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

}
