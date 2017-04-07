<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\ArticleId;


class SlugService
{
    public function mapToId($slug)
    {
        return new ArticleId($slug);
    }
}
