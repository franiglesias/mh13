<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 28/4/17
 * Time: 19:17
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\upload;


use Mh13\plugins\contents\application\service\upload\AttachedFilesContext;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class AttachedImages extends CompositeDbalSpecification
{

    /**
     * @var AttachedFilesContext
     */
    private $context;

    public function __construct(AttachedFilesContext $context, string $slug)
    {
        $this->setParameter('slug', $slug, 'string');
        $this->context = $context;
    }

    public function getConditions()
    {
        return $this->context->getAlias().'.slug = :slug AND upload.type LIKE \'image%\'';
    }
}
