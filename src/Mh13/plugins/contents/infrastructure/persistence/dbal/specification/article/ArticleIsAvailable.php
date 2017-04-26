<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 26/4/17
 * Time: 15:42
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article;


use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\CompositeDbalSpecification;


class ArticleIsAvailable extends CompositeDbalSpecification
{
    public function __construct(ExpressionBuilder $expressionBuilder)
    {

        $this->setParameter('published', Article::PUBLISHED);
        $this->expressionBuilder = $expressionBuilder;
    }

    public function getConditions()
    {

        return 'article.status = :published and article.pubDate <= now() and (article.expiration is null or article.expiration > now() ) and blog.active = 1';
    }
}
