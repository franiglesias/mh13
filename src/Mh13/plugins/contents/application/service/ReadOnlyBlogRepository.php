<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 18:07
 */

namespace Mh13\plugins\contents\application\service;

interface ReadOnlyBlogRepository
{
    public function getBlog(string $slug);
}
