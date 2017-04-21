<?php

namespace Mh13\plugins\contents\domain;

interface BlogSpecificationFactory
{

    public function createBlogWithSlug(string $slug);
}
