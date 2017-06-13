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


class AttachedMedia extends CompositeDbalSpecification
{

    /**
     * @var DBalUploadContext
     */
    private $context;

    public function __construct(DBalUploadContext $context, string $slug)
    {
        $this->setParameter('slug', $slug, 'string');
        $this->context = $context;
    }

    public function getConditions()
    {
        return $this->context->getAlias().".slug = :slug AND (upload.type LIKE 'audio%' or upload.type LIKE 'video%')";
    }
}
