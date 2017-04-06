<?php

namespace Mh13\plugins\contents\application\service;

use Mh13\plugins\access\exceptions\OwnershipException;
use Mh13\plugins\access\services\Owned;
use Mh13\plugins\access\services\Owner;
use Mh13\plugins\access\services\OwnerService;
use Mh13\plugins\access\services\Permissions;
use Mh13\plugins\contents\domain\Article;
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

    /**
     * @var OwnerService
     */
    private $ownerService;

    /**
     * AuthorService constructor.
     *
     * @param OwnerService $ownable
     */
    public function __construct(OwnerService $ownable)
    {
        $this->ownerService = $ownable;
    }

    /**
     * @param Article $article
     *
     * @return Author[]
     */
    public function cantidateAuthorsForArticle(Article $article)
    {
        $all = $this->authorsInChannel($article);
        $authors = $this->authorsForArticle($article);

        return array_filter($all, function($author) use($authors) {
            return !in_array($author, $authors);
        });
    }

    /**
     * @param Article $article
     *
     * @return Author[]
     * @internal param $channel
     *
     */
    public function authorsInChannel(Article $article)
    {
        $authors = $this->ownerService->owners($article->getChannel(), 'User');

        return $this->mapResults($authors);
    }

    /**
     * @param $authors
     *
     * @return array
     */
    protected function mapResults($authors)
    {
        return array_map(
            function ($author) {
                return Author::fromCakeResult($author);
            },
            $authors
        );
    }

    /**
     * @param $model
     *
     * @return mixed
     */
    public function authorsForArticle($article)
    {
        $authors = $this->ownerService->owners($article, 'User');

        return $this->mapResults($authors);
    }

    /**
     * @param Author  $author
     * @param Article $article
     */
    public function addAuthorToArticle(Author $author, Article $article)
    {
        try {
            $owned = new Owned('Item', $article->getId());
            $owner = new Owner('User', $author->getId());
            $this->ownerService->addOwner($owned, $owner, new Permissions(19));
        } catch (OwnershipException $exception) {
            throw $exception;
        }
    }


}
