<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 19/4/17
 * Time: 17:01
 */

namespace Mh13\plugins\contents\infrastructure\persistence\dbal\article;


use Doctrine\DBAL\Connection;
use Mh13\plugins\contents\application\readmodel\ArticleReadModel;
use Mh13\plugins\contents\exceptions\ArticleNotFound;
use Mh13\plugins\contents\infrastructure\persistence\dbal\DBalSpecification;


class DBalArticleReadModel implements ArticleReadModel
{
    const OFFSET = 0;
    const MAX_ROWS = 15;
    protected $bringMainImage;
    /**
     * @var Connection
     */
    private $connection;
    private $keepStickOnTop = true;
    private $offset = self::OFFSET;
    private $max = self::MAX_ROWS;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->bringMainImage = "SELECT id FROM uploads WHERE model = 'Item' AND foreign_key = article.id AND type LIKE  'image%' ORDER BY uploads.order LIMIT 1";

    }

    /**
     * @param DBalSpecification $specification
     *
     * @return mixed
     * @throws ArticleNotFound
     */
    public function getArticle($specification)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select('article.*', 'blog.slug as blog_slug', 'image.path as image')
            ->from('items', 'article')
            ->leftJoin('article', 'blogs', 'blog', 'article.channel_id = blog.id')
            ->leftJoin('article', 'uploads', 'image', 'image.id = ('.$this->bringMainImage.')')
            ->where($specification->getConditions())
            ->setParameters($specification->getParameters(), $specification->getTypes())
        ;

        $article = $builder->execute()->fetch();
        if (!$article) {
            throw ArticleNotFound::message('Article was not found.');
        }

        return $article;
    }


    /**
     * @param DBalSpecification $specification
     *
     * @return array
     * @internal param ArticleRequest $request
     *
     */
    public function findArticles($specification)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select(
            'article.id as id',
            'article.slug as slug',
            'article.title as title',
            'article.content as content',
            'article.pubDate as pubDate',
            'article.expiration as expiration',
            'article.featured as featured',
            'article.stick as sticky',
            'article.gallery as gallery',
            'blog.slug as blog_slug',
            'blog.title as blog_title',
            'image.path as image'
        )->from(
            'items',
            'article'
        )->leftJoin(
            'article',
            'blogs',
            'blog',
            'article.channel_id = blog.id'
        )->leftJoin(
            'article',
            'uploads',
            'image',
            'image.id = ('.$this->bringMainImage.')'

        )->where(
            $specification->getConditions()
        )->setParameters(
            $specification->getParameters(),
            $specification->getTypes()
        )
        ;
        if ($this->keepStickOnTop) {
            $builder->addOrderBy('article.stick', 'desc');
        }
        $builder->addOrderBy('article.pubDate', 'desc');

        $builder->setFirstResult($this->offset);
        $builder->setMaxResults($this->max);
        $statement = $builder->execute();

        return $statement->fetchAll();

    }

    public function count($specification)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder->select(
            'count(article.id) as count'
        )->from(
            'items',
            'article'
        )->leftJoin(
            'article',
            'blogs',
            'blog',
            'article.channel_id = blog.id'
        )->where(
            $specification->getConditions()
        )->setParameters(
            $specification->getParameters(),
            $specification->getTypes()
        )
        ;

        $result = $builder->execute()->fetch();

        return $result['count'];

    }


    public function ignoringStickFlag($ignore = false): ArticleReadModel
    {
        $this->keepStickOnTop = !$ignore;

        return $this;
    }

    public function from($offset): ArticleReadModel
    {
        $this->offset = $offset;

        return $this;
    }

    public function max($max): ArticleReadModel
    {
        $this->max = $max;

        return $this;
    }
}
