<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 28/4/17
 * Time: 16:19
 */

namespace Mh13\plugins\uploads\infrastructure\persistence\dbal\context;


class ArticleContextDBal extends DBalUploadContext
{
    const ALIAS = 'article';
    const MODEL = 'Item';
    const TABLE = 'items';
}
