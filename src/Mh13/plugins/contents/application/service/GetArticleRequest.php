<?php

namespace Mh13\plugins\contents\application\service;

class GetArticleRequest
{
    /**
     * @var string
     */
    private $id;


    /**
     * GetArticleBySlugRequest constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
