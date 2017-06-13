<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 13/6/17
 * Time: 11:41
 */

namespace Mh13\plugins\uploads\application;

interface UploadContextFactory
{
    /**
     * @param string $type
     */
    public function getContextFor(string $type);
}
