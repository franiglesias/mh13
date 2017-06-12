<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 20:39
 */

namespace Mh13\plugins\contents\application\blog;


class GetBlogByAlias
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
