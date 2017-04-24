<?php
/**
 * Created by PhpStorm.
 * User: frankie
 * Date: 11/4/17
 * Time: 18:11
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\domain\Article;
use Mh13\plugins\contents\domain\ArticleContent;
use Mh13\plugins\contents\domain\ArticleId;
use Mh13\plugins\contents\domain\ArticleRepository;
use Mh13\plugins\contents\infrastructure\persistence\dbal\specification\article\DbalArticleSpecification;


class DbalArticleRepository implements ArticleRepository
{
    /**
     * @var Connection
     */
    private $dbal;

    /**
     * DbalArticleRepository constructor.
     *
     * @param Connection $dbal
     */
    public function __construct(Connection $dbal)
    {
        $this->dbal = $dbal;
    }


    public function store(Article $article)
    {
        // TODO: Implement store() method.
    }

    /**
     * @param ArticleId $articleId
     *
     * @return Article
     */
    public function retrieve(ArticleId $articleId)
    {
        $sql = 'select * from items where items.id = ?';
        $stmt = $this->dbal->executeQuery($sql, [$articleId->getId()]);
        $item = $stmt->fetch();
        $articleId = new ArticleId($item['id']);
        $content = new ArticleContent($item['title'], $item['content']);
        $article = new Article($articleId, $content);
        $article->publish(new \DateTimeImmutable($item['pubDate']));
        if ($item['expiration']) {
            $article->setToExpireAt(new \DateTimeImmutable($item['expiration']));
        }

        return $article;
    }

    public function nextIdentity()
    {
        return ArticleId::generate();
    }

    /**
     * @param DbalArticleSpecification $specification
     */
    public function findAll($specification)
    {
        $stmt = $specification->getQuery()->execute();
        return $stmt->fetchAll();
    }
}
