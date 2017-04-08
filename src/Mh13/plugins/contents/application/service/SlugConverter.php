<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\infrastructure\persistence\SlugConverter\SlugRepository;


class SlugConverter
{
    /**
     * @var SlugRepository
     */
    private $slugRepository;

    public function __construct(SlugRepository $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    public function mapToId($slug)
    {
        return $this->slugRepository->getIdOfSlug($slug);
    }
}
