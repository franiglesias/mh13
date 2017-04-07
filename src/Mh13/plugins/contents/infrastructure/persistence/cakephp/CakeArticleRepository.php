<?php

namespace Mh13\plugins\contents\infrastructure\persistence\cakephp;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\exceptions\ArticleNotFound;
use Mh13\shared\persistence\CakeStore;


class CakeArticleRepository implements ArticleRepository
{
    /**
     * @var CakeStore
     */
    private $store;
    /**
     * @var CakeArticleMapper
     */
    private $mapper;

    public function __construct(CakeStore $store, CakeArticleMapper $mapper)
    {
        $this->store = $store;

        $this->mapper = $mapper;
    }

    /**
     * @return mixed
     */
    public function nextIdentity()
    {
        return ArticleId::generate();
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
        if (!$dataArray) {
            throw ArticleNotFound::message(sprintf('Article with id %s not found.', $articleId->getId()));
        }
        return $this->mapper->toArticle($dataArray);

    }
}
