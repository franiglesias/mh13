<?php

namespace Mh13\plugins\contents\domain;

class ArticleId
{
    /**
     * @var string
     */
    private $id;

    /**
     * ArticleId constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


}
