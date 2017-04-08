<?php

namespace Mh13\plugins\contents\application\service;

class GetArticleRequest
{
    /**
     * @var string
     */
    private $slug;


    /**
     * GetArticleBySlugRequest constructor.
     *
     * @param string $slug
     */
    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
