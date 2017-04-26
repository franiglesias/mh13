<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 10:28
 */

namespace Mh13\plugins\contents\domain;


interface StaticPageSpecificationFactory
{
    public function createGetPageWithSlug(string $slug);

    public function createGetParentsForPageWithSlug(string $slug);

    public function createGetDescendantsForPageWithSlug(string $slug);

    public function createGetDescendantsWithDepthForPageWithSlug(string $slug);

}
