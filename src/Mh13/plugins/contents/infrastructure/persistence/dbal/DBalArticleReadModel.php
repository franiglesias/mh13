<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 17:01
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Mh13\plugins\contents\application\readmodel\ArticleReadModel;
use Mh13\plugins\contents\application\service\article\ArticleRequest;
use Mh13\plugins\contents\exceptions\ArticleNotFound;


class DBalArticleReadModel implements ArticleReadModel
{


    public function getArticle($specification)
    {
        $statement = $specification->getQuery()->execute();
        $article = $statement->fetch();
        if (!$article) {
            throw ArticleNotFound::message('Article was not found.');
        }

        return $article;
    }

    /**
     * @param ArticleRequest $request
     *
     * @return array
     */
    public function findArticles($specification)
    {
        $statement = $specification->getQuery()->execute();

        return $statement->fetchAll();

    }


}
