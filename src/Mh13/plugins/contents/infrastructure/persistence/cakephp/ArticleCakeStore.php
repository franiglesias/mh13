<?php

namespace Mh13\plugins\contents\infrastructure\persistence\cakephp;

use Mh13\shared\persistence\CakeStore;


class ArticleCakeStore implements CakeStore
{
    private $Item;

    /**
     * ArticleCakeStore constructor.
     *
     * @param $Item
     */
    public function __construct($Item)
    {
        $this->Item = $Item;
    }


    public function save($data)
    {
        $this->Item->save($data);
    }

    public function read($fields, $id)
    {
        return $this->Item->read($fields, $id);
    }
}
