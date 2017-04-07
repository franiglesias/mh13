<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\cakephp;

use Mh13\plugins\contents\infrastructure\persistence\cakephp\ArticleCakeStore;
use PhpSpec\ObjectBehavior;


class ArticleCakeStoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ArticleCakeStore::class);
    }
}
