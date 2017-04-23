<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Mh13\plugins\contents\application\readmodel\BlogReadModel;


class DbalBlogReadModel implements BlogReadModel
{


    public function getBlog($specification)
    {
        $statement = $specification->getQuery()->execute();
        $blog = $statement->fetch();

        return $blog;


    }


}
