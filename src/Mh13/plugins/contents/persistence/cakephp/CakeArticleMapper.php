<?php

namespace Mh13\plugins\contents\persistence\cakephp;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\Author;


class CakeArticleMapper
{

    /**
     * @param Article $article
     * @return array
     */
    public function toArray(Article $article) {

    }

    /**
     * @param array $data
     * @return Article
     */
    public function toArticle(array $data)
    {
        $articleId = new ArticleId($data['Item']['id']);
        $content = new ArticleContent($data['Item']['title'], $data['Item']['content']);
        $author = Author::fromCakeResult($data['Authors'][0]);
        $article = new Article($articleId, $content, $author);
        return $article;
    }
}
