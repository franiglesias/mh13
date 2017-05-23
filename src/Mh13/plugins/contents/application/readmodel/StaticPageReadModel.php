<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 24/4/17
 * Time: 10:25
 */

namespace Mh13\plugins\contents\application\readmodel;


interface StaticPageReadModel
{
    public function getPage($specification);

    public function findPages($specification);

    public function findRelated($relatedQuery);


}
