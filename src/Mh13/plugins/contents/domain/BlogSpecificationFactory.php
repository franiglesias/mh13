<?php

namespace Mh13\plugins\contents\domain;

interface BlogSpecificationFactory
{

    public function createBlogWithSlug(string $slug);

    public function createBlogIsExternal();

    public function createBlogIsActive();

    public function createPublicBlogs();
}
