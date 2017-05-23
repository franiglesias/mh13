<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\dbal\upload;

use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\UploadReadModel;
use PhpSpec\ObjectBehavior;


class DbalUploadReadModelSpec extends ObjectBehavior
{
    public function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(\Mh13\plugins\contents\infrastructure\persistence\dbal\upload\DbalUploadReadModel::class);
        $this->shouldImplement(UploadReadModel::class);
    }
}
