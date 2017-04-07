<?php

namespace Mh13\plugins\contents\infrastructure\persistence\cakephp;

use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\domain\ArticleId;


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
        $item = $data['Item'];
        $articleId = new ArticleId($item['id']);
        $content = new ArticleContent($item['title'], $item['content']);
        $article = new Article($articleId, $content);
        if ($item['expiration']) {
            $article->setToExpireAt(new \DateTimeImmutable($item['expiration']));
        }
        $article->publish(new \DateTimeImmutable($item['pubDate']));
        return $article;
    }
}
