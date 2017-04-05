<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 5/4/17
 * Time: 18:39
 */

namespace Mh13\plugins\contents\domain;


use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleId;


interface ArticleRepository
{
    public function store(Article $article);

    public function retrieve(ArticleId $articleId);

}
