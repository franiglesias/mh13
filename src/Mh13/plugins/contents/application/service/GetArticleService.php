<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ContentException;


class GetArticleService
{
    /**
     * @var ArticleRepository
     */
    private $repository;


    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetArticleRequest $request)
    {
        try {
            $id = new ArticleId($request->getId());

            return $this->repository->retrieve($id);

        } catch (SlugServiceException $exception) {
            throw ContentException::message($exception->getMessage());
        }
    }
}
