<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 5/4/17
 * Time: 18:39
 */

namespace Mh13\plugins\contents\domain;


interface ArticleRepository
{
    /**
     * @param \Mh13\plugins\contents\domain\Article $article
     *
     * @return void
     */
    public function store(Article $article);

    /**
     * @param \Mh13\plugins\contents\domain\ArticleId $articleId
     *
     * @return Article
     */
    public function retrieve(ArticleId $articleId);

    /**
     * @return ArticleId
     */
    public function nextIdentity();

    public function findAll($specification);

}
