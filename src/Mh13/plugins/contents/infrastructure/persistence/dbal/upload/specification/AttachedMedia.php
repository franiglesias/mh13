<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 28/4/17
 * Time: 19:17
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\upload\specification;


use Mh13\plugins\contents\application\service\upload\UploadContext;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class AttachedMedia extends CompositeDbalSpecification
{

    /**
     * @var UploadContext
     */
    private $context;

    public function __construct(UploadContext $context, string $slug)
    {
        $this->setParameter('slug', $slug, 'string');
        $this->context = $context;
    }

    public function getConditions()
    {
        return $this->context->getAlias().".slug = :slug AND (upload.type LIKE 'audio%' or upload.type LIKE 'video%')";
    }
}
