<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 13/6/17
 * Time: 11:39
 */

namespace Mh13\plugins\uploads\application;

/**
 * Interface UploadContext
 *
 * Upload context represent the entity that ask for uploaded files to the upload storage
 *
 * @package Mh13\plugins\uploads\application
 */
interface UploadContext
{
    public function getContext(): string;

}
