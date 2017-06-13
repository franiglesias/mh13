<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 28/4/17
 * Time: 19:13
 */

namespace Mh13\plugins\uploads\infrastructure\persistence\dbal\context;


use Mh13\plugins\uploads\application\UploadContextFactory;


class DBalUploadContextFactory implements UploadContextFactory
{
    /**
     * @param string $type
     */
    public function getContextFor(string $type)
    {
        switch (strtolower($type)) {
            case 'article':
                return new ArticleContextDBal();
            case 'collection':
                return new ImageCollectionContextDBal();
            case 'static':
                return new StaticPageContextDBal();
            default:
                return new DBalUploadContext();
        }
    }
}
