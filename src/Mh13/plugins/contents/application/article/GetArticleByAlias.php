<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 12/6/17
 * Time: 12:03
 */

namespace Mh13\plugins\contents\application\article;


class GetArticleByAlias
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
