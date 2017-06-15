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
                return new DBalArticleContext();
            case 'collection':
                return new DBalImageCollectionContext();
            case 'static':
                return new DBalStaticPageContext();
            default:
                return new DBalUploadContext();
        }
    }
}
