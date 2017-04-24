<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 13:02
 */

namespace Mh13\plugins\contents\domain;


use Mh13\plugins\contents\application\service\catalog\ArticleRequest;


interface ArticleSpecificationFactory
{
    public function createLastArticles();

    public function createFromCatalogRequest(ArticleRequest $catalogRequest);

    public function createPublishedArticleWithSlug(string $slug);

}
