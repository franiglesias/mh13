<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 28/4/17
 * Time: 19:17
 */

namespace Mh13\plugins\uploads\infrastructure\persistence\dbal\specification;


use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContext;


class AttachedDownloads extends CompositeDbalSpecification
{

    /**
     * @var \Mh13\plugins\uploads\infrastructure\persistence\dbal\context\DBalUploadContext
     */
    private $context;

    public function __construct(DBalUploadContext $context, string $slug)
    {
        $this->setParameter('slug', $slug, 'string');
        $this->context = $context;
    }

    public function getConditions()
    {
        return $this->context->getAlias(
            ).".slug = :slug AND upload.type NOT LIKE 'image%' AND upload.type NOT LIKE 'video%' AND upload.type NOT LIKE 'audio%'";
    }
}
