<?php

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;

use Mh13\plugins\contents\application\readmodel\BlogReadModel;
use Mh13\plugins\contents\exceptions\InvalidBlog;


class DbalBlogReadModel implements BlogReadModel
{


    public function getBlog($specification)
    {
        $statement = $specification->getQuery()->execute();
        $blog = $statement->fetch();
        if (!$blog) {
            throw InvalidBlog::message('That blog does not exist.');
        }
        return $blog;


    }


}
