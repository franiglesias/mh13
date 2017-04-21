<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\BlogRepository;


class BlogService
{
    /**
     * @var BlogRepository
     */
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getBlog(string $slug)
    {
        $blog = $this->blogRepository->getBySlugOrFail($slug);

        return [
            'id' => $blog->getId(),
            'title' => $blog->getTitle(),
            'slug' => $blog->getSlug(),
            'icon' => $blog->getIcon(),
            'tagline' => $blog->getTagline(),
            'description' => $blog->getDescription(),
            'image' => $blog->getImage(),
        ];
    }


}
