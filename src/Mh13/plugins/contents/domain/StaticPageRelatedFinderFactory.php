<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 10:28
 */

namespace Mh13\plugins\contents\domain;


interface StaticPageRelatedFinderFactory
{

    public function createFindParentsForPageWithSlug(string $slug);

    public function createFindDescendantsForPageWithSlug(string $slug);

    public function createFindDescendantsWithDepthForPageWithSlug(string $slug);

    public function createFindSiblingsForPageWithSlug(string $slug);

}
