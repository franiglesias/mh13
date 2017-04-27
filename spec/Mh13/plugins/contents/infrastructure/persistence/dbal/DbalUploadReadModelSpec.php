<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\dbal;

use Mh13\plugins\contents\application\readmodel\UploadReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalUploadReadModel;
use PhpSpec\ObjectBehavior;


class DbalUploadReadModelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DbalUploadReadModel::class);
        $this->shouldImplement(UploadReadModel::class);
    }
}
