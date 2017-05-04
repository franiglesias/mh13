<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 23/4/17
 * Time: 18:13
 */

namespace Mh13\plugins\contents\application\readmodel;


interface ArticleReadModel
{
    /**
     * @param $specification
     *
     * @return array
     * @internal param ArticleRequest $request
     *
     */
    public function getArticle($specification);

    public function findArticles($specification);

    public function ignoringStickFlag($ignore = false): ArticleReadModel;

    public function from($offset): ArticleReadModel;

    public function max($max): ArticleReadModel;

    public function count($specification);


}
