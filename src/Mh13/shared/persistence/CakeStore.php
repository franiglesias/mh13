<?php

namespace Mh13\shared\persistence;

interface CakeStore
{

    public function save($data);

    public function read($fields, $id);
}
