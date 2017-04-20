<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 20/4/17
 * Time: 16:55
 */

namespace Mh13\plugins\contents\domain;


interface BlogRepository
{
    public function getBySlugOrFail(string $slug): Blog;


}
