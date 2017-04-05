<?php

namespace Mh13\plugins\contents\services;

use Mh13\plugins\access\services\OwnerService;
use Mh13\plugins\contents\domain\Author;


/**
 * Class AuthorService
 *
 * Answers questions about Authors of articles|items
 *
 * @package Mh13\plugins\contents\services
 */
class AuthorService
{

    private $ownable;

    /**
     * AuthorService constructor.
     *
     * @param OwnerService $ownable
     */
    public function __construct(OwnerService $ownable)
    {
        $this->ownable = $ownable;
    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function authorsForArticle($article)
    {
        $authors = $this->ownable->owners($article, 'User');
        return array_map(function($author) {
            return Author::fromCakeResult($author);
        }, $authors);
    }

    /**
     * @param $channel
     *
     * @return array
     */
    public function authorsInChannel($channel)
    {
        $data = $this->ownable->owners($channel, 'User');

        return array_map(function($author) {
           return Author::fromCakeResult($author);
        }, $data);
    }

    public function cantidateAuthorsForArticle($article)
    {
        $all = $this->authorsInChannel($channel);
        $authors = $this->authorsForArticle($article);

        return array_filter($all, function($author) use($authors) {
            return !in_array($author, $authors);
        });
    }




}
