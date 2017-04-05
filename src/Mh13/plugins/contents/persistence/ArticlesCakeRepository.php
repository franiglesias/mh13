<?php

namespace Mh13\plugins\contents\persistence;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\shared\persistence\CakeStore;


class ArticlesCakeRepository implements ArticleRepository
{
    /**
     * @var CakeStore
     */
    private $store;
    /**
     * @var ArticleMapper
     */
    private $mapper;

    public function __construct(CakeStore $store, ArticleMapper $mapper)
    {
        $this->store = $store;

        $this->mapper = $mapper;
    }

    /**
     * @param Article $article
     *
     * @return void
     */
    public function store(Article $article)
    {
        $dataArray = $this->mapper->toArray($article);
        $this->store->save($dataArray);

    }

    /**
     * @param ArticleId $articleId
     *
     * @return Article
     */
    public function retrieve(ArticleId $articleId)
    {
        $dataArray = $this->store->read(null, $articleId->getId());
        return $this->mapper->toArticle($dataArray);

    }
}
