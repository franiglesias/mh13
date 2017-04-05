<?php

namespace spec\Mh13\plugins\contents\domain;

use Mh13\plugins\contents\domain\Author;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorSpec extends ObjectBehavior
{
    public function let()
    {
        $id = 'author01';
        $realname = 'Fran Iglesias';
        $email = 'franiglesias@example.com';
        $access = 23;
        $this->beConstructedWith($id, $realname, $email, $access);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Author::class);
    }

    public function it_can_be_created_from_cake_array()
    {
        $data = [
            'User' => [
                'id' => 'author01',
                'realname' => 'Fran Iglesias',
                'email' => 'franiglesias@mac.com',
            ],
            'Owner' => [
                'access' => 23
            ]
        ];
        $this->beConstructedThrough('fromCakeResult', [$data]);
        $this->getRealname()->shouldBe('Fran Iglesias');
    }

    public function it_compares_authors_for_equality()
    {
        $other = new Author(3, 'Example', 'example@example.com', 23);
        $same = new Author('author01', 'Example', 'example@example.com', 23);
        $this->shouldNotBeEqual($other);
        $this->shouldBeEqual($same);
    }
}
