<?php

namespace Mh13\plugins\contents\domain;

use Ramsey\Uuid\Uuid;


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

    static public function generate()
    {
        $id = Uuid::uuid4()->toString();

        return new static($id);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}
