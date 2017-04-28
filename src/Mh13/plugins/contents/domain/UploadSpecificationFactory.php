<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 27/4/17
 * Time: 10:05
 */

namespace Mh13\plugins\contents\domain;


use Mh13\plugins\contents\application\service\upload\AttachedFilesContext;


interface UploadSpecificationFactory
{

    public function createAttachedImages(AttachedFilesContext $context, string $slug);

    public function createAttachedDownloads(AttachedFilesContext $context, string $slug);

    public function createAttachedMedia(AttachedFilesContext $context, string $slug);

}
