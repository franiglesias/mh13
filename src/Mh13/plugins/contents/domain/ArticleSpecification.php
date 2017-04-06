<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 6/4/17
 * Time: 12:56
 */

namespace Mh13\plugins\contents\domain;


interface ArticleSpecification
{
    public function isSatisfiedBy(Article $article);


}
