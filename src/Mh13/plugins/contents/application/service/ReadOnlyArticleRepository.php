<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 18:13
 */

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\contents\application\service\catalog\ArticleRequest;


interface ReadOnlyArticleRepository
{
    /**
     * @param ArticleRequest $request
     *
     * @return array
     */
    public function getArticles(ArticleRequest $request);

    public function getArticleBySlug(string $slug);


}
