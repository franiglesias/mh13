<?php

namespace Mh13\plugins\contents\domain;

class Article
{
    const PUBLISHED = 2;
    const DRAFT = 0;
    /**
     * @var int
     */
    protected $status;
    /**
     * @var \DateTimeInterface
     */
    protected $pubDate;

    /**
     * @var ArticleId
     */
    private $articleId;
    /**
     * @var ArticleContent
     */
    private $content;
    /**
     * @var Author[]
     */
    private $authors;

    public function __construct(ArticleId $articleId, ArticleContent $content, Author $author)
    {
        $this->articleId = $articleId;
        $this->content = $content;
        $this->status = self::DRAFT;
        $this->addAuthor($author);
    }

    public function addAuthor(Author $author)
    {
        if ($this->isNewAuthor($author)) {
            $this->authors[] = $author;
        }
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    private function isNewAuthor(Author $author)
    {
        return empty($this->authors) || !in_array($author, $this->authors);
    }

    public function removeAuthor(Author $author)
    {
        if (count($this->authors) == 1) {
            return;
        }
        $this->authors = array_filter($this->authors, function(Author $test) use ($author) {
            return $test->isEqual($author) ? false: true;
        });
    }

    public function modify(ArticleContent $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function publish()
    {
        $this->status = self::PUBLISHED;
        $this->pubDate = new \DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }



}
