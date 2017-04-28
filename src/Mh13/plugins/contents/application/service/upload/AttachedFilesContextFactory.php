<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 28/4/17
 * Time: 19:13
 */

namespace Mh13\plugins\contents\application\service\upload;


class AttachedFilesContextFactory
{
    /**
     * @param string $type
     */
    public function getContextFor(string $type)
    {
        switch (strtolower($type)) {
            case 'article':
                return new ArticleContext();
            case 'collection':
                return new ImageCollectionContext();
            case 'static':
                return new StaticPageContext();
            default:
                return new AttachedFilesContext();
        }
    }
}
