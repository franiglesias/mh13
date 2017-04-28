<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 28/4/17
 * Time: 16:19
 */

namespace Mh13\plugins\contents\application\service\upload;


class ImageCollectionContext extends AttachedFilesContext
{
    protected $alias = 'collection';
    protected $model = 'ImageCollection';
    protected $table = 'image_collections';
}
