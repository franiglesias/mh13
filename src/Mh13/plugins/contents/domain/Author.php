<?php

namespace Mh13\plugins\contents\domain;

class Author
{
    private $id;
    private $realname;
    private $email;
    private $access;

    public function __construct($id, $realname, $email, $access)
    {
        $this->id = $id;
        $this->realname = $realname;
        $this->email = $email;
        $this->access = $access;
    }

    public static function fromCakeResult(array $data)
    {
        $author = new static(
            $data['User']['id'],
            $data['User']['realname'],
            $data['User']['email'],
            $data['Owner']['access']
        );

        return $author;
    }

    public function getRealname()
    {
        return $this->realname;
    }

    public function isEqual(Author $other)
    {
        return $this->getId() === $other->getId();
    }

    private function getId()
    {
        return $this->id;
    }
}
