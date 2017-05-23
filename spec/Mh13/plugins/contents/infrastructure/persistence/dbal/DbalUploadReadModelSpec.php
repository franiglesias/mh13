<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\dbal;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\UploadReadModel;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DbalUploadReadModel;
use PhpSpec\ObjectBehavior;


class DbalUploadReadModelSpec extends ObjectBehavior
{
    public function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DbalUploadReadModel::class);
        $this->shouldImplement(UploadReadModel::class);
    }
}
