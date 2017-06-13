<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 13/6/17
 * Time: 9:43
 */

namespace Mh13\plugins\uploads\application;


class GetDownloadsForObject
{
    /**
     * @var string
     */
    private $object;
    /**
     * @var string
     */
    private $alias;

    public function __construct(string $object, string $alias)
    {

        $this->object = $object;
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

}
