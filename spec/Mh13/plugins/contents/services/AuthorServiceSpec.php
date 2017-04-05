<?php

namespace spec\Mh13\plugins\contents\services;

use Mh13\plugins\access\services\OwnerService;
use Mh13\plugins\contents\domain\Author;
use Mh13\plugins\contents\services\AuthorService;
use PhpSpec\ObjectBehavior;


class AuthorServiceSpec extends ObjectBehavior
{
    public function let(OwnerService $ownable)
    {
        $this->beConstructedWith($ownable);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthorService::class);
    }

    public function it_returns_authors(OwnerService $ownable, $article)
    {

        $authors = [
            [
                'User' => [
                    'id' => 1,
                    'realname' => 'Fran Iglesias',
                    'email' => 'franiglesias@mac.com',
                ],
                'Owner' => [
                    'access' => 23,
                ],
            ],
        ];
        $expected = [
            new Author(1, 'Fran Iglesias', 'franiglesias@mac.com', 23)
        ];
        $ownable->owners($article, 'User')->shouldBeCalled()->willReturn($authors);
        $this->authorsForArticle($article)->shouldBeLike($expected);
    }

    public function it_returns_authors_in_channel(OwnerService $ownable, $channel)
    {
        $ownable->owners($channel, 'User')->shouldBeCalled()->willReturn($this->getFixturesForAuthorsInChannel());
        $this->authorsInChannel($channel)->shouldBeLike($this->getExpectationsForAuthorsInChannel());
    }

    private function getFixturesForAuthorsInChannel()
    {
        $data = [];
        for ($id = 1; $id <= 10; $id++) {
            $data[] = [
                'User' => [
                    'id' => $id,
                    'realname' => 'Fran Iglesias',
                    'email' => 'franiglesias@mac.com',
                ],
                'Owner' => [
                    'access' => 23,
                ],
            ];
        }

        return $data;
    }

    private function getExpectationsForAuthorsInChannel()
    {
        $data = [];
        for ($id = 1; $id <= 10; $id++) {
            $data[] = new Author($id, 'Fran Iglesias', 'franiglesias@mac.com', 23);
        }

        return $data;
    }

    public function it_returns_candidate_authors_for_article(OwnerService $ownable, $article)
    {
        $authors = [
            [
                'User' => [
                    'id' => 3,
                    'realname' => 'Fran Iglesias',
                    'email' => 'franiglesias@mac.com',
                ],
                'Owner' => [
                    'access' => 23,
                ],
            ],
        ];
        $ownable->owners($article, 'User')->shouldBeCalled()->willReturn($this->getFixturesForAuthorsInChannel());
        $ownable->owners($channel, 'User')->shouldBeCalled()->willReturn($authors);
        $this->cantidateAuthorsForArticle($article)->shouldHaveCount(9);
    }
}
