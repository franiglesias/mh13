<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\domain\ArticleSpecificationFactory;


class ArticleService
{
    /**
     * @var ArticleRepository
     */
    private $repository;
    /**
     * @var ArticleSpecificationFactory
     */
    private $articleSpecificationFactory;


    public function __construct(ArticleSpecificationFactory $articleSpecificationFactory)
    {
        $this->articleSpecificationFactory = $articleSpecificationFactory;
    }

    public function getArticle($slug)
    {
        $query = $this->articleSpecificationFactory->createPublishedArticleWithSlug($slug);

        return $query->fetch();
    }
}
