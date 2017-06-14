<?php

namespace spec\Mh13\plugins\uploads\infrastructure\persistence\dbal;

use Doctrine\DBAL\Connection;
use Mh13\plugins\uploads\application\UploadReadModel;
use Mh13\plugins\uploads\infrastructure\persistence\dbal\DbalUploadReadModel;
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
