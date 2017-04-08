<?php

namespace spec\Mh13\plugins\contents\application\service;

use Mh13\plugins\access\exceptions\OwnershipException;
use Mh13\plugins\access\services\Owned;
use Mh13\plugins\access\services\Owner;
use Mh13\plugins\access\services\OwnerService;
use Mh13\plugins\access\services\Permissions;
use Mh13\plugins\contents\application\service\AuthorService;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\Author;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class AuthorServiceSpec extends ObjectBehavior
{
    public function let(OwnerService $ownerService)
    {
        $this->beConstructedWith($ownerService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AuthorService::class);
    }

    public function it_returns_authors(OwnerService $ownerService, Article $article)
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
            new Author(1, 'Fran Iglesias', 'franiglesias@mac.com', 23),
        ];
        $ownerService->owners($article, 'User')->shouldBeCalled()->willReturn($authors);
        $this->authorsForArticle($article)->shouldBeLike($expected);
    }

    public function it_returns_authors_in_channel(OwnerService $ownerService, Article $article, $channel)
    {
        $article->getChannel()->shouldBeCalled()->willReturn($channel);
        $ownerService->owners($channel, 'User')->shouldBeCalled()->willReturn($this->getFixturesForAuthorsInChannel());
        $this->authorsInChannel($article)->shouldBeLike($this->getExpectationsForAuthorsInChannel());
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

    public function it_does_not_add_authors_if_something_goes_wrong(
        OwnerService $ownerService,
        Author $author,
        Article $article
    ) {
        $ownerService->addOwner(new Owned('Item', null),
                                new Owner('User', null),
                                new Permissions(19)
        )->willThrow(OwnershipException::message('strong'));
        $this->shouldThrow(OwnershipException::class)->during('addAuthorToArticle', [$author, $article]);
    }

    public function it_returns_candidate_authors_for_article(OwnerService $ownerService, Article $article, $channel)
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
        $article->getChannel()->willReturn($channel);
        $ownerService->owners($article, 'User')->shouldBeCalled()->willReturn($authors);
        $ownerService->owners($channel, 'User')->shouldBeCalled()->willReturn($this->getFixturesForAuthorsInChannel());
        $this->cantidateAuthorsForArticle($article)->shouldHaveCount(9);
    }

    public function it_adds_authors_to_article(OwnerService $ownerService, Article $article, Author $author)
    {
        $article->getId()->shouldBeCalled();
        $ownerService->addOwner(Argument::type(Owned::class), Argument::type(Owner::class), new Permissions(19))
            ->shouldBeCalled()
        ;
        $this->addAuthorToArticle($author, $article);
    }
}
