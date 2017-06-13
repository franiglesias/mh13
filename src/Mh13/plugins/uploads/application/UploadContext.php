<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 13/6/17
 * Time: 11:39
 */

namespace Mh13\plugins\uploads\application;

interface UploadContext
{
    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @return string
     */
    public function getModel(): string;
}
