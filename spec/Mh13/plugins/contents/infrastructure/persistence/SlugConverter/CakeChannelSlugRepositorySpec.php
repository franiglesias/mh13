<?php

namespace spec\Mh13\plugins\contents\infrastructure\persistence\SlugConverter;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Mh13\plugins\contents\infrastructure\persistence\SlugConverter\CakeItemSlugRepository;
use Mh13\plugins\contents\infrastructure\persistence\SlugConverter\SlugRepository;
use PhpSpec\ObjectBehavior;


class CakeItemSlugRepositorySpec extends ObjectBehavior
{
    public function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CakeItemSlugRepository::class);
        $this->shouldImplement(SlugRepository::class);
    }

    public function it_returns_an_id_given_a_slug(Connection $connection, Statement $statement)
    {
        $connection->executeQuery('select id from channels where slug = ?', ['slug'])->shouldBeCalled()->willReturn(
            $statement
        )
        ;
        $statement->fetch()->shouldBeCalled()->willReturn(['id' => 'id']);

        $this->getIdOfSlug('slug')->shouldBe('id');
    }


}
