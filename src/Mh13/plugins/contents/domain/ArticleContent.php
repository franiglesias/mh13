<?php

namespace Mh13\plugins\contents\domain;

use Mh13\plugins\contents\exceptions\InvalidArticleContentBody;
use Mh13\plugins\contents\exceptions\InvalidArticleContentTitle;


class ArticleContent
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $body;

    /**
     * ArticleContent constructor.
     *
     * @param string $title
     * @param string $body
     */
    public function __construct($title, $body)
    {
        $this->assertValidTitle($title);
        $this->assertValidBody($body);
        $this->title = $title;
        $this->body = $body;
    }

    private function assertValidTitle($title)
    {
        if (!$title) {
            throw InvalidArticleContentTitle::message('"%s" is not a valid title for an article');
        }
    }

    private function assertValidBody($body)
    {
        if (!$body) {
            throw InvalidArticleContentBody::message('"%s" is not a valid body for an article');
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }


}
