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
    private $pubDate;
    /**
     * @var \DateTimeInterface
     */
    private $expiration;
    /**
     * @var ArticleId
     */
    private $articleId;
    /**
     * @var ArticleContent
     */
    private $content;

    private $channel;

    public function __construct(ArticleId $articleId, ArticleContent $content)
    {
        $this->articleId = $articleId;
        $this->content = $content;
        $this->status = self::DRAFT;
    }

    public function modify(ArticleContent $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function publish(\DateTimeInterface $date = null)
    {
        $this->status = self::PUBLISHED;
        $this->pubDate = $date ? $date : new \DateTimeImmutable();
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

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    public function getId()
    {
        return $this->articleId->getId();
    }

    /**
     * @return \DateTimeInterface
     */
    public function willExpireAt()
    {
        return $this->expiration;
    }

    /**
     * @param \DateTimeInterface $expiration
     */
    public function setToExpireAt(\DateTimeInterface $expiration)
    {
        $this->expiration = $expiration;
    }




}
