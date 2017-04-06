<?php

namespace Mh13\plugins\contents\domain;

class Blog
{
    /**
     * @var BlogId
     */
    private $blogId;
    private $title;
    private $tagline;
    private $description;

    public function __construct(BlogId $blogId, $title, $tagline, $description)
    {
        $this->blogId = $blogId;
        $this->title = $title;
        $this->tagline = $tagline;
        $this->description = $description;
    }
}
