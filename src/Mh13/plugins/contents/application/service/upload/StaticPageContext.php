<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 28/4/17
 * Time: 16:19
 */

namespace Mh13\plugins\contents\application\service\upload;


class StaticPageContext extends AttachedFilesContext
{
    protected $alias = 'page';
    protected $model = 'StaticPage';
    protected $table = 'static_pages';
}
