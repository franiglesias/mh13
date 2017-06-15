<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 28/4/17
 * Time: 16:19
 */

namespace Mh13\plugins\uploads\infrastructure\persistence\dbal\context;


class DBalImageCollectionContext extends DBalUploadContext
{
    const ALIAS = 'collection';
    const MODEL = 'ImageCollection';
    const TABLE = 'image_collections';
}
