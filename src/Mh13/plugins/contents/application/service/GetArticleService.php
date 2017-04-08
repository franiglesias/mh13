<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ContentException;


class GetArticleService
{
    /**
     * @var ArticleRepository
     */
    private $repository;
    /**
     * @var SlugConverter
     */
    private $slugService;

    public function __construct(ArticleRepository $repository, SlugConverter $slugService)
    {
        $this->repository = $repository;
        $this->slugService = $slugService;
    }

    public function execute(GetArticleRequest $request)
    {
        try {
            $id = $this->slugService->mapToId($request->getSlug());

            return $this->repository->retrieve($id);

        } catch (SlugServiceException $exception) {
            throw ContentException::message($exception->getMessage());
        }
    }
}
