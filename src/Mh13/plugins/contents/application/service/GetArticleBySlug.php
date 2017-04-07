<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\ArticleRepository;


class GetArticleBySlug
{
    /**
     * @var ArticleRepository
     */
    private $repository;
    /**
     * @var SlugService
     */
    private $slugService;

    public function __construct(ArticleRepository $repository, SlugService $slugService)
    {
        $this->repository = $repository;
        $this->slugService = $slugService;
    }

    public function execute(ArticleRequest $request)
    {
        $id = $this->slugService->mapToId($request->getSlug());

        return $this->repository->retrieve($id);
    }
}
